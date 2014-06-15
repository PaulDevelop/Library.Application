<?php

namespace Com\PaulDevelop\Library\Application;

use \Com\PaulDevelop\Library\Common\Base;
use Negotiation\FormatNegotiator;

/**
 * RequestInput
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 *
 * @property string $Method
 * @property string $Protocol
 * @property string $Subdomains
 * @property string $Domain
 * @property string $Port
 * @property string $Path
 * @property string $Format
 */
class RequestInput extends Base implements IRequestInput
{
    private $method;
    private $protocol;
    private $subdomains;
    private $domain;
    private $port;
    private $path;
    private $format;

    public function __construct($url = '')
    {
        $this->method = '';
        $this->protocol = '';
        $this->subdomains = '';
        $this->domain = '';
        $this->port = '';
        $this->path = '';
        $this->format = '';

        // method
        if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->method = HttpVerbs::GET;
            } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
                $this->method = HttpVerbs::PUT;
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->method = HttpVerbs::POST;
            } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $this->method = HttpVerbs::DELETE;
            }
        }

        // format
        if (array_key_exists('HTTP_ACCEPT', $_SERVER) && !empty($_SERVER['HTTP_ACCEPT'])) {
            $reflectionObj = new \ReflectionObject(new Formats());
            $negotiator = new FormatNegotiator();
            $acceptHeader = $_SERVER['HTTP_ACCEPT'];
            $priorities = $reflectionObj->getConstants();
            $this->format = $negotiator->getBest($acceptHeader, $priorities)->getValue();
        }
        if (array_key_exists('HTTP_PDT_ACCEPT', $_SERVER) && !empty($_SERVER['HTTP_PDT_ACCEPT'])) {
            $this->format = $_SERVER['HTTP_PDT_ACCEPT'];
        }

        // parse url
        if ($url == '') {
            $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        $parts = parse_url($url);
        //var_dump($parts);

        // protocol
        if (array_key_exists('scheme', $parts)) {
            $this->protocol = $parts['scheme'];
        }

        // subdomains
        if (array_key_exists('host', $parts)) {
            $chunks = preg_split('/\./', $parts['host'], -1, PREG_SPLIT_NO_EMPTY);
            //var_dump($chunks);
            $this->subdomains = implode('.', array_slice($chunks, 0, count($chunks) - 2));
            //var_dump($this->subdomains);
        }

        // host
        if (array_key_exists('host', $parts)) {
            if ($this->subdomains == '') {
                $this->domain = $parts['host'];
            } else {
                $this->domain = substr($parts['host'], strlen($this->subdomains) + 1);
            }
        }

        // port
        if (array_key_exists('port', $parts)) {
            $this->port = $parts['port'];
        }

        if (array_key_exists('path', $parts)) {
            $this->path = $parts['path'];
        }
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function getSubdomains()
    {
        return $this->subdomains;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getFormat()
    {
        return $this->format;
    }
}

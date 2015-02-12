<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;
use Negotiation\FormatNegotiator;

/**
 * RequestInput
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 *
 * @property string              $BaseUrl
 * @property string              $Host
 * @property string              $Url
 * @property string              $Method
 * @property string              $Protocol
 * @property string              $Subdomains
 * @property string              $Domain
 * @property string              $Port
 * @property string              $Path
 * @property string              $Format
 * @property ParameterCollection $GetParameter
 * @property ParameterCollection $PostParameter
 * @property ParameterCollection $PatchParameter
 * @property ParameterCollection $HeaderParameter
 */
class RequestInput extends Base implements IRequestInput
{
    private $baseUrl;
    private $host;
    private $url;
    private $method;
    private $protocol;
    private $subdomains;
    private $domain;
    private $port;
    private $path;
    private $format;
    private $getParameter;
    private $postParameter;
    private $patchParameter;
    private $headerParameter;

    public function __construct($baseUrl = '', $url = '')
    {
        $this->baseUrl = $baseUrl;
        $this->host = '';
        $this->method = '';
        $this->protocol = '';
        $this->subdomains = '';
        $this->domain = '';
        $this->port = '';
        $this->path = '';
        $this->format = '';
        $this->getParameter = new ParameterCollection();
        $this->postParameter = new ParameterCollection();
        $this->patchParameter = new ParameterCollection();
        $this->headerParameter = new ParameterCollection();

        // method
        if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->method = HttpVerbs::GET;
            } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
                $this->method = HttpVerbs::PUT;
            } elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
                $this->method = HttpVerbs::PATCH;
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
        $this->url = $url;

        $urlParts = parse_url($url);
        //var_dump($parts);

        // protocol
        if (array_key_exists('scheme', $urlParts)) {
            $this->protocol = $urlParts['scheme'];
        }

//        // subdomains
//        if (array_key_exists('host', $parts)) {
//            $chunks = preg_split('/\./', $parts['host'], -1, PREG_SPLIT_NO_EMPTY);
//            //var_dump($chunks);
//            $this->subdomains = implode('.', array_slice($chunks, 0, count($chunks) - 2));
//            //var_dump($this->subdomains);
//        }

        // subdomains
        if (array_key_exists('host', $urlParts)) {
            $chunks = preg_split('/\./', $urlParts['host'], -1, PREG_SPLIT_NO_EMPTY);
            $urlSubdomains = implode('.', array_slice($chunks, 0, count($chunks) - 2));

            $baseUrlParts = parse_url($baseUrl);
            if (array_key_exists('host', $baseUrlParts)) {
                $chunks = preg_split('/\./', $baseUrlParts['host'], -1, PREG_SPLIT_NO_EMPTY);
                $baseUrlSubdomains = implode('.', array_slice($chunks, 0, count($chunks) - 2));

                // subdomains = baseUrl.Subdomains - url.Subdomains
                $this->subdomains =
                    trim(substr($urlSubdomains, 0, strlen($urlSubdomains) - strlen($baseUrlSubdomains)), '.');
            }
        }

        // host
        $baseUrlParts = parse_url($baseUrl);
        if (array_key_exists('host', $baseUrlParts)) {
            $this->host = $baseUrlParts['host'];
            //echo "HOST: ".$this->host.PHP_EOL;
        }

        // domain
        if (array_key_exists('host', $urlParts)) {
            if ($this->subdomains == '') {
                $this->domain = $urlParts['host'];
            } else {
                $this->domain = substr($urlParts['host'], strlen($this->subdomains) + 1);
            }
        }

        // port
        if (array_key_exists('port', $urlParts)) {
            $this->port = $urlParts['port'];
        }

        // path
        if (array_key_exists('path', $urlParts)) {
            $this->path = $urlParts['path'];
            $this->path = trim($this->path, '/').'/';
        }

        // get parameter
        foreach ($_GET as $key => $value) {
            $this->getParameter->add(new Parameter($key, $value), $key);
        }

        // post parameter
        foreach ($_POST as $key => $value) {
            $this->postParameter->add(new Parameter($key, $value), $key);
        }

        // patch parameter
        // get parameter
        foreach ($_GET as $key => $value) {
            $this->patchParameter->add(new Parameter($key, $value), $key);
        }

        // header parameter
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$key] = $value;
            } else {
                if ($key == "CONTENT_TYPE") {
                    $headers["Content-Type"] = $value;
                } else {
                    if ($key == "CONTENT_LENGTH") {
                        $headers["Content-Length"] = $value;
                    }
                }
            }
        }
        foreach ($headers as $key => $value) {
            $this->headerParameter->add(new Parameter($key, $value), $key);
        }
//        foreach (getallheaders() as $key => $value) {
//            $this->headerParameter->add(new Parameter($key, $value), $key);
//        }
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getUrl()
    {
        return $this->url;
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

    public function getGetParameter()
    {
        return $this->getParameter;
    }

    public function getPostParameter()
    {
        return $this->postParameter;
    }

    public function getPatchParameter()
    {
        return $this->patchParameter;
    }

    public function getHeaderParameter()
    {
        return $this->headerParameter;
    }
}

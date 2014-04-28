<?php

namespace Com\PaulDevelop\Library\Application;

use
    Com\PaulDevelop\Library\Common\Base;

/**
 * RequestProcessedEventHandler
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property $Object
 * @property $Method
 */
class RequestProcessedEventHandler extends Base
{
    /**
     * RequestHandler
     *
     * @var \Com\PaulDevelop\Library\Application\RequestHandler
     */
    private $object;

    /**
     * @var string
     */
    private $method;

    /**
     * @param RequestHandler $object
     * @param string         $method
     */
    public function __construct(
        RequestHandler $object = null,
        $method = ''
    ) {
        $this->object = $object;
        $this->method = $method;
    }

    /**
     * @return RequestHandler
     */
    protected function getObject()
    {
        return $this->object;
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return $this->method;
    }
}

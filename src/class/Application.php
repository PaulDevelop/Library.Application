<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * Application
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property $Request
 */
class Application extends Base
{
    #region events
    /**
     * RequestProcessedHandler
     *
     * @var RequestProcessedEventHandlerCollection
     */
    protected $requestProcessedHandler;
    #endregion

    #region member
    /**
     * Contains request information.
     * @var Request
     */
    protected $request;

    ///**
    // * Contains single instance.
    // * @var Application
    // */
    //protected static $instance = null;

    #endregion

    #region constructor
    /**
     * Default constructor.
     */
    public function __construct()
    {
        $this->requestProcessedHandler = new RequestProcessedEventHandlerCollection();
        $this->request = null;

        // set timezone
        date_default_timezone_set('Europe/Berlin');
    }

    #endregion

    #region methods
    //public static function getInstance($sessionName = '')
    //{
    //    // --- action ---
    //    if (empty(self::$instance)) {
    //        self::$instance = new Application($sessionName);
    //        self::$instance->requestProcessedHandler = new EventHandlerCollection();
    //    }
    //
    //    // --- return ---
    //    return self::$instance;
    //}

    /**
     * Function registerRequestProcessedEvent
     *
     * @param RequestHandler $object
     * @param string         $method
     */
    public function registerRequestProcessedEvent(
        RequestHandler $object = null,
        $method = ''
    ) {
        $this->requestProcessedHandler->add(new RequestProcessedEventHandler($object, $method));
    }

    public function processRequest(
        $path = null,
        $parameter = array()
    ) {
        // request
        $this->request = $this->buildRequest($path, $parameter);
        $this->throwRequestProcessedEvent(new RequestProcessedEventArgs($this->request));
    }

    /**
     * Function buildRequest
     *
     * @param string $path
     * @param array  $parameter
     *
     * @return Request
     */
    private function buildRequest(
        $path = null,
        $parameter = array()
    ) {
        // --- init ---
        $result = null;

        // --- action ---
        $result = RequestParser::parse(
            $path == null ? (array_key_exists('path', $_GET) ? $_GET['path'] : '') : $path,
            true,
            $parameter
        );

        // --- return ---
        return $result;
    }

    /**
     * throwRequestProcessedEvent.
     *
     * @param RequestProcessedEventArgs $e
     */
    protected function throwRequestProcessedEvent(RequestProcessedEventArgs $e = null)
    {
        foreach ($this->requestProcessedHandler as $requestProcessedHandler) {
            if ($requestProcessedHandler->Object != null) {
                call_user_func(array($requestProcessedHandler->Object, $requestProcessedHandler->Method), $this, $e);
            } else {
                call_user_func($requestProcessedHandler->Method, $this, $e);
            }
        }
    }
    #endregion

    #region properties

    protected function getRequest()
    {
        return $this->request;
    }
    #endregion
}

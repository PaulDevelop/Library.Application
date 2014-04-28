<?php

namespace Com\PaulDevelop\Library\Application;

use
    Com\PaulDevelop\Library\Common\Base;

/**
 * Request
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property $Original
 * @property $Directory
 * @property $FileName
 * @property $Path
 * @property $Action
 * @property $SystemParameter
 * @property $PageParameter
 * @property $FlowParameter
 * @property $Category
 * @property $HttpMethod
 * @property $Format
 */
class Request extends Base
{
    #region member
    /**
     * Normalized original request string.
     *
     * @var string
     */
    private $original;
    /**
     * Associative array (string key, string value) of system parameter.
     *
     * @var array
     */
    private $systemParameter;
    /**
     * Associative array (string key, string value) of page parameter.
     *
     * @var array
     */
    private $pageParameter;
    /**
     * Associative array (string key, string value) of flow parameter.
     *
     * @var array
     */
    private $flowParameter;
    /**
     * Normalized request string without parameter and verbs.
     *
     * @var string
     */
    private $directory;
    /**
     * File name.
     *
     * @var string
     */
    private $fileName;
    /**
     * Normalized request string without parameter.
     *
     * @var string
     */
    private $path;
    /**
     * Verb of current request string.
     *
     * @var string
     */
    private $action;
    /**
     * First directory of Normalized original request string.
     *
     * @var string
     */
    private $category;
    /**
     * Http method (Get, Put, Post, Delete).
     *
     * @var string
     */
    private $httpMethod;
    /**
     * Data format to be delivered.
     *
     * @var string
     */
    private $format;
    #endregion

    #region constructor
    public function __construct(
        $original = '',
        $directory = '',
        $fileName = '',
        $path = '',
        $action = '',
        $systemParameter = '',
        $pageParameter = '',
        $flowParameter = '',
        $category = '',
        $httpMethod = '',
        $format = ''
    ) {
        $this->original = $original;
        $this->directory = $directory;
        $this->fileName = $fileName;
        $this->path = $path;
        $this->action = $action;
        $this->systemParameter = $systemParameter;
        $this->pageParameter = $pageParameter;
        $this->flowParameter = $flowParameter;
        $this->category = $category;
        $this->httpMethod = $httpMethod;
        $this->format = $format;
    }
    #endregion

    #region methods
    public function getParameter($name = '')
    {
        // init
        $result = null;

        // action
        if (array_key_exists($name, $this->flowParameter)) {
            $result = $this->flowParameter[$name];
        }

        // return
        return $result;
    }
    #endregion

    #region properties
    public function getOriginal()
    {
        return $this->original;
    }

    public function getSystemParameter()
    {
        return $this->systemParameter;
    }

    public function getPageParameter()
    {
        return $this->pageParameter;
    }

    public function getFlowParameter()
    {
        return $this->flowParameter;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getFormat()
    {
        return $this->format;
    }
    #endregion
}

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
 *
 * @property RequestInput $Input
 * @property string $OriginalPath
 * @property string $StrippedPath
 * @property array $SystemParameter
 * @property array $PageParameter
 * @property array $GetParameter
 * @property array $PostParameter
 */
class Request extends Base
{
    /**
     * @var IRequestInput
     */
    private $input;

    /**
     * @var string
     */
    private $originalPath;

    /**
     * @var string
     */
    private $strippedPath;

    /**
     * @var array
     */
    private $pathParameter;

    /**
     * @var array
     */
    private $systemParameter;

    /**
     * @var array
     */
    private $getParameter;

    /**
     * @var array
     */
    private $postParameter;

    /**
     * @param IRequestInput $input
     * @param string        $originalPath
     * @param string        $strippedPath
     * @param array         $pathParameter
     * @param array         $systemParameter
     * @param array         $getParameter
     * @param array         $postParameter
     */
    public function __construct(
        IRequestInput $input = null,
        $originalPath = '',
        $strippedPath = '',
        $pathParameter = array(),
        $systemParameter = array(),
        $getParameter = array(),
        $postParameter = array()
    ) {
        $this->input = $input;
        $this->originalPath = $originalPath;
        $this->strippedPath = $strippedPath;
        $this->pathParameter = $pathParameter;
        $this->systemParameter = $systemParameter;
        $this->getParameter = $getParameter;
        $this->postParameter = $postParameter;
    }

    //public function getStdClass() {
    //    $result = new \stdClass();
    //    $result->input = $result->input->getStdClass();
    //}

    /**
     * @return IRequestInput
     */
    protected function getInput()
    {
        return $this->input;
    }

    /**
     * @return string
     */
    protected function getOriginalPath()
    {
        return $this->originalPath;
    }

    /**
     * @return string
     */
    protected function getStrippedPath()
    {
        return $this->strippedPath;
    }

    /**
     * @return array
     */
    protected function getPathParameter()
    {
        return $this->pathParameter;
    }

    /**
     * @return array
     */
    protected function getSystemParameter()
    {
        return $this->systemParameter;
    }

    /**
     * @return array
     */
    protected function getGetParameter()
    {
        return $this->getParameter;
    }

    /**
     * @return array
     */
    protected function getPostParameter()
    {
        return $this->postParameter;
    }
}

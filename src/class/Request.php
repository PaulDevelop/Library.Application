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
    private $input;

    private $originalPath;
    private $strippedPath;

    private $pathParameter;
    private $systemParameter;
    private $getParameter;
    private $postParameter;

    public function __construct(
        $input = null,
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

    protected function getInput()
    {
        return $this->input;
    }

    protected function getOriginalPath()
    {
        return $this->originalPath;
    }

    protected function getStrippedPath()
    {
        return $this->strippedPath;
    }

    protected function getPathParameter()
    {
        return $this->pathParameter;
    }

    protected function getSystemParameter()
    {
        return $this->systemParameter;
    }

    protected function getGetParameter()
    {
        return $this->getParameter;
    }

    protected function getPostParameter()
    {
        return $this->postParameter;
    }
}

<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * Request
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 *
 * @property RequestInput        $Input
 * @property string              $OriginalPath
 * @property string              $StrippedPath
 * @property ParameterCollection $SystemParameter
 * @property ParameterCollection $PathParameter
 * @property ParameterCollection $GetParameter
 * @property ParameterCollection $PostParameter
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
     * @var ParameterCollection
     */
    private $pathParameter;

    /**
     * @var ParameterCollection
     */
    private $systemParameter;

    /**
     * @var ParameterCollection
     */
    private $getParameter;

    /**
     * @var ParameterCollection
     */
    private $postParameter;

    /**
     * @var ParameterCollection
     */
    private $patchParameter;

    /**
     * @var ParameterCollection
     */
    private $headerParameter;

    /**
     * @param IRequestInput       $input
     * @param string              $originalPath
     * @param string              $strippedPath
     * @param ParameterCollection $pathParameter
     * @param ParameterCollection $systemParameter
     * @param ParameterCollection $getParameter
     * @param ParameterCollection $postParameter
     * @param ParameterCollection $patchParameter
     * @param ParameterCollection $headerParameter
     */
    public function __construct(
        IRequestInput $input = null,
        $originalPath = '',
        $strippedPath = '',
        ParameterCollection $pathParameter = null,
        ParameterCollection $systemParameter = null,
        ParameterCollection $getParameter = null,
        ParameterCollection $postParameter = null,
        ParameterCollection $patchParameter = null,
        ParameterCollection $headerParameter = null
    ) {
        $this->input = $input;
        $this->originalPath = $originalPath;
        $this->strippedPath = $strippedPath;
        $this->pathParameter = $pathParameter;
        $this->systemParameter = $systemParameter;
        $this->getParameter = $getParameter;
        $this->postParameter = $postParameter;
        $this->patchParameter = $patchParameter;
        $this->headerParameter = $headerParameter;
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
     * @return ParameterCollection
     */
    protected function getPathParameter()
    {
        return $this->pathParameter;
    }

    /**
     * @return ParameterCollection
     */
    protected function getSystemParameter()
    {
        return $this->systemParameter;
    }

    /**
     * @return ParameterCollection
     */
    protected function getGetParameter()
    {
        return $this->getParameter;
    }

    /**
     * @return ParameterCollection
     */
    protected function getPostParameter()
    {
        return $this->postParameter;
    }

    /**
     * @return ParameterCollection
     */
    protected function getPatchParameter()
    {
        return $this->patchParameter;
    }

    /**
     * @return ParameterCollection
     */
    protected function getHeaderParameter()
    {
        return $this->headerParameter;
    }
}

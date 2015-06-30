<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * Filter
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string          $Path
 * @property string          $Pattern
 * @property bool            $SupportPathParameter
 * @property FilterParameter $ParameterList
 */
class Filter extends Base
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var bool
     */
    private $supportPathParameter;

    /**
     * @var FilterParameterCollection
     */
    private $parameterList;

    /**
     * @param string                    $path
     * @param string                    $pattern
     * @param bool                      $supportPathParameter
     * @param FilterParameterCollection $parameterList
     */
    public function __construct(
        $path = '',
        $pattern = '',
        $supportPathParameter = false,
        FilterParameterCollection $parameterList = null
    ) {
        $this->path = $path;
        $this->parameterList = $parameterList;
        $this->pattern = $pattern;
        $this->supportPathParameter = $supportPathParameter;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return bool
     */
    public function getSupportPathParameter()
    {
        return $this->supportPathParameter;
    }

    /**
     * @return FilterParameterCollection
     */
    public function getParameterList()
    {
        return $this->parameterList;
    }
}

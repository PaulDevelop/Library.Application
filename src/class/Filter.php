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
 * @property FilterParameter $ParameterList
 */
class Filter extends Base
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var FilterParameterCollection
     */
    private $parameterList;

    /**
     * @param string                    $path
     * @param FilterParameterCollection $parameterList
     */
    public function __construct(
        $path = '',
        FilterParameterCollection $parameterList = null
    ) {
        $this->path = $path;
        $this->parameterList = $parameterList;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return FilterParameterCollection
     */
    public function getParameterList()
    {
        return $this->parameterList;
    }
}

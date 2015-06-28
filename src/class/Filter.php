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
 * @property FilterParameter $Parameter
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
    private $parameters;

    /**
     * @param string                    $path
     * @param FilterParameterCollection $parameters
     */
    public function __construct(
        $path = '',
        FilterParameterCollection $parameters = null
    ) {
        $this->path = $path;
        $this->parameters = $parameters;
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
    public function getParameters()
    {
        return $this->parameters;
    }
}

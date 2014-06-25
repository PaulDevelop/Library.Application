<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * Parameter
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 *
 * @property string $Name
 * @property string $Value
 */
class Parameter extends Base
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $name
     * @param string $value
     */
    public function __construct($name = '', $value = '')
    {
        $this->name = $name;
        $this->value = $value;
    }

    protected function getName()
    {
        return $this->name;
    }

    protected function getValue()
    {
        return $this->value;
    }
}

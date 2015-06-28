<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\GenericCollection;

/**
 * ConstraintCollection
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
class ConstraintCollection extends GenericCollection
{
    public function __construct()
    {
        parent::__construct('Com\PaulDevelop\Library\Application\Constraint');
    }

    /**
     * @param string $name
     * @param bool   $defaultValue
     *
     * @return bool
     */
    public function getBool($name = '', $defaultValue = false)
    {
        // return
        return (bool)(isset($this[$name]) ? $this[$name]->Value : $defaultValue);
    }

    /**
     * @param string $name
     * @param int    $defaultValue
     *
     * @return int
     */
    public function getInt($name = '', $defaultValue = 0)
    {
        // return
        return (int)(isset($this[$name]) ? $this[$name]->Value : $defaultValue);
    }

    /**
     * @param string $name
     * @param float  $defaultValue
     *
     * @return float
     */
    public function getFloat($name = '', $defaultValue = 0.0)
    {
        // return
        return (float)(isset($this[$name]) ? $this[$name]->Value : $defaultValue);
    }

    /**
     * @param string $name
     * @param string $defaultValue
     *
     * @return string
     */
    public function getString($name = '', $defaultValue = '')
    {
        // return
        return (string)(isset($this[$name]) ? $this[$name]->Value : $defaultValue);
    }
}

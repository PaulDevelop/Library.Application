<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * FilterParameter
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string               $Name
 * @property string               $Source
 * @property ConstraintCollection $constraints
 */
class FilterParameter extends Base
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $source;

    /**
     * @var ConstraintCollection
     */
    private $constraints;

    /**
     * @param string               $name
     * @param string               $source
     * @param ConstraintCollection $constraints
     */
    public function __construct(
        $name = '',
        $source = '',
        ConstraintCollection $constraints = null
    ) {
        $this->name = $name;
        $this->source = $source;
        $this->constraints = $constraints;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getConstraints()
    {
        return $this->constraints;
    }
}

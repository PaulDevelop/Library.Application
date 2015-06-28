<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * ConstraintViolation
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property Parameter  $ActualParameter
 * @property Constraint $Constraint
 */
class ConstraintViolation extends Base
{
    // region member
    /**
     * @var Parameter
     */
    private $actualParameter;

    /**
     * @var Constraint
     */
    private $constraint;
    // endregion

    // region constructor
    /**
     * @param Parameter  $actualParameter
     * @param Constraint $constraint
     */
    public function __construct(
        Parameter $actualParameter = null,
        Constraint $constraint = null
    ) {
        $this->actualParameter = $actualParameter;
        $this->constraint = $constraint;
    }
    // endregion

    // region methods
//    public function getStdClass()
//    {
//        // init
//        $result = new \stdClass();
//
//        // action
//        $result->actualParameter = $this->actualParameter->getStdClass();
//        $result->constraint = $this->constraint->getStdClass();
//
//        // return
//        return $result;
//    }
    // endregion

    // region properties
    /**
     * @return Parameter
     */
    public function getActualParameter()
    {
        return $this->actualParameter;
    }

    /**
     * @return Constraint
     */
    public function getConstraint()
    {
        return $this->constraint;
    }
    // endregion
}

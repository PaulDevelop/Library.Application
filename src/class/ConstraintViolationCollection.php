<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\GenericCollection;

/**
 * ConstraintViolationCollection
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
class ConstraintViolationCollection extends GenericCollection
{
    public function __construct($initialValues = array(), $keyFieldName = '')
    {
        parent::__construct('Com\PaulDevelop\Library\Application\ConstraintViolation', $initialValues, $keyFieldName);
    }
}

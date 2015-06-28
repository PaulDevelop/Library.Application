<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;
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

    public function getStdClass()
    {
        // init
        $result = new \stdClass();

        // action
        foreach ($this->collection as $key => $item) {
            if (is_a($item, '\Com\PaulDevelop\Library\Common\Base')) {
                /** @var Base $item */
                $result->$key = $item->getStdClass();
            }
        }

        // return
        return $result;
    }
}

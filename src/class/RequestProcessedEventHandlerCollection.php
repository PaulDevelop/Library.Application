<?php

namespace Com\PaulDevelop\Library\Application;

use
    Com\PaulDevelop\Library\Common\GenericCollection;

/**
 * RequestProcessedEventHandlerCollection
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property $Request
 */
class RequestProcessedEventHandlerCollection extends GenericCollection
{
    public function __construct()
    {
        parent::__construct('Com\PaulDevelop\Library\Application\RequestProcessedEventHandler');
    }
}

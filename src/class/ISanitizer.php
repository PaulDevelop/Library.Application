<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * ISanitizer
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
interface ISanitizer
{
    public function clean($input = '');
}

<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * IMapping
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
interface IMapping
{

    public function getPattern();

    public function process(Request $request);
}

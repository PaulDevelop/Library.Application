<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * IUrlMapper
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
interface IUrlMapper
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function process(Request $request = null);
}

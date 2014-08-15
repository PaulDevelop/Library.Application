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
    /**
     * @return string
     */
    public function getPattern();

    /**
     * @return bool
     */
    public function getSupportParseParameter();

    /**
     * @param Request $request
     *
     * @return string
     */
    public function process(Request $request);
}

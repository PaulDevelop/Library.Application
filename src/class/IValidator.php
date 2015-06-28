<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * IValidator
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
interface IValidator
{
    public function addFilter();

    /**
     * @param string              $path
     * @param string              $source
     * @param ParameterCollection $actualParameterList
     *
     * @return bool
     * @internal param ParameterCollection $actualParameter
     *
     */
    public function check($path = '', $source = '', ParameterCollection $actualParameterList = null);
}

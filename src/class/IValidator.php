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
     * @param ParameterCollection $actualParameter
     *
     * @return bool
     */
    public function check($path = '', ParameterCollection $actualParameter = null);
}

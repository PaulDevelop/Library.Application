<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\ITemplate;

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
    // region methods
    /**
     * @param Request   $request
     * @param ITemplate $template
     *
     * @return string
     */
    public function process(Request $request, ITemplate $template);
    // endregion

    // region properties
    /**
     * @return string
     */
    public function getPattern();

    /**
     * @return bool
     */
    public function getSupportParseParameter();
    // endregion
}

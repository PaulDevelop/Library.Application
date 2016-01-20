<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\ITemplate;

/**
 * ITemplateFunctions
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
interface ITemplateFunctions
{
    // region properties
    /**
     * @return ITemplate
     */
    public function getTemplate();

    /**
     * @param ITemplate $template
     *
     * @return void
     */
    public function setTemplate(ITemplate $template = null);
    // endregion
}

<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\ITemplate;

/**
 * DefaultTemplateController
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string $Pattern
 * @property string $Namespace
 * @property string $ControllerPath
 * @property string $TemplatePath
 */
class DefaultTemplateController implements IController
{
    /**
     * @param Request   $request
     * @param ITemplate $template
     *
     * @return string
     */
    public function process(Request $request = null, ITemplate $template = null)
    {
        return $template->process();
    }
}

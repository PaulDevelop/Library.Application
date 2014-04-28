<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * ITemplate
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
interface ITemplate
{
    //public function SetTemplateFile($templateFileName = '');
    /**
     * @return string
     */
    public function process();
}

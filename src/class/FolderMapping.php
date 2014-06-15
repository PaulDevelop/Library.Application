<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * FolderMapping
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
class FolderMapping extends Base implements IMapping
{
    private $pattern;
    private $namespace;
    private $controllerPath;
    private $templatePath;

    public function __construct(
        $pattern = '',
        $namespace = '',
        $controllerPath = '',
        $templatePath = ''
    ) {
        $this->pattern = $pattern;
        $this->namespace = $namespace;
        $this->controllerPath = $controllerPath;
        $this->templatePath = $templatePath;
    }

    public function process(Request $request)
    {
        // get controler class name
        $controllerClassName = $this->namespace;
        if (substr($controllerClassName, -1, 1) != '\\') {
            $controllerClassName .= '\\';
        }
        switch ($request->Input->Format) {
            case Formats::HTML:
                $controllerClassName .= 'Html';
                break;
            case Formats::JSON:
                $controllerClassName .= 'Rest';
                break;
            case Formats::SOAP:
                $controllerClassName .= 'Webservice';
                break;
            case Formats::XML:
                $controllerClassName .= 'Webservice';
                break;
            default:
                $controllerClassName .= 'Html';
        }

        $chunks = preg_split('/\//', $request->StrippedPath);
        array_walk(
            $chunks,
            function (&$chunk) {
                $chunk = ucfirst($chunk);
            }
        );
        $controllerClassName .= implode($chunks);
        if ($request->StrippedPath == '') {
            $controllerClassName .= 'Index';
        }
        $controllerClassName .= 'Controller';

        // get template file name
        $templateFileName = $this->templatePath;
        if (substr($templateFileName, -1, 1) != DIRECTORY_SEPARATOR) {
            $templateFileName .= DIRECTORY_SEPARATOR;
        }

        $templateFileName .= str_replace('/', '.', $request->StrippedPath);
        if ($request->StrippedPath == '') {
            $templateFileName .= 'index';
        }

        $templateFileName .= '.template.pdt';
        $template = null; // new Template2();

        $controller = new $controllerClassName();
        /** @var IController $controller */
        return $controller->process($request, $template);
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    protected function getNamespace()
    {
        return $this->namespace;
    }

    protected function getControllerPath()
    {
        return $this->controllerPath;
    }

    protected function getTemplatePath()
    {
        return $this->templatePath;
    }
}

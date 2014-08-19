<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\ITemplate;

/**
 * FolderMapping
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string $Pattern
 * @property bool   $SupportParseParameter
 * @property array  $Namespaces
 * @property string $SubNamespace
 * @property string $ControllerPath
 * @property string $TemplatePath
 */
class FolderMapping extends Base implements IMapping
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var bool
     */
    private $supportParseParameter;

    /**
     * @var array
     */
    private $namespaces;

    /**
     * @var string
     */
    private $subNamespace;

    /**
     * @var string
     */
    private $controllerPath;

    /**
     * @var string
     */
    private $templatePath;

    /**
     * @param string $pattern
     * @param bool   $supportParseParameter
     * @param array  $namespaces
     * @param string $subNamespace
     * @param string $controllerPath
     * @param string $templatePath
     */
    public function __construct(
        $pattern = '',
        $supportParseParameter = false,
        $namespaces = array(),
        $subNamespace = '',
        $controllerPath = '',
        $templatePath = ''
    ) {
        $this->pattern = $pattern;
        $this->namespaces = $namespaces;
        $this->subNamespace = $subNamespace;
        $this->controllerPath = $controllerPath;
        $this->templatePath = $templatePath;
    }

    /**
     * @param Request   $request
     * @param ITemplate $template
     *
     * @return string
     */
    public function process(Request $request = null, ITemplate $template = null)
    {
        // get template file name
        $templateFileName = $this->templatePath;
        if (substr($templateFileName, -1, 1) != DIRECTORY_SEPARATOR) {
            $templateFileName .= DIRECTORY_SEPARATOR;
        }

        // path = url - pattern
        $url = '';
        if ($request->Input->Subdomains != '') {
            $url .= $request->Input->Subdomains.'.';
        }
        $url .= $request->Input->Domain;
        if ($request->Input->Port != '') {
            $url .= ':'.$request->Input->Port;
        }
        if ($request->StrippedPath != '') {
            $url .= '/'.$request->StrippedPath;
        }
        $url = trim($url, "\t\n\r\0\x0B/");
        $pattern = $this->Pattern;
        //$pattern = str_replace('*', '', $pattern);
        //$pattern = str_replace('\\', '', $pattern);
        //$pattern = trim($pattern, "\t\n\r\0\x0B/");

        // variables
        $pattern = str_replace('%baseUrl%', str_replace('.', '\.', $request->Input->Domain), $pattern);

        preg_match('('.$pattern.')', $url, $matches);
        //var_dump($matches);
        $pattern = $matches[0];


        $path = str_replace($pattern, '', $url);
        $path = trim($path, "\t\n\r\0\x0B/");

        $template->bindVariable('base', $request->Input->Protocol.'://'.$pattern.'/');

        //echo 'XXX';
        //var_dump($path);

        //$templateFileName .= str_replace('/', '.', $request->StrippedPath);
        //if ($request->StrippedPath == '') {
        //    $templateFileName .= 'index';
        //}

        $formatPrefix = '';
        switch ($request->Input->Format) {
            case Formats::HTML:
                $formatPrefix = 'html';
                break;
            case Formats::JSON:
                $formatPrefix = 'json';
                break;
            case Formats::SOAP:
                $formatPrefix = 'xml';
                break;
            case Formats::XML:
                $formatPrefix = 'xml';
                break;
            default:
                $formatPrefix = 'html';
        }
        $templateFileName .= $formatPrefix.'.';

        $templateFileName .= str_replace('/', '.', $path);
        if ($path == '') {
            $templateFileName .= 'index';
        }

        $templateFileName .= '.template.pdt';
        //if ( file_exists($templateFileName) ) {
        $template->TemplateFileName = $templateFileName;
        //}


        // TODO: check, if template file exists
        // TODO: 404 (if template and / or controller file does not exist)

        // get controller class name
        //$controllerClassName = $this->namespace;
        //if (substr($controllerClassName, -1, 1) != '\\') {
        //    $controllerClassName .= '\\';
        //}
        $controllerClassName = '';
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

        //$chunks = preg_split('/\//', $request->StrippedPath);
        $chunks = preg_split('/\//', $path);
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

        $controller = null;
        foreach ($this->namespaces as $namespace) {
            $fullControllerClassName = $namespace.'\\'.$this->SubNamespace.'\\'.$controllerClassName;
            if (class_exists($fullControllerClassName)) {
                $controller = new $fullControllerClassName();
                break;
            }
        }

        if ($controller == null) {
            $controller = new DefaultTemplateController();
        }

        //if (class_exists($controllerClassName)) {
        //    $controller = new $controllerClassName();
        //} else {
        //    $controller = new DefaultTemplateController();
        //}

        /** @var IController $controller */
        return $controller->process($request, $template);
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return bool
     */
    public function getSupportParseParameter()
    {
        return $this->supportParseParameter;
    }

    /**
     * @return array
     */
    protected function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * @return string
     */
    protected function getSubNamespace()
    {
        return $this->subNamespace;
    }

    /**
     * @return string
     */
    protected function getControllerPath()
    {
        return $this->controllerPath;
    }

    /**
     * @return string
     */
    protected function getTemplatePath()
    {
        return $this->templatePath;
    }
}

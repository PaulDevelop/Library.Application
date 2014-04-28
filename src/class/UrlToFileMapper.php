<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Constants;
use Com\PaulDevelop\Library\Template\Template;

class UrlToFileMapper implements IUrlMapper
{
    #region member
    private $namespace;
    private $templatePath;
    private $controllerPath;
    private $setupTemplateCallback;
    private $renderTemplateFileNameCallback;
    private $renderControllerFileNameCallback;
    private $renderControllerClassNameCallback;
    private $fileNotFoundCallback;
    #endregion

    #region constructor
    public function __construct(
        $namespace = '',
        $templatePath = '',
        $controllerPath = ''
    ) {
        $this->namespace = $namespace;
        $this->templatePath = $templatePath;
        $this->controllerPath = $controllerPath;
        $this->setupTemplateCallback = function () {
        };
        $this->renderTemplateFileNameCallback = function () {
        };
        $this->renderControllerFileNameCallback = function () {
        };
        $this->renderControllerClassNameCallback = function () {
        };
        $this->fileNotFoundCallback = function () {
        };
    }
    #endregion

    #region methods
    /**
     * @param Request $request
     *
     * @return string|void
     */
    public function process(Request $request = null)
    {
        // init
        $result = '';

        // action
        $templateFileName = $this->renderTemplateFileName($request);
        //var_dump($templateFileName);
        $template = $this->initializeTemplate($templateFileName);

        $controllerFileName = $this->renderControllerFileName($request);
        //var_dump($controllerFileName);
        $foundController = $this->includeController($controllerFileName, $request, $template);

        if ($foundController) {
            $controllerClassName = $this->renderControllerClassName($request);
            //var_dump($controllerClassName);
            //$controller = new $controllerClassName();
            $controller = $this->instantiateController($controllerClassName);
            $controller->process($request, $template);
        }

        // set up template
        if ($template != null) {
            $this->setupTemplate($request, $template);
            $result = $template->Process();
        }
        if (!$foundController && $template == null) { // 404
            call_user_func($this->fileNotFoundCallback, $request);
        }

        // return
        return $result;
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    private function renderTemplateFileName(Request $request = null)
    {
        // init
        //$result = '';

        // action
        $controllerType = $this->getControllerType($request->Format);
        $templatePath = $this->templatePath; // FRONTEND_FS_TEMPLATE;
        $appRequestPath = '';
        if ($request->Path != '') {
            $chunks = preg_split('/\//', $request->Path);
            $appRequestPath = implode('.', $chunks);
        }
        $fileName = substr($request->FileName, 0, strrpos($request->FileName, '.'));
        $templateFileName = (empty($appRequestPath) ? '' : '.')
            .$appRequestPath.'.'
            .($fileName != '' ? $fileName : $request->Action);

        $result = $templatePath.$controllerType.$templateFileName.'.template.pdt';

//      var_dump($result);

        if (!file_exists($result)) {
//        echo "file does not exists, so ask project specific template finding callback".PHP_EOL;
            $callback = call_user_func($this->renderTemplateFileNameCallback, $request);
            $templateFileName = $callback != null ? '.'.$callback : $templateFileName;
            $result = $templatePath.$controllerType.$templateFileName.'.template.pdt';
        }

//      var_dump($result);
//      die;

        // return
        return $result;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    private function getControllerType($format = '')
    {
        // init
        $result = null;

        // action
        switch ($format) {
            case 'application/xml':
            case 'text/xml':
                $result = 'webservice';
                break;
            case 'application/json':
                $result = 'rest';
                break;
            default:
                $result = 'html';
        }

        // return
        return $result;
    }

    /**
     * @param string $templateFileName
     *
     * @return Template|null
     */
    private function initializeTemplate($templateFileName = '')
    {
        // init
        $result = null;

        // action
        if (file_exists($templateFileName)) {
            $result = new Template();
            $result->SetTemplateFile($templateFileName);
        }

        // return
        return $result;
    }

    /**
     * @param Request $request
     *
     * @return mixed|string
     */
    private function renderControllerFileName(Request $request = null)
    {
        // init
        $result = null;

        // action
        $controllerType = $this->getControllerType($request->Format);
        $controllerPath = $this->controllerPath; // FRONTEND_FS_CONTROLLER;
        $appRequestPath = $request->Path;
        $fileName = substr($request->FileName, 0, strrpos($request->FileName, '.'));
        $result = (empty($appRequestPath) ? '' : DIRECTORY_SEPARATOR)
            .$appRequestPath.DIRECTORY_SEPARATOR
            .($fileName != '' ? $fileName : $request->Action);

        $result = $controllerType.$result;

        $result = str_replace("\\\\", "\\", $result);
        $result = str_replace("//", "/", $result);
        $result = preg_replace('/\/(.)/e', "strtoupper('\\1')", $result);
        $result = ucfirst($result);

        $result = $controllerPath.DIRECTORY_SEPARATOR.$result.'Controller.class.php';

        if (!file_exists($result)) {
            $callback = call_user_func($this->renderControllerFileNameCallback, $request);
            $result = $callback != null ? $callback : $result;

            $result = $controllerType.$result;

            $result = str_replace("\\\\", "\\", $result);
            $result = str_replace("//", "/", $result);
            $result = preg_replace('/\/(.)/e', "strtoupper('\\1')", $result);
            $result = ucfirst($result);

            $result = $controllerPath.DIRECTORY_SEPARATOR.$result.'Controller.class.php';
        }

        // return
        return $result;
    }

    /**
     * @param string $controllerFileName
     *
     * @return bool
     */
    protected function includeController($controllerFileName = '')
    {
        // init
        $result = false;

        // action
        if ($controllerFileName != '' && file_exists($controllerFileName)) {
            $result = true;
            include_once($controllerFileName);
        }
        // return
        return $result;
    }

    /**
     * @param Request $request
     *
     * @return mixed|string
     */
    private function renderControllerClassName(Request $request = null)
    {
        // init
        $result = null;

        // action
        $controllerType = $this->getControllerType($request->Format);
        $appRequestPath = $request->Path;
        $fileName = substr($request->FileName, 0, strrpos($request->FileName, '.'));

        $namespace = $this->namespace;
        $result = (empty($appRequestPath) ? '' : DIRECTORY_SEPARATOR)
            .$appRequestPath.DIRECTORY_SEPARATOR
            .($fileName != '' ? $fileName : $request->Action);


        $result = $controllerType.DIRECTORY_SEPARATOR.$result;

        $result = str_replace("\\\\", "\\", $result);
        $result = str_replace("//", "/", $result);
        $result = preg_replace('/\/(.)/e', "strtoupper('\\1')", $result);
        $result = ucfirst($result);
        $result = Constants::NAMESPACE_SEPARATOR.$result.'Controller';
        $result = $namespace.Constants::NAMESPACE_SEPARATOR.$result;
        $result = str_replace("\\\\", "\\", $result);

        if (!class_exists($result, false)) {
            $callback = call_user_func($this->renderControllerClassNameCallback, $request);
            $result = $callback != null ? $callback->className : $result;
            $namespace .= ($callback != null && $callback->namespace != '') ?
                Constants::NAMESPACE_SEPARATOR.$callback->namespace : '';

            $result = $controllerType.DIRECTORY_SEPARATOR.$result;

            $result = str_replace("\\\\", "\\", $result);
            $result = str_replace("//", "/", $result);
            $result = preg_replace('/\/(.)/e', "strtoupper('\\1')", $result);
            $result = ucfirst($result);
            $result = Constants::NAMESPACE_SEPARATOR.$result.'Controller';
            $result = $namespace.Constants::NAMESPACE_SEPARATOR.$result;
            $result = str_replace("\\\\", "\\", $result);
        }

        // return
        return $result;
    }

    /**
     * @param string $controllerClassName
     *
     * @return IController
     */
    private function instantiateController($controllerClassName = '')
    {
        return new $controllerClassName();
    }

    protected function setupTemplate(
        Request $request = null,
        $template = null
    ) {
        call_user_func($this->setupTemplateCallback, $request, $template); // , $args);
    }

    public function registerSetupTemplateCallback($callback = null)
    {
        $this->setupTemplateCallback = $callback;
    }

    public function registerRenderTemplateFileNameCallback($callback = null)
    {
        $this->renderTemplateFileNameCallback = $callback;
    }

    public function registerRenderControllerFileNameCallback($callback = null)
    {
        $this->renderControllerFileNameCallback = $callback;
    }

    public function registerRenderControllerClassNameCallback($callback = null)
    {
        $this->renderControllerClassNameCallback = $callback;
    }

    public function registerFileNotFoundCallback($callback = null)
    {
        $this->fileNotFoundCallback = $callback;
    }
    #endregion
}

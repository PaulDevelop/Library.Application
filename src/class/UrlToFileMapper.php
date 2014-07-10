<?php

namespace Com\PaulDevelop\Library\Application;

//use Com\PaulDevelop\Library\Common\Constants;
//use Com\PaulDevelop\Library\Template\Template;
use Com\PaulDevelop\Library\Common\ITemplate;

/**
 * UrlToFileMapper
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
class UrlToFileMapper implements IUrlMapper
{
    #region member
    private $mappings;
    private $templatePath;
    private $controllerPath;
    #endregion

    #region constructor
    public function __construct($templatePath = '', $controllerPath = '')
    {
        $this->mappings = new IMappingCollection();
        $this->templatePath = $templatePath;
        $this->controllerPath = $controllerPath;
    }
    #endregion

    #region methods
    public function mapFolder(
        $pattern = '',
        $namespace = '',
        $controllerPath = '',
        $templatePath = ''
    ) {
        $this->mappings->add(new FolderMapping($pattern, $namespace, $controllerPath, $templatePath), $pattern);
    }

    public function mapClass(
        $pattern = '',
        IController $object = null
    ) {
        $this->mappings->add(new ClassMapping($pattern, $object), $pattern);
    }

    public function mapFunction(
        $pattern = '',
        $function = null
    ) {
        $this->mappings->add(new FunctionMapping($pattern, $function), $pattern);
    }

    /**
     * @param Request   $request
     * @param ITemplate $template
     *
     * @return string
     */
    public function process(Request $request = null, ITemplate $template = null)
    {
        // init
        $result = '';

        // find pattern matching path
        foreach ($this->mappings as $mapping) {
            /** @var IMapping $mapping */
            if ($this->checkPattern($mapping->getPattern(), $request)) {
                //echo ' => MATCH<br />';
                //echo gettype($mapping);
                //if ( get_class($mapping) == 'Com\PaulDevelop\TemplateRepository\ClassMapping' ) {
                //    ///** @var ClassMapping $mapping */
                //    $mapping->process();
                //}
                $result = $mapping->process($request, $template);
                break;
            } else {
                //echo ' => no match<br />';
            }
            //echo '<hr />';
        }

        return $result;
    }

    private function checkPattern($pattern = '', Request $request = null)
    {
        // ^(subdomain\.)*domain(\/(folder\/)*(file\.ext)?)?$

        // pattern
        $pattern = trim($pattern, "\t\n\r\0\x0B/");
        if (($pos = strpos($pattern, '/*')) !== false) {
            $pattern = substr($pattern, 0, $pos);
        } else {
            $pattern = $pattern.'$';
        }

        if (($pos = strpos($pattern, '*.')) !== false) {
            $pattern = substr($pattern, $pos + 2);
        } else {
            $pattern = '^'.$pattern;
        }
        $pattern = str_replace('.', '\.', $pattern);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/'.$pattern.'/';

        // path
        $path = '';
        if ($request->Input->Subdomains != '') {
            $path .= $request->Input->Subdomains.'.';
        }
        $path .= $request->Input->Domain;
        if ( $request->Input->Port != '' ) {
            $path .= ':'.$request->Input->Port;
        }
        if ($request->StrippedPath != '') {
            $path .= '/'.$request->StrippedPath;
        }
        $path = trim($path, "\t\n\r\0\x0B/");

        // match
        $result = preg_match($pattern, $path);

        // return
        return $result;
    }
    #endregion
}

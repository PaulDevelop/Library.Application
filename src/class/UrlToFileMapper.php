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
    /**
     * @var IMappingCollection
     */
    private $mappings;
    #endregion

    #region constructor
    public function __construct()
    {
        $this->mappings = new IMappingCollection();
    }
    #endregion

    #region methods
    /**
     * @param string $pattern
     * @param bool   $supportParseParameter
     * @param array  $namespaces
     * @param string $subNamespace
     * @param string $controllerPath
     * @param string $templatePath
     *
     * @throws \Com\PaulDevelop\Library\Common\ArgumentException
     * @throws \Com\PaulDevelop\Library\Common\TypeCheckException
     */
    public function mapFolder(
        $pattern = '',
        $supportParseParameter = false,
        $namespaces = array(),
        $subNamespace = '',
        $controllerPath = '',
        $templatePath = ''
    ) {
        $this->mappings->add(
            new FolderMapping(
                $pattern,
                $supportParseParameter,
                $namespaces,
                $subNamespace,
                $controllerPath,
                $templatePath
            ),
            $pattern
        );
    }

    /**
     * @param string      $pattern
     * @param bool        $supportParseParameter
     * @param IController $object
     *
     * @throws \Com\PaulDevelop\Library\Common\ArgumentException
     * @throws \Com\PaulDevelop\Library\Common\TypeCheckException
     */
    public function mapClass(
        $pattern = '',
        $supportParseParameter = false,
        IController $object = null
    ) {
        $this->mappings->add(new ClassMapping($pattern, $supportParseParameter, $object), $pattern);
    }

    /**
     * @param string $pattern
     * @param bool   $supportParseParameter
     * @param null   $function
     *
     * @throws \Com\PaulDevelop\Library\Common\ArgumentException
     * @throws \Com\PaulDevelop\Library\Common\TypeCheckException
     */
    public function mapFunction(
        $pattern = '',
        $supportParseParameter = false,
        $function = null
    ) {
        $this->mappings->add(new FunctionMapping($pattern, $supportParseParameter, $function), $pattern);
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
            if ($this->checkPattern($mapping->getPattern(), $mapping->getSupportParseParameter(), $request)) {
                $result = $mapping->process($request, $template);
                break;
            }
        }

        return $result;
    }

    /**
     * @param string  $pattern
     * @param bool    $supportParseParameter
     * @param Request $request
     *
     * @return int
     */
    private function checkPattern($pattern = '', $supportParseParameter = false, Request $request = null)
    {
        // ^(subdomain\.)*domain(\/(folder\/)*(file\.ext)?)?$

        // pattern
        /*
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
        */

        $pattern = '/'.$pattern.'/';
//        var_dump($pattern);
        //var_dump($pattern);

        // variables
        //$pattern = str_replace('%baseUrl%', str_replace('.', '\.', $request->Input->Domain), $pattern);
        $pattern = str_replace('%baseUrl%', str_replace('.', '\.', $request->Input->Host), $pattern);
        //$pattern = str_replace(
        //    '%baseUrl%',
        //    str_replace(
        //        '.',
        //        '\.',
        //        ($request->Input->Subdomains != '' ? $request->Input->Subdomains.'.' : '').$request->Input->Domain
        //    ),
        //    $pattern
        //);

        // path
        //echo 'pattern  : '.$pattern.PHP_EOL;
        //echo 'url      : '.$request->Input->Url.PHP_EOL;
        //echo 'path     : '.$request->Input->Path.PHP_EOL;
        //echo 'stripped : '.$request->StrippedPath.PHP_EOL;
        //echo '================================================'.PHP_EOL;
        $path = '';
        if ($request->Input->Subdomains != '') {
            $path .= $request->Input->Subdomains.'.';
        }
        //$path .= $request->Input->Domain;
        $path .= $request->Input->Host;
        if ($request->Input->Port != '') {
            $path .= ':'.$request->Input->Port;
        }

        if ($supportParseParameter == true) {
            if ($request->StrippedPath != '') {
                $path .= '/'.$request->StrippedPath;
            }
        } else {
            if ($request->Input->Path != '') {
                $path .= '/'.$request->Input->Path;
            }
        }

        //if ($request->StrippedPath != '') {
        //    $path .= '/'.$request->StrippedPath;
        //}
        $path = trim($path, "\t\n\r\0\x0B/");
//        var_dump($path);
        // match
        $result = preg_match($pattern, $path);
//        var_dump($result);
        // return
        return $result;
    }
    #endregion
}

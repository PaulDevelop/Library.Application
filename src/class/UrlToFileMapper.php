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
     * @var AliasCollection
     */
    private $aliasList;

    /**
     * @var IMappingCollection
     */
    private $mappingList;
    #endregion

    #region constructor
    public function __construct()
    {
        $this->aliasList = new AliasCollection();
        $this->mappingList = new IMappingCollection();
    }
    #endregion

    #region methods
    /**
     * @param string $source
     * @param string $target
     *
     * @throws \Com\PaulDevelop\Library\Common\ArgumentException
     * @throws \Com\PaulDevelop\Library\Common\TypeCheckException
     */
    public function addAlias($source = '', $target = '')
    {
        $this->aliasList->add(
            new Alias(
                $source,
                $target
            )
        );
    }

    /**
     * @param string      $pattern
     * @param bool|false  $supportParseParameter
     * @param string      $table
     * @param string      $field
     * @param string      $value
     * @param string      $template
     * @param IController $object
     *
     * @throws \Com\PaulDevelop\Library\Common\ArgumentException
     * @throws \Com\PaulDevelop\Library\Common\TypeCheckException
     *
     */
    public function mapDatabase(
        $pattern = '',
        $supportParseParameter = false,
        $table = '',
        $field = '',
        $value = '',
        $template = '',
        IController $object = null
    ) {
        $this->mappingList->add(
            new DatabaseMapping(
                $pattern,
                $supportParseParameter,
                $table,
                $field,
                $value,
                $template,
                $object
            )//,
        //$pattern
        );
    }

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
        $this->mappingList->add(
            new FolderMapping(
                $pattern,
                $supportParseParameter,
                $namespaces,
                $subNamespace,
                $controllerPath,
                $templatePath
            )//,
        //$pattern
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
        $this->mappingList->add(
            new ClassMapping(
                $pattern,
                $supportParseParameter,
                $object
            )//,
        //$pattern
        );
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
        $this->mappingList->add(
            new FunctionMapping(
                $pattern,
                $supportParseParameter,
                $function
            )//,
        //$pattern
        );
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
//        foreach ($this->mappings as $mapping) {
//            /** @var IMapping $mapping */
//            if ($this->checkPattern($mapping->getPattern(), $mapping->getSupportParseParameter(), $request)) {
//                $result = $mapping->process($request, $template);
//                break;
//            }
//        }

        $request = $this->applyAliases($request);
//        var_dump($request);
//        die;

        foreach ($this->mappingList as $mapping) {
            /** @var IMapping $mapping */
            if ($this->checkPattern($mapping->getPattern(), $mapping->getSupportParseParameter(), $request)) {
                // get original request with correct parseParameter setting
                $request = RequestParser::parse(
                    new RequestInput($request->Input->BaseUrl),
                    $mapping->getSupportParseParameter()
                );
                $request = $this->applyAliases($request);

                $template->bindVariable('request', $request->getStdClass());
                $result = $mapping->process($request, $template);
                if ($result != '') {
                    break;
                }
            }
        }

        if ($result == '') {
            echo '404';
            die;
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
        $url = '';
        if ($request->Input->Subdomains != '') {
            $url .= $request->Input->Subdomains.'.';
        }
        //$path .= $request->Input->Domain;
        $url .= $request->Input->Host;
        if ($request->Input->Port != '') {
            $url .= ':'.$request->Input->Port;
        }


        $path = '';


        if ($supportParseParameter == true) {
            if ($request->StrippedPath != '') {
                $path .= $request->StrippedPath;
            }
        } else {
            if ($request->Input->Path != '') {
                $path .= $request->Input->Path;
            }
        }

        $path = trim($path, "\t\n\r\0\x0B/");


//        var_dump($path);

//        $found = false;
//        /** @var Alias $alias */
//        foreach ($this->aliasList as $alias) {
////            var_dump($alias->Source);
//            if ($alias->Source == $path) {
//                $found = true;
//                $path = $alias->Target;
//
//                //RequestParser::parse()
//                //$request = RequestParser::parse(new RequestInput(APP_URL_BASE));
//
////                $newUrl = $request->Input->Protocol.'://'
////                    .($request->Input->Subdomains!='' ? $request->Input->Subdomains.'.' : ''),
////                    .$request->Input->Domain
////                    .$alias->Target;
////                $newUrl = $request->Input->BaseUrl.$alias->Target;
//                $newUrl = str_replace($alias->Source, $alias->Target, $request->Input->Url);
////                var_dump($newUrl);
//                $newRequest = RequestParser::parse(new RequestInput(APP_URL_BASE, $newUrl));
//                $request->Input = $newRequest->Input;
//                $request->FileParameter = $newRequest->FileParameter;
//                $request->GetParameter = $newRequest->GetParameter;
//                $request->HeaderParameter = $newRequest->HeaderParameter;
//                $request->OriginalPath = $newRequest->OriginalPath;
//                $request->PatchParameter = $newRequest->PatchParameter;
//                $request->PathParameter = $newRequest->PathParameter;
//                $request->PostParameter = $newRequest->PostParameter;
//                $request->StrippedPath = $newRequest->StrippedPath;
//                $request->SystemParameter = $newRequest->SystemParameter;
//
//
//
////                var_dump($request);
////                die;
//
//
////                echo "MATCH";
//                break;
//            }
//        }

        //die;


//        if ($supportParseParameter == true) {
//            if ($request->StrippedPath != '') {
//                $url .= '/'.$request->StrippedPath;
//            }
//        } else {
//            if ($request->Input->Path != '') {
//                $url .= '/'.$request->Input->Path;
//            }
//        }


        $url .= '/'.$path;

        //if ($request->StrippedPath != '') {
        //    $path .= '/'.$request->StrippedPath;
        //}
        $url = trim($url, "\t\n\r\0\x0B/");
//        var_dump($path);
        // match
        $result = preg_match($pattern, $url);
//        var_dump($result);
        // return
        return $result;
    }

    /**
     * @param Request $request
     * @param bool    $supportParseParameter
     *
     * @return string
     */
    private function getCleanPath(Request $request, $supportParseParameter = false)
    {
        // init
        $result = '';

        // action
        if ($supportParseParameter == true) {
            if ($request->StrippedPath != '') {
                $result .= $request->StrippedPath;
            }
        } else {
            if ($request->Input->Path != '') {
                $result .= $request->Input->Path;
            }
        }

        $result = trim($result, "\t\n\r\0\x0B/");

        // return
        return $result;
    }

    /**
     * @param Request $request
     *
     * @return Request
     */
    private function applyAliases(Request $request = null)
    {
        // init
        $result = $request;

        // action
        $path = $this->getCleanPath($request);

//        var_dump($path);


        /** @var Alias $alias */
        foreach ($this->aliasList as $alias) {
//            var_dump($alias->Source);
            if ($alias->Source == $path) {
//                $found = true;
//                $path = $alias->Target;

                //RequestParser::parse()
                //$request = RequestParser::parse(new RequestInput(APP_URL_BASE));

//                $newUrl = $request->Input->Protocol.'://'
//                    .($request->Input->Subdomains!='' ? $request->Input->Subdomains.'.' : ''),
//                    .$request->Input->Domain
//                    .$alias->Target;
//                $newUrl = $request->Input->BaseUrl.$alias->Target;
                $newUrl = str_replace($alias->Source, $alias->Target, $request->Input->Url);
//                var_dump($newUrl);
//                $newRequest = RequestParser::parse(new RequestInput(APP_URL_BASE, $newUrl));
                $result = RequestParser::parse(new RequestInput(APP_URL_BASE, $newUrl));
//                $request->Input = $newRequest->Input;
//                $request->FileParameter = $newRequest->FileParameter;
//                $request->GetParameter = $newRequest->GetParameter;
//                $request->HeaderParameter = $newRequest->HeaderParameter;
//                $request->OriginalPath = $newRequest->OriginalPath;
//                $request->PatchParameter = $newRequest->PatchParameter;
//                $request->PathParameter = $newRequest->PathParameter;
//                $request->PostParameter = $newRequest->PostParameter;
//                $request->StrippedPath = $newRequest->StrippedPath;
//                $request->SystemParameter = $newRequest->SystemParameter;


//                var_dump($request);
//                die;


//                echo "MATCH";
                break;
            }
        }

        // return
        return $result;
    }
    #endregion
}

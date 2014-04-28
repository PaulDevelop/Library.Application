<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * RequestParser
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
abstract class RequestParser
{
    #region member
    private static $verbs = array(
        'index',
        'list',
        'add',
        'edit',
        'delete',
        'search',
        'process'
    );
    #endregion

    #region methods
    public static function parse(
        $requestString = '',
        $supportParseParameter = true,
        $parameter = array()
    ) {
        // init
        $result = null;
        $original = '';
        $systemParameter = array();
        $pageParameter = array();
        $flowParameter = array();
        $directory = '';
        $fileName = '';
        $path = '';
        $action = '';
        $category = '';
        $httpMethod = HttpVerbs::GET;
        $format = Formats::HTML;

        // action
        $chunks = preg_split('/\//', $requestString, null, PREG_SPLIT_NO_EMPTY);
        $chunkCount = 0;
        foreach ($chunks as $chunk) {
            // original
            $original .= (!empty($original) ? '/' : '').$chunk;

            // check, if chunk is parameter
            if ($supportParseParameter && ($pos = strpos($chunk, "_")) > -1) {
                $pos = strpos($chunk, "_");
                $key = substr($chunk, 0, $pos);
                $value = substr($chunk, $pos + 1, strlen($chunk) - strlen($key));
                $systemParameter[$key] = $value;
            } else {
                if ($supportParseParameter && ($pos = strpos($chunk, "-")) > -1) {
                    $pos = strpos($chunk, "-");
                    $key = substr($chunk, 0, $pos);
                    $value = substr($chunk, $pos + 1, strlen($chunk) - strlen($key));
                    $pageParameter[$key] = $value;
                } else { // chunk is directory
                    // directory
                    if (empty($path) || !in_array($chunk, self::$verbs)) {
                        $directory .= (!empty($directory) ? '/' : '').$chunk;
                    }

                    // path
                    $path .= (!empty($path) ? '/' : '').$chunk;

                    // action
                    $action = $chunk;

                    // category
                    $category = empty($category) ? $chunk : $category;
                }
            }
            $chunkCount++;
        }

        // remove last part if it is verb
        $chunks = preg_split('/\//', $path, null, PREG_SPLIT_NO_EMPTY);
        if (count($chunks) > 0) {
            $lastChunk = $chunks[count($chunks) - 1];
            if (in_array($lastChunk, self::$verbs)) {
                $path = implode('/', array_slice($chunks, 0, count($chunks) - 1));
            }
        }

        // if action is no verb, set it to 'index'
        if (!in_array($action, self::$verbs)) {
            $action = 'index';
        }

        // if last part is file name, remove it
        if (count($chunks) > 0) {
            $fileName = $chunks[count($chunks) - 1];
        }

        if (preg_match('/.*?\.+?/', $fileName)) {
            $path = implode('/', array_slice($chunks, 0, count($chunks) - 1));
            $dc = preg_split('/\//', $directory);
            $directory = implode('/', array_slice($dc, 0, count($dc) - 1));
        } else {
            $fileName = '';
        }

        // http method and format
        if (array_key_exists('REQUEST_METHOD', $_SERVER) && !empty($_SERVER['REQUEST_METHOD'])) {
            $httpMethod = $_SERVER['REQUEST_METHOD'];
        }
        if (array_key_exists('HTTP_ACCEPT', $_SERVER) && !empty($_SERVER['HTTP_ACCEPT'])) {
            $reflectionObj = new \ReflectionObject(new Formats());
            //require_once('HTTP.php');
            $http = new \HTTP;
            $format = $http->negotiateMimeType($reflectionObj->getConstants(), 'text/html');
        }
        if (array_key_exists('HTTP_PDT_ACCEPT', $_SERVER) && !empty($_SERVER['HTTP_PDT_ACCEPT'])) {
            $format = $_SERVER['HTTP_PDT_ACCEPT'];
        }

        // check parameter
        $defaultValues = array();
        $defaultValues['int'] = 0;
        $defaultValues['double'] = 0.0;
        $defaultValues['string'] = '';
        $defaultValues['boolean'] = false;

        // check input
        if (array_key_exists($path, $parameter)
            && array_key_exists($action, $parameter[$path])
            && array_key_exists($httpMethod, $parameter[$path][$action])
        ) {
            foreach ($parameter[$path][$action][$httpMethod] as $parameterName => $parameterInfo) {
                if ($httpMethod == 'GET') {
                    $value = '';
                    if (array_key_exists($parameterName, $_GET)) {
                        if (array_key_exists($parameterName, $parameter[$path][$action][$httpMethod])) {
                            $type = array_key_exists('type', $parameterInfo) ? $parameterInfo['type'] : null;
                            $value = ($type != null) ?
                                Quarantine::clean($_GET[$parameterName], $type) : $defaultValues[$type];
                        }
                    } else {
                        $type = array_key_exists('type', $parameterInfo) ? $parameterInfo['type'] : null;
                        $value = ($type != null) ? $defaultValues[$type] : null;
                    }
                    $flowParameter['get.'.$parameterName] = $value;
                } else {
                    if ($httpMethod == 'POST') {
                        $value = '';
                        if (array_key_exists($parameterName, $_POST)) {
                            if (array_key_exists($parameterName, $_POST)) {
                                if (array_key_exists($parameterName, $parameter[$path][$action][$httpMethod])) {
                                    $type = array_key_exists('type', $parameterInfo) ? $parameterInfo['type'] : null;
                                    $value = ($type != null) ?
                                        Quarantine::clean($_POST[$parameterName], $type) : $defaultValues[$type];
                                }
                            } else {
                                $type = array_key_exists('type', $parameterInfo) ? $parameterInfo['type'] : null;
                                $value = ($type != null) ? $defaultValues[$type] : null;
                            }
                        }
                        $flowParameter['post.'.$parameterName] = $value;
                    }
                }
            }
        }

        $result = new Request(
            $original,
            $directory,
            $fileName,
            $path,
            $action,
            $systemParameter,
            $pageParameter,
            $flowParameter,
            $category,
            $httpMethod,
            $format
        );

        // return
        return $result;
    }
    #endregion
}

<?php

namespace Com\PaulDevelop\Library\Application;

//use Negotiation\Negotiator;

/**
 * RequestParser
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
class RequestParser
{
    #region member
    /**
     * @var ISanitizer
     */
    private $sanitizer;
    /**
     * @var IValidator
     */
    private $validator;
    #endregion

    #region constructor
    public function __construct(ISanitizer $sanitizer = null, IValidator $validator = null)
    {
        $this->sanitizer = $sanitizer;
        $this->validator = $validator;
    }
    #endregion

    #region methods
    //public function parse($path = '', $supportParseParameter = true)
    public function parse(IRequestInput $requestInput = null, $supportParseParameter = true)
    {
        $originalPath = ($requestInput->Path != '' && $requestInput->Path[0] == '/') ? substr($requestInput->Path, 1)
            : $requestInput->Path;
        $strippedPath = '';
        $pathParameter = array();
        $systemParameter = array();
        $getParameter = array();
        $postParameter = array();

        if ($supportParseParameter) {
            $chunks = preg_split('/\//', $requestInput->Path, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($chunks as $chunk) {
                if (($pos = strpos($chunk, '-')) !== false) {
                    $key = substr($chunk, 0, $pos);
                    $value = substr($chunk, $pos + 1);
                    $pathParameter[$key] = $value;
                } elseif (($pos = strpos($chunk, '_')) !== false) {
                    $key = substr($chunk, 0, $pos);
                    $value = substr($chunk, $pos + 1);
                    $systemParameter[$key] = $value;
                } else {
                    $strippedPath .= ($strippedPath == '' ? '' : '/').$chunk;
                }
            }
        }

        foreach ($_GET as $key => $value) {
            $getParameter[$key] = $value;
        }

        foreach ($_POST as $key => $value) {
            $postParameter[$key] = $value;
        }

        // TODO sanitize and validate

        // return
        return new Request(
            $requestInput,
            $originalPath,
            $strippedPath,
            $pathParameter,
            $systemParameter,
            $getParameter,
            $postParameter
        );
    }
    #endregion
}

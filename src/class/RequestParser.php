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
//    /**
//     * @var IValidator
//     */
//    private $validator;
    #endregion

    #region constructor
    public function __construct(ISanitizer $sanitizer = null) //, IValidator $validator = null)
    {
        $this->sanitizer = $sanitizer;
//        $this->validator = $validator;
    }
    #endregion

    #region methods
    //public function parse($path = '', $supportParseParameter = true)
    public function parse(IRequestInput $requestInput = null, $supportParseParameter = true)
    {
        $originalPath =
            ($requestInput->Path != '' && $requestInput->Path[0] == '/')
                ?
                substr($requestInput->Path, 1)
                :
                $requestInput->Path;
        $strippedPath = (!$supportParseParameter) ? $originalPath : '';
        $pathParameter = new ParameterCollection();
        $systemParameter = new ParameterCollection();
        //$getParameter = new ParameterCollection();
        //$postParameter = new ParameterCollection();

        if ($supportParseParameter) {
            $chunks = preg_split('/\//', $requestInput->Path, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($chunks as $chunk) {
                if (($pos = strpos($chunk, '-')) !== false) {
                    $key = substr($chunk, 0, $pos);
                    $value = substr($chunk, $pos + 1);
                    //$pathParameter[$key] = $value;
                    $pathParameter->add(new Parameter($key, $value), $key);
                } elseif (($pos = strpos($chunk, '_')) !== false) {
                    $key = substr($chunk, 0, $pos);
                    $value = substr($chunk, $pos + 1);
                    //$systemParameter[$key] = $value;
                    $systemParameter->add(new Parameter($key, $value), $key);
                } else {
                    $strippedPath .= ($strippedPath == '' ? '' : '/').$chunk;
                }
            }
        }

//        $this->validator->check($strippedPath, $requestInput->GetParameter);

        $getParameter = $requestInput->GetParameter;
        $postParameter = $requestInput->PostParameter;
        $patchParameter = $requestInput->PatchParameter;
        $headerParameter = $requestInput->HeaderParameter;
        $fileParameter = $requestInput->FileParameter;
        //foreach ($_GET as $key => $value) {
        //    //$getParameter[$key] = $value;
        //    $getParameter->add(new Parameter($key, $value), $key);
        //}

        //foreach ($_POST as $key => $value) {
        //    //$postParameter[$key] = $value;
        //    $postParameter->add(new Parameter($key, $value), $key);
        //}

        // TODO sanitize and validate

        // return
        return new Request(
            $requestInput,
            $originalPath,
            $strippedPath,
            $pathParameter,
            $systemParameter,
            $getParameter,
            $postParameter,
            $patchParameter,
            $headerParameter,
            $fileParameter
        );
    }
    #endregion
}

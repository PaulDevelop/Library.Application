<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * FunctionMapping
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string   $Pattern
 * @property bool     $SupportParseParameter
 * @property callable $Function
 */
class FunctionMapping extends Base implements IMapping
{
    private $pattern;
    private $supportParseParameter;
    private $function;

    public function __construct(
        $pattern = '',
        $supportParseParameter = false,
        callable $function = null
    ) {
        $this->pattern = $pattern;
        $this->function = $function;
    }

    public function process(Request $request)
    {
        /** @var \Closure $function */
        $function = $this->function;
        return $function($request);
        //$function->__invoke($request);
        //return $this->function->__invoke($request);
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getSupportParseParameter()
    {
        return $this->supportParseParameter;
    }

    protected function getFunction()
    {
        return $this->function;
    }
}

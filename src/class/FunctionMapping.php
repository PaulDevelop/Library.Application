<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\ITemplate;

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

    /**
     * @param Request   $request
     * @param ITemplate $template
     *
     * @return mixed
     */
    public function process(Request $request, ITemplate $template)
    {
        /** @var \Closure $function */
        $function = $this->function;
        return $function($request, $this);
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

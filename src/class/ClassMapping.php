<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * ClassMapping
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string      $Pattern
 * @property bool        $SupportParseParameter
 * @property IController $Object
 */
class ClassMapping extends Base implements IMapping
{
    private $pattern;
    private $supportParseParameter;
    private $object;

    public function __construct(
        $pattern = '',
        $supportParseParameter = false,
        IController $object = null
    ) {
        $this->pattern = $pattern;
        $this->object = $object;
    }

    public function process(Request $request = null)
    {
        return $this->object->process($request);
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getSupportParseParameter()
    {
        return $this->supportParseParameter;
    }

    protected function getObject()
    {
        return $this->object;
    }
}

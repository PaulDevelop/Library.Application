<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\ITemplate;

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
//        $this->object = $object;
        $className = get_class($object);
        $this->object = new $className($this);
    }

    public function process(Request $request = null, ITemplate $template = null)
    {
        return $this->object->process($request, $template);
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

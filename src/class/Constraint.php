<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

/**
 * Constraint
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string $Type
 * @property string $Value
 * @property string $ErrorText
 * @property string $ErrorTextKey
 */
class Constraint extends Base
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $errorText;

    /**
     * @var string
     */
    private $errorTextKey;

    /**
     * @param string $type
     * @param string $value
     * @param string $errorText
     * @param string $errorTextKey
     */
    public function __construct(
        $type = '',
        $value = '',
        $errorText = '',
        $errorTextKey = ''
    ) {
        $this->type = $type;
        $this->value = $value;
        $this->errorText = $errorText;
        $this->errorTextKey = $errorTextKey;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getErrorText()
    {
        return $this->errorText;
    }

    /**
     * @return string
     */
    public function getErrorTextKey()
    {
        return $this->errorTextKey;
    }
}

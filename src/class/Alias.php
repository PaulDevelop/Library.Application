<?php

namespace Com\PaulDevelop\Library\Application;


use Com\PaulDevelop\Library\Common\Base;

/**
 * Class Alias
 *
 * @package Com\PaulDevelop\Library\Application
 * @property string $Source
 * @property string $Target
 */
class Alias extends Base
{
    // region member
    /** @var string */
    private $source;

    /**
     * @var string
     */
    private $target;
    // endregion

    // region constructor
    /**
     * @param string $source
     * @param string $target
     */
    public function __construct($source = '', $target = '')
    {
        $this->source = $source;
        $this->target = $target;
    }
    // endregion

    // region properties
    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }
    // endregion
}

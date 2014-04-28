<?php

namespace Com\PaulDevelop\Library\Application;

use
    Com\PaulDevelop\Library\Common\EventArgs;

/**
 * RequestProcessedEventArgs
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property $Request
 */
class RequestProcessedEventArgs extends EventArgs
{
    #region member
    /**
     * Request
     *
     * @var Request
     */
    private $request;
    #endregion

    #region constructor
    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }
    #endregion

    #region properties
    /**
     * Tag.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    #endregion
}

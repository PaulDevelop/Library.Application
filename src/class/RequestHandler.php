<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * RequestHandler
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
class RequestHandler
{
    #region member
    /**
     * @var IUrlMapper
     */
    protected $urlMapper;
    #endregion

    #region methods
    /**
     * @param Application $app
     */
    public function onRequestHandled(Application $app = null)
    {
        //var_dump($this->urlMapper);
        //die;
        // dispatch url
        // check url access
        // mapper
        // SimpleFileMapper
        //$mapper = new UrlToFileMapper(); // FRONTEND_FS_TEMPLATE
        if ($this->urlMapper != null) {
            echo $this->urlMapper->process($app->Request);
        }
        // DatastoreMapper
        // ...
    }
    #endregion
}

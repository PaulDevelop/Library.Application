<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * Validator
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
class Validator implements IValidator
{
    public function check($actualParameter = array(), $desiredParameter = array())
    {
        // white list

        // data type

        // data value


        //filter_var($input, FILTER_)
        //INPUT_ GET, POST, PATH, SERVER, SESSION, (Request), COOKIE, ENV
        // bin/updateParameter => own tool, installed by composer?
    }
}

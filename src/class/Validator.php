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
    // region member
    /** @var FilterCollection */
    private $filter;
    // endregion

    // region constructor
    public function __construct()
    {
        $this->filter = new FilterCollection();
    }
    // endregion

    // region methods
    public function addFilter(Filter $filter = null)
    {
        $this->filter->add($filter, $filter->Path);
    }

    //public function check($actualParameter = array(), $desiredParameter = array())
    public function check($path = '', $source = '', ParameterCollection $actualParameterList = null)
    {
        var_dump($path);
        var_dump($this->filter[$path]);
        var_dump($this->filter);

//        if ($this->filter[$path] != null) {
        /** @var Filter $filter */
        if (($filter = $this->filter[$path]) != null) {
            /** @var FilterParameter $parameter */
            foreach ($filter->Parameter as $parameter) {
                // check, if correct source
                if ($parameter->Source != $source) {
                    continue;
                }

                // check, if demanded parameter is in actual parameter list
                if ($actualParameterList[$parameter->Name] != null) {
                    // check constraints

                }
            }
        }
        die;

        // white list

        // data type

        // data value


        //filter_var($input, FILTER_)
        //INPUT_ GET, POST, PATH, SERVER, SESSION, (Request), COOKIE, ENV
        // bin/updateParameter => own tool, installed by composer?
    }
    // endregion
}

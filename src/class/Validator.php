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
//    public function check($path = '', $source = '', ParameterCollection $actualParameterList = null)
//    {
//        // init
//        $result = null; // violated constraints
//
////        var_dump($path);
////        var_dump($this->filter[$path]);
////        var_dump($this->filter);
////
////        var_dump($actualParameterList);
//
////        if ($this->filter[$path] != null) {
//        /** @var Filter $filter */
//        if (($filter = $this->filter[$path]) != null) {
//            /** @var FilterParameter $demandedParameter */
//            foreach ($filter->ParameterList as $demandedParameter) {
//                // check, if correct source
////                echo 'SOURCE: '.$demandedParameter->Source.' vs. '.$source.PHP_EOL;
//                if ($demandedParameter->Source != $source) {
//                    continue;
//                }
//
//                // check, if demanded parameter is in actual parameter list
//
////                var_dump($actualParameterList[$demandedParameter->Name]);
////                $actualParameter = $actualParameterList[$demandedParameter->Name];
////                echo 'NAME: '.$demandedParameter->Name.' vs. '.$actualParameter->Name.PHP_EOL;
//                /** @var Parameter $actualParameter */
//                if (($actualParameter = $actualParameterList[$demandedParameter->Name]) != null) {
////                    echo "TEST";die;
//                    // check constraints
//                    /** @var Constraint $constraint */
//                    if (($constraint = $demandedParameter->ConstraintList['type']) != null) {
//                        //var_dump($constraint);
//                        if ($constraint->Value == 'xsd:int') {
//                            if (!filter_var($actualParameter->Value, FILTER_VALIDATE_INT)) {
//                                echo "FAILURE: ".$constraint->ErrorText.PHP_EOL;
//                            }
//                        }
//                    }
////                    /** @var Constraint $constraint */
////                    foreach ($demandedParameter->ConstraintList as $constraint) {
////                        if ($constraint->Type == 'required') {
////                            // value="true" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'type') {
////                            // value="xsd:string" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == 'xsd:int') {
////                                if ( !filter_var($actualParameter->Value, FILTER_VALIDATE_INT) ) {
////                                    echo "FAILURE: ".$constraint->ErrorText.PHP_EOL;
////                                }
////                            }
////                        } elseif ($constraint->Type == 'metaType') {
////                            // date, url, mail, ip, mac
////                            // value="mail" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'minLength') {
////                            // value="" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'maxLength') {
////                            // value="" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'regex') {
////                            // value="" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'minDate') {
////                            // currentDate, currentYear, currentMonth, currentDay, currentHour, currentMinute,
////                            // currentSecond
////                            // 18years: php date class syntax
////                            // value="%currentDate% - 18y" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'maxDate') {
////                            // value="" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'minValue') {
////                            // value="" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        } elseif ($constraint->Type == 'maxValue') {
////                            // value="" errorText="" errorTextKey=""/>
////                            if ($constraint->Value == '') {
////                            }
////                        }
////                    }
//                }
//            }
//        }
//        die;
//
//        // white list
//
//        // data type
//
//        // data value
//
//
//        //filter_var($input, FILTER_)
//        //INPUT_ GET, POST, PATH, SERVER, SESSION, (Request), COOKIE, ENV
//        // bin/updateParameter => own tool, installed by composer?
//    }

    /**
     * @param Request $request
     *
     * @return ConstraintViolationCollection
     */
    public function process(Request $request = null)
    {
        // init
        $result = array(); //new ConstraintViolationCollection();

        // action
        /** @var Filter $filter */
        if (($filter = $this->filter[$request->StrippedPath]) != null) {
            /** @var FilterParameter $demandedParameter */
            foreach ($filter->ParameterList as $demandedParameter) {
                // get
                if ($demandedParameter->Source == 'get') {
                    if (($actualParameter = $request->Input->GetParameter[$demandedParameter->Name]) != null) {
                        $result = array_merge(
                            $result,
                            $this->checkConstraints($actualParameter, $demandedParameter)->getIterator()->getArrayCopy()
                        );
                    }
                } elseif ($demandedParameter->Source == 'post') {
                    if (($actualParameter = $request->Input->PostParameter[$demandedParameter->Name]) != null) {
                        $result = array_merge(
                            $result,
                            $this->checkConstraints($actualParameter, $demandedParameter)->getIterator()->getArrayCopy()
                        );
                    }
                } elseif ($demandedParameter->Source == 'patch') {
                    if (($actualParameter = $request->Input->PatchParameter[$demandedParameter->Name]) != null) {
                        $result = array_merge(
                            $result,
                            $this->checkConstraints($actualParameter, $demandedParameter)->getIterator()->getArrayCopy()
                        );
                    }
                } elseif ($demandedParameter->Source == 'header') {
                    if (($actualParameter = $request->Input->HeaderParameter[$demandedParameter->Name]) != null) {
                        $result = array_merge(
                            $result,
                            $this->checkConstraints($actualParameter, $demandedParameter)->getIterator()->getArrayCopy()
                        );
                    }
                } elseif ($demandedParameter->Source == 'file') {
                    if (($actualParameter = $request->Input->FileParameter[$demandedParameter->Name]) != null) {
                        $result = array_merge(
                            $result,
                            $this->checkConstraints($actualParameter, $demandedParameter)->getIterator()->getArrayCopy()
                        );
                    }
                } elseif ($demandedParameter->Source == 'path') {
                    if (($actualParameter = $request->PathParameter[$demandedParameter->Name]) != null) {
                        $result = array_merge(
                            $result,
                            $this->checkConstraints($actualParameter, $demandedParameter)->getIterator()->getArrayCopy()
                        );
                    }
                } elseif ($demandedParameter->Source == 'system') {
                    if (($actualParameter = $request->SystemParameter[$demandedParameter->Name]) != null) {
                        $result = array_merge(
                            $result,
                            $this->checkConstraints($actualParameter, $demandedParameter)->getIterator()->getArrayCopy()
                        );
                    }
                }
            }
        }

        // return
        return new ConstraintViolationCollection($result);
    }

    /**
     * @param Parameter       $actualParameter
     * @param FilterParameter $demandedParameter
     *
     * @return ConstraintViolationCollection
     */
    public function checkConstraints(Parameter $actualParameter = null, FilterParameter $demandedParameter = null)
    {
        // init
        $result = new ConstraintViolationCollection();

        // check constraints
        /** @var Constraint $constraint */
        if (($constraint = $demandedParameter->ConstraintList['type']) != null) {
            //var_dump($constraint);
            if ($constraint->Value == 'xsd:int') {
                if (!filter_var($actualParameter->Value, FILTER_VALIDATE_INT)) {
//                    echo "FAILURE: ".$constraint->ErrorText.PHP_EOL;
                    // add to failure list
//                    new \Symfony\Component\Validator\ConstraintViolation()

                    $result->add(
                        new ConstraintViolation(
                            $actualParameter,
                            $constraint
                        ),
                        $actualParameter->Name
                    );
                }
            }
        } elseif (($constraint = $demandedParameter->ConstraintList['metaType']) != null) {
            // value="mail"
            // errorText="" errorTextKey=""/>
        } elseif (($constraint = $demandedParameter->ConstraintList['minLength']) != null) {
            // value=""
            // errorText="" errorTextKey=""/>
        } elseif (($constraint = $demandedParameter->ConstraintList['maxLength']) != null) {
            // value=""
            // errorText="" errorTextKey=""/>
        } elseif (($constraint = $demandedParameter->ConstraintList['regex']) != null) {
            // value=""
            // errorText="" errorTextKey=""/>
        } elseif (($constraint = $demandedParameter->ConstraintList['minDate']) != null) {
            // value="%currentDate% - 18y"
            // errorText="" errorTextKey=""/>
        } elseif (($constraint = $demandedParameter->ConstraintList['maxDate']) != null) {
            // value=""
            // errorText="" errorTextKey=""/>
        } elseif (($constraint = $demandedParameter->ConstraintList['minValue']) != null) {
            // value=""
            // errorText="" errorTextKey=""/>
        } elseif (($constraint = $demandedParameter->ConstraintList['maxValue']) != null) {
            // value=""
            // errorText="" errorTextKey=""/>
        }

        // return
        return $result;
    }
    // endregion
}

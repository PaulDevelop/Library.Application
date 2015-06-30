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
//        $this->filter->add($filter, $filter->Path);
        $this->filter->add($filter, $filter->Pattern);
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
        $constraintViolationList = array(); //new ConstraintViolationCollection();

        //$request->Input->

        // action


//        var_dump($this->filter);
//        die;

        /** @var Filter $filter */
        if (($filter = $this->findFilter($request)) != null) {
//            var_dump($filter);
//        }
//
//        die;
//
//
//        /** @var Filter $filter */
//        if (($filter = $this->filter[$request->StrippedPath]) != null) {
            /** @var FilterParameter $demandedParameter */
            foreach ($filter->ParameterList as $demandedParameter) {
                // get
                if ($demandedParameter->Source == 'get') {
                    if (($actualParameter = $request->Input->GetParameter[$demandedParameter->Name]) != null) {
                        $constraintViolationList += $this->checkConstraints($actualParameter, $demandedParameter)
                            ->getIterator()
                            ->getArrayCopy();
                    }
                } elseif ($demandedParameter->Source == 'post') {
                    if (($actualParameter = $request->Input->PostParameter[$demandedParameter->Name]) != null) {
                        $constraintViolationList += $this->checkConstraints($actualParameter, $demandedParameter)
                            ->getIterator()
                            ->getArrayCopy();
                    }
                } elseif ($demandedParameter->Source == 'patch') {
                    if (($actualParameter = $request->Input->PatchParameter[$demandedParameter->Name]) != null) {
                        $constraintViolationList += $this->checkConstraints($actualParameter, $demandedParameter)
                            ->getIterator()
                            ->getArrayCopy();
                    }
                } elseif ($demandedParameter->Source == 'header') {
                    if (($actualParameter = $request->Input->HeaderParameter[$demandedParameter->Name]) != null) {
                        $constraintViolationList += $this->checkConstraints($actualParameter, $demandedParameter)
                            ->getIterator()
                            ->getArrayCopy();
                    }
                } elseif ($demandedParameter->Source == 'file') {
                    if (($actualParameter = $request->Input->FileParameter[$demandedParameter->Name]) != null) {
                        $constraintViolationList += $this->checkConstraints($actualParameter, $demandedParameter)
                            ->getIterator()
                            ->getArrayCopy();
                    }
                } elseif ($demandedParameter->Source == 'path') {
                    if (($actualParameter = $request->PathParameter[$demandedParameter->Name]) != null) {
                        $constraintViolationList += $this->checkConstraints($actualParameter, $demandedParameter)
                            ->getIterator()
                            ->getArrayCopy();
                    }
                } elseif ($demandedParameter->Source == 'system') {
                    if (($actualParameter = $request->SystemParameter[$demandedParameter->Name]) != null) {
                        $constraintViolationList += $this->checkConstraints($actualParameter, $demandedParameter)
                            ->getIterator()
                            ->getArrayCopy();
                    }
                }
            }
        }

        // return
        $result = new ConstraintViolationCollection();
//        return new ConstraintViolationCollection($result);
        /** @var ConstraintViolation $constraintViolation */
        foreach ($constraintViolationList as $parameterName => $constraintViolation) {
            $result->add($constraintViolation, $parameterName);
        }
        return $result;
    }

    private function findFilter(Request $request = null)
    {
        // init
        $result = null;

        // action
        $url = '';
        if ($request->Input->Subdomains != '') {
            $url .= $request->Input->Subdomains.'.';
        }

        $url .= $request->Input->Host;
        if ($request->Input->Port != '') {
            $url .= ':'.$request->Input->Port;
        }
        if ($request->StrippedPath != '') {
            $url .= '/'.$request->StrippedPath;
        }
        $url = trim($url, "\t\n\r\0\x0B/");


        foreach ($this->filter as $filter) {
            $pattern = $filter->Pattern;

            // variables
            $pattern = str_replace('%baseHost%', str_replace('.', '\.', $request->Input->Host), $pattern);

            echo $pattern.' ~// '.$url.PHP_EOL;

            $hit = preg_match('/('.$pattern.')/', $url, $matches);

            var_dump($hit);
            var_dump($matches);

            if ($hit) {
                $result = $filter;
                break;
            }
        }

        // return
        return $result;
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


//        /** @var Constraint $constraint */
//        foreach ($demandedParameter->ConstraintList as $demandedParameter) {
//            $tmp = $this->checkPattern('%baseHost%/profile', $request->);
//            var_dump($tmp);
//            die;
//        }


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

//        echo "1111111".PHP_EOL;
//        var_dump($result);
//        echo "2222222".PHP_EOL;
//        var_dump($result->getIterator()->getArrayCopy());
//        die;

        // return
        return $result;
    }

//    /**
//     * @param string  $pattern
//     * @param bool    $supportParseParameter
//     * @param Request $request
//     *
//     * @return int
//     */
//    private function checkPattern($pattern = '', $supportParseParameter = false, Request $request = null)
//    {
//        $pattern = '/'.$pattern.'/';
//        $pattern = str_replace('%baseUrl%', str_replace('.', '\.', $request->Input->Host), $pattern);
//
//        // path
//        $path = '';
//        if ($request->Input->Subdomains != '') {
//            $path .= $request->Input->Subdomains.'.';
//        }
//        $path .= $request->Input->Host;
//        if ($request->Input->Port != '') {
//            $path .= ':'.$request->Input->Port;
//        }
//
//        if ($supportParseParameter == true) {
//            if ($request->StrippedPath != '') {
//                $path .= '/'.$request->StrippedPath;
//            }
//        } else {
//            if ($request->Input->Path != '') {
//                $path .= '/'.$request->Input->Path;
//            }
//        }
//
//        $path = trim($path, "\t\n\r\0\x0B/");
//
//        // match
//        $result = preg_match($pattern, $path);
//
//        // return
//        return $result;
//    }

    // endregion
}

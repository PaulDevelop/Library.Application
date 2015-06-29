<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;

class MyRequestInputValidation extends Base implements IRequestInput
{
    public function getMethod()
    {
        return 'GET';
    }

    public function getProtocol()
    {
        return 'http';
    }

    public function getSubdomains()
    {
        return '';
    }

    public function getDomain()
    {
        return 'pauldevelop.de';
    }

    public function getPort()
    {
        return '';
    }

    public function getPath()
    {
        return 'search';
    }

    public function getFormat()
    {
        return 'text/html';
    }

    public function getBaseUrl()
    {
        return 'http://pauldevelop.de/';
    }

    public function getHost()
    {
        return 'pauldevelop.de';
    }

    public function getUrl()
    {
        return 'http://pauldevelop.de/search/?fromEventId=1';
    }

    public function getGetParameter()
    {
        return new ParameterCollection(
            array(
                new Parameter(
                    'fromEventId',
                    'abc' // 1
                )
            ),
            'name'
        );
    }

    public function getPostParameter()
    {
        return new ParameterCollection();
    }

    public function getPatchParameter()
    {
        // TODO: Implement getPatchParameter() method.
    }

    public function getHeaderParameter()
    {
        // TODO: Implement getHeaderParameter() method.
    }

    public function getFileParameter()
    {
        // TODO: Implement getFileParameter() method.
    }
}

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testRequestValidator()
    {
        // create new validator with filters
        $validator = new Validator();
        $validator->addFilter(
            new Filter(
                'search',
                new FilterParameterCollection(
                    array(
                        new FilterParameter(
                            'fromEventId',
                            'get',
                            new ConstraintCollection(
                                array(
                                    new Constraint(
                                        'type',
                                        'xsd:int',
                                        'Value is not an integer.',
                                        ''
                                    ),
                                    new Constraint(
                                        'required',
                                        'true',
                                        '',
                                        ''
                                    ),
                                    new Constraint(
                                        'minValue',
                                        '1',
                                        'Value for from event ID must be greater zero.',
                                        ''
                                    )
                                ),
                                'type'
                            )
                        )
                    )
                ),
                'name'
            )
        );

        // mock input and request object
        $input = new MyRequestInputValidation();
        $requestParser = new RequestParser(new Sanitizer(), $validator);
        $request = $requestParser->parse($input);

        // find constraint violations
        $constraintViolationList = $request->ConstraintViolationList;
        if (count($constraintViolationList) > 0) {
            /** @var ConstraintViolation $constraintViolation */
            foreach ($constraintViolationList as $constraintViolation) {
                echo $constraintViolation->ActualParameter->Name
                    .' = '
                    .$constraintViolation->ActualParameter->Value
                    .' => '
                    .$constraintViolation->Constraint->ErrorText
                    .PHP_EOL;
            }
        }

        // assertion
        $expectedConstraintViolationList = new ConstraintViolationCollection(
            array(
                new ConstraintViolation(
                    new Parameter('fromEventId', 'abc'),
                    new Constraint('type', 'xsd:int', 'Value is not an integer.', '')
                )
            ),
            'parameterName'
        );
        $this->assertEquals($expectedConstraintViolationList, $constraintViolationList);
    }
}

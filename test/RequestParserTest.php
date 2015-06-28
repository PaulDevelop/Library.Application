<?php

namespace Com\PaulDevelop\Library\Application;

/*
class MyRequestHandler extends RequestHandler
{
    public function __construct()
    {
        $this->_urlMapper = new UrlToFileMapper(
            'Com\PaulDevelop\Library',
            '/home/vagrant/project/test/assets/src/template/frontend/',
            '/home/vagrant/project/test/assets/src/controller/frontend/'
        );
        $this->_urlMapper->RegisterFileNotFoundCallback(
            function (Request $request = null) {
                //header('Location: '.FRONTEND_URL_BASE);
                echo 'FileNotFound';
            }
        );
    }

    public function OnRequestHandled($app = null)
    {
        $this->_urlMapper->RegisterSetupTemplateCallback(
            function (Request $request = null, ITemplate $template = null) {
                return null;
            }
        );

        $this->_urlMapper->RegisterRenderTemplateFileNameCallback(
            function (Request $request = null) {
                return null;
            }
        );

        $this->_urlMapper->RegisterRenderControllerFileNameCallback(
            function (Request $request = null) {
                return null;
            }
        );

        $this->_urlMapper->RegisterRenderControllerClassNameCallback(
            function (Request $request = null) {
                return null;
            }
        );

        parent::OnRequestHandled($app);
    }
}
*/

class RequestParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testRequest()
    {
        /*
//        $baseObj = new BaseObject();
//        $this->assertEquals('property value', $baseObj->Property);
        $requestHandler = new RequestHandler();

        $application = new Application();
        $application->registerRequestProcessedEvent(
            $requestHandler,
            'OnRequestHandled'
        );

        $parameter = array();
        $application->processRequest(null, $parameter);


        //$request = $application->Request;
        //var_dump($request);
        */

        $input = new RequestInput('http://pauldevelop.de/some/', 'http://demo.pauldevelop.de/some/path/id-1/');
        $rp = new RequestParser(new Sanitizer(), new Validator());
        $request = $rp->parse($input);
        //var_dump($request);

        $this->assertEquals('some/path/id-1/', $request->OriginalPath);
        $this->assertEquals('some/path', $request->StrippedPath);
        $pc = new ParameterCollection();
        $pc->add(new Parameter('id', 1), 'id');
        $this->assertEquals($pc, $request->PathParameter);

        //RequestParser::parse('some/path', false, array());
    }

    /**
     * @test
     */
    public function testSubDomains()
    {
        $input = new RequestInput(
            'http://raufeldcontent.pauldevelop.de/',
            'http://backend.raufeldcontent.pauldevelop.de/'
        );
        $this->assertEquals('backend', $input->Subdomains);

        $input = new RequestInput('http://pauldevelop.de/', 'http://editor.pauldevelop.de/');
        $this->assertEquals('editor', $input->Subdomains);
    }

    /**
     * @test
     */
    public function testParameterAccess()
    {
        $input = new RequestInput('http://pauldevelop.de/some/', 'http://demo.pauldevelop.de/some/path/id-1/foo-bar/');
        $rp = new RequestParser(new Sanitizer(), new Validator());
        $request = $rp->parse($input);

        $this->assertEquals(true, $request->PathParameter->getBool('id', 0));
        $this->assertEquals(1, $request->PathParameter->getInt('id', 0));
        $this->assertEquals(10, $request->PathParameter->getInt('baz', 10));
        $this->assertEquals('bar', $request->PathParameter->getString('foo', ''));
    }

    // http://voyage-left.codio.io:3000
    // http://port-80.4y951ymaxcuzbyb9nqrrxuonopk138frq1mqu8ni7qjb57b9.box.codeanywhere.com
    // http://port-80.4y951ymaxcuzbyb9nqrrxuonopk138frq1mqu8ni7qjb57b9.box.codeanywhere.com/customer-raufeld/com.sommerco.khd/src/public/web/s

    /**
     * @test
     */
    public function testRequestValidator()
    {
        $input = new RequestInput('http://pauldevelop.de/some/', 'http://demo.pauldevelop.de/some/path/id-1/');
        $rp = new RequestParser(new Sanitizer(), new Validator();
        $request = $rp->parse($input);
        var_dump($request);
//
//        $this->assertEquals('some/path/id-1/', $request->OriginalPath);
//        $this->assertEquals('some/path', $request->StrippedPath);
//        $pc = new ParameterCollection();
//        $pc->add(new Parameter('id', 1), 'id');
//        $this->assertEquals($pc, $request->PathParameter);

        //RequestParser::parse('some/path', false, array());
    }
}

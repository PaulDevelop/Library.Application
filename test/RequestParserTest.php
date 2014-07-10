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

        $input = new RequestInput('some/path/id-1/');
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

}

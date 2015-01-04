<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\ITemplate;

class FolderMappingFormatJsonRequest extends Base implements IRequestInput
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
        return 'pauldevelop.com';
    }

    public function getPort()
    {
        return '81';
    }

    public function getPath()
    {
        return 'backend/user';
    }

    public function getFormat()
    {
        return 'application/json';
    }

    public function getBaseUrl()
    {
        return 'http://pauldevelop.com:81/';
    }

    public function getHost()
    {
        return 'pauldevelop.com';
    }

    public function getUrl()
    {
        return 'http://pauldevelop.com:81/backend/user/';
    }

    public function getGetParameter()
    {
        return new ParameterCollection();
    }

    public function getPostParameter()
    {
        return new ParameterCollection();
    }
}

class FolderMappingTemplate extends Base implements ITemplate
{
    private $templateFileName = '';

    /**
     * @return string
     */
    public function process()
    {
        // TODO: Implement process() method.
        //echo 'Template Content'.PHP_EOL;
        //var_dump($this->TemplateFileName);
    }

    public function setTemplateFileName($templateFileName = '')
    {
        $this->templateFileName = $templateFileName;
    }

    public function getTemplateFileName()
    {
        return $this->templateFileName;
    }

    public function bindVariable($variableName = '', $content = null)
    {
        // TODO: Implement bindVariable() method.
    }
}

class FolderMappingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testMappingFormatJson()
    {
        $mapper = new UrlToFileMapper();
        $mapper->mapFolder(
            '^pauldevelop\.com:81\/backend\/',
            true,
            array('De\Welt\JobPortal'),
            'Controller\Backend',
            APP_FS_CONTROLLER.'',
            APP_FS_TEMPLATE.'backend'
        );

        $rp = new RequestParser(new Sanitizer(), new Validator());
        $request = $rp->parse(new FolderMappingFormatJsonRequest());

        $template = new FolderMappingTemplate();

        $output = $mapper->process($request, $template);

        $this->assertEquals('path/to/templates/backend/json.get.user.template.pdt', $template->TemplateFileName);
    }
}

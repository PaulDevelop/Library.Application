<?php

namespace Com\PaulDevelop\Library\Application;

use Com\PaulDevelop\Library\Common\Base;
use Com\PaulDevelop\Library\Common\ITemplate;
use com\pauldevelop\template\PeerHelper;

/**
 * DatabaseMapping
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @property string $Pattern
 * @property bool   $SupportParseParameter
 * @property string $Table
 * @property string $Field
 * @property string $Value
 * @property string $Template
 * @property string $Class
 */
class DatabaseMapping extends Base implements IMapping
{
    // region member
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var bool
     */
    private $supportParseParameter;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $object;
    // endregion

    // region constructor
    /**
     * @param string      $pattern
     * @param bool        $supportParseParameter
     * @param string      $table
     * @param string      $field
     * @param string      $value
     * @param string      $template
     * @param IController $object
     */
    public function __construct(
        $pattern = '',
        $supportParseParameter = false,
        $table = '',
        $field = '',
        $value = '',
        $template = '',
        IController $object = null
    ) {
        $this->pattern = $pattern;
        $this->supportParseParameter = $supportParseParameter;
        $this->table = $table;
        $this->field = $field;
        $this->value = $value;
        $this->template = $template;
        $className = get_class($object);
        $this->object = new $className($this);
    }
    // endregion

    // region methods
    /**
     * @param Request   $request
     * @param ITemplate $template
     *
     * @return string
     */
    public function process(Request $request = null, ITemplate $template = null)
    {
        // init
        $result = '';

        $path = $this->getCleanPath($request, $this->getSupportParseParameter());//$request->StrippedPath;
        $methodName = 'get'.ucfirst($this->table).'Peer';

        // search page in database
        ///** @var Page $page */
        $dbObj = PeerHelper::$methodName()->querySinglePath(''.$this->table.'[@'.$this->field.'='.$path.']#');
        if ($dbObj != null) {
//        $template->setTemplateFileName(APP_FS_TEMPLATE.'frontend'.DIRECTORY_SEPARATOR.$this->template);
            $template->setTemplateFileName($this->template);
            $template->bindVariable('page', $dbObj->getStdClass());

            /** @var IController $object */
            $object = $this->object;
            $result = $object->process($request, $template);
        }

        // return
        return $result;
    }

    private function getCleanPath(Request $request, $supportParseParameter = false)
    {
        // init
        $result = '';

        // action
        if ($supportParseParameter == true) {
            if ($request->StrippedPath != '') {
                $result .= $request->StrippedPath;
            }
        } else {
            if ($request->Input->Path != '') {
                $result .= $request->Input->Path;
            }
        }

        $result = trim($result, "\t\n\r\0\x0B/");

        // return
        return $result;
    }
    // endregion

    // region properties
    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return boolean
     */
    public function getSupportParseParameter()
    {
        return $this->supportParseParameter;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    protected function getObject()
    {
        return $this->object;
    }
    // endregion
}

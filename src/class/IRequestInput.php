<?php

namespace Com\PaulDevelop\Library\Application;

/**
 * FunctionMapping
 *
 * @package  Com\PaulDevelop\Library\Application
 * @category Application
 * @author   Rüdiger Scheumann <code@pauldevelop.com>
 * @license  http://opensource.org/licenses/MIT MIT
 *
 * @property string              $BaseUrl
 * @property string              $Host
 * @property string              $Url
 * @property string              $Method
 * @property string              $Protocol
 * @property string              $Subdomains
 * @property string              $Domain
 * @property string              $Port
 * @property string              $Path
 * @property string              $Format
 * @property ParameterCollection $GetParameter
 * @property ParameterCollection $PostParameter
 */
interface IRequestInput
{
    /**
     * @return string
     */
    public function getBaseUrl();

    /**
     * @return string
     */
    public function getHost();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getProtocol();

    /**
     * @return string
     */
    public function getSubdomains();

    /**
     * @return string
     */
    public function getDomain();

    /**
     * @return string
     */
    public function getPort();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getFormat();

    /**
     * @return ParameterCollection
     */
    public function getGetParameter();

    /**
     * @return ParameterCollection
     */
    public function getPostParameter();
}

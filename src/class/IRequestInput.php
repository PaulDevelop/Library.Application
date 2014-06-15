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
 * @property string $Method
 * @property string $Protocol
 * @property string $Subdomains
 * @property string $Domain
 * @property string $Port
 * @property string $Path
 * @property string $Format
 */
interface IRequestInput
{
    public function getMethod();

    public function getProtocol();

    public function getSubdomains();

    public function getDomain();

    public function getPort();

    public function getPath();

    public function getFormat();
}

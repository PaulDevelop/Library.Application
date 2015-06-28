<?php

setlocale(LC_ALL, 'de_DE');
date_default_timezone_set('Europe/Berlin');

//php_ini('include_path')
//set_include_path(get_include_path())
//echo "current working directory: ";
//echo exec('pwd');
//die;
//set_include_path(get_include_path() . PATH_SEPARATOR . '');

include_once('project/lib/vendor/autoload.php');

define('APP_FS_CONTROLLER', 'path/to/controller/');
define('APP_FS_TEMPLATE', 'path/to/templates/');

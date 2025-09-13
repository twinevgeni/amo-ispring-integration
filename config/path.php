<?php

define('DS', DIRECTORY_SEPARATOR);
define('DIR_ROOT', dirname(__DIR__));

define('DIR_LOG_DEFAULT', DIR_ROOT . DS . 'log');
$___logPath = getenv('LOG_PATH');
if ($___logPath == null || $___logPath == '')
{
    $___logPath = DIR_LOG_DEFAULT;
}
define('DIR_LOG', $___logPath);

define('DIR_TOKEN', DIR_ROOT . DS . 'token');
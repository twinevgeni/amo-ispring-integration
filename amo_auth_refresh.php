<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php";

use amoispring\helpers\amo\AmoApiHelper;
use amoispring\helpers\common\LoggerHelper;

$logger = LoggerHelper::getLogger("amo_auth_refresh.php");
$logger->info('amo_auth_refresh.php call');

$amoApiHelper = AmoApiHelper::getInstance();
$apiClient = $amoApiHelper->getApiClient();
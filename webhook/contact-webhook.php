<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php";

use jewellclub\controllers\ContactController;

$contactsController = ContactController::getInstance();
$contactsController->onContactWebhook();
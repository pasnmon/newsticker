<?php

require_once 'inc/functions.inc.php';
require_once 'inc/helper.inc.php';

require_once 'inc/bootstrap.inc.php';

// Session needed for flash messages
session_start();

// Path to our index.php
$basePath = dirname(__FILE__);

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'index';
$controller	=	preg_replace('/[^a-z]/',	'',	$controller);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$controller	=	preg_replace('/[^a-z]/',	'',	$controller);

$controllerNamespace = 'Controllers\\';
$controllerName = $controllerNamespace . ucfirst($controller) . 'Controller';

if (class_exists($controllerName)) {
    $requestController = new $controllerName($basePath, $em);
    $requestController->run($action);
} else {
    echo "t1";
    $requestController = new Controllers\IndexController($basePath, $em);
    $requestController->render404();
}
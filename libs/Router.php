<?php

declare(strict_types=1);

$controllerName = ucfirst(filter_var(trim(($_GET['controller'] ?? 'login')), FILTER_SANITIZE_STRING));
$actionName = filter_var(trim(($_GET['action'] ?? 'index')), FILTER_SANITIZE_STRING);

Auth::path([$controllerName, $actionName]);

$path = '';
$api = filter_var(trim(($_GET['api'] ?? '')), FILTER_SANITIZE_STRING);

switch ($api) {
    case 'api':
        require_once 'core/Api.php';

        $path = 'api/' . API_VERSION . '/';
        $controllerName = $controllerName . 'Api';
        break;
    default:
        require_once 'helpers/Head.php';
        require_once 'helpers/Footer.php';
        require_once 'helpers/View.php';
        require_once 'helpers/Menu.php';
        require_once 'core/Controller.php';

        $path = 'controllers/';
        $controllerName = $controllerName . 'Controller';
        break;
}

require_once 'libs/autoload.php';

if (!file_exists($path . $controllerName . '.php')) {
    ErrorHandler::response(404);
}

if (!class_exists($controllerName)) {
    ErrorHandler::response(404);
}

$controller = new $controllerName();

if (empty($actionName)) {
    ErrorHandler::response(500);
}

if (!method_exists($controller, $actionName)) {
    ErrorHandler::response(404);
}

$controller->$actionName();

<?php

if (file_exists('controller/user_controller.php')) {
    $controller = $_REQUEST['controller'] ?? 'user';
    $action = $_REQUEST['action'] ?? 'index_users';

    require_once "controller/{$controller}_controller.php";
    $controller = ucwords($controller) . 'Controller';
    $controllerInstance = new $controller();
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        die("Action {$action} not found in controller {$controller}");
    }
} else {
    die("Ocurrio un error, contacte al administrador del sistema");
}

<?php

require '../vendor/autoload.php';
use App\MediaPost\Controllers\ContatosController as ContatosController;
use App\MediaPost\Factorys\ControllersFactory as ControllersFactory;

if (!filter_input(INPUT_GET, 'controller') && !filter_input(INPUT_GET, 'action')) {
    $controller = new ContatosController();
    $controller->index();
} else {
    $controllerInput = filter_input(INPUT_GET, 'controller')."Controller";
    $actionInput     = filter_input(INPUT_GET, 'action');
    //$paramsImput     = filter_input(INPUT_GET, 'params');
    $paramsImput     = isset($_GET['params']) ? $_GET['params'] : [0];   
    $paramsImput     = is_array($paramsImput) ? $paramsImput : [$paramsImput];

    $controller = ControllersFactory::create($controllerInput);

    call_user_func_array(
        [$controller, $actionInput], 
        $paramsImput
    );
}
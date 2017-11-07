<?php

namespace App\MediaPost\Factorys;

use App\MediaPost\Controllers\ContatosController as ContatosController;


class ControllersFactory
{
    public static function create($controllerName)
    {
        $controller = "App\\MediaPost\\Controllers\\$controllerName";
        return new $controller;
    }
}

<?php

namespace App\MediaPost\Controllers;

class BaseController
{
    public function getView($view, $data, $statusCode = 200)
    {
        $data;
        $path_view = __DIR__."/../views/{$view}.php";
        //$viewRender = file_get_contents($path_view);
        http_response_code($statusCode);
        include $path_view;
    }

    public function validarRequeridos($input, $requeridos)
    {
        foreach ($requeridos as $campo => $filtro) {
            if (!isset($input->$campo))
                return false;
            switch ($filtro) {
                case 'int':
                if (!filter_var($input->$campo, FILTER_SANITIZE_NUMBER_INT))
                    return false;
                    break;
                case 'string':
                if (!filter_var($input->$campo, FILTER_SANITIZE_STRING))
                    return false;
                    break;
                case 'email':
                if (!filter_var($input->$campo, FILTER_SANITIZE_EMAIL))
                    return false;
                    break;

            }
        }
        return $input;
    }
}
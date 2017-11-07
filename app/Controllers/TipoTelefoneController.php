<?php

namespace App\MediaPost\Controllers;

use App\MediaPost\Models\TipoTelefone;
use App\MediaPost\Controllers\BaseController;

class TipoTelefoneController extends BaseController
{
    public function get($id)
    { 
        $email = new TipoTelefone();
         if ($id) {
            $id = (int) $id;
            $data['tipos'] = $email->get($id);
        } else {
            $data['tipos'] = $email->getAll();
        }
        $this->getView('json-tipos', $data);
    }
}
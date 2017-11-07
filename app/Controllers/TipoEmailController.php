<?php

namespace App\MediaPost\Controllers;

use App\MediaPost\Models\TipoEmail;
use App\MediaPost\Controllers\BaseController;

class TipoEmailController extends BaseController
{
    public function get($id)
    { 
        $email = new TipoEmail();
         if ($id) {
            $id = (int) $id;
            $data['tipos'] = $email->get($id);
        } else {
            $data['tipos'] = $email->getAll();
        }
        $this->getView('json-tipos', $data);
    }
}
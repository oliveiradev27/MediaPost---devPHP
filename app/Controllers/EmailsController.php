<?php

namespace App\MediaPost\Controllers;

use App\MediaPost\Models\Emails;
use App\MediaPost\Controllers\BaseController;

class EmailsController extends BaseController
{
    public function get($id)
    { 
        $email = new Emails();
         if ($id) {
            $id = (int) $id;
            $data['emails'] = $email->get($id);
        } else {
            $data['emails'] = $email->getAll();
        }
        $this->getView('json-emails', $data);
    }

    public function getByContato($id)
    { 
        $email = new Emails();
         if ($id) {
            $id = (int) $id;
            $data['emails'] = $email->getByContato($id);
            $this->getView('json-emails', $data);
        } else {
            $this->getView(
                'json-message', 
                ['message' => "Id do contato é obrigatório!"],
                400
            );
        }
    }

    public function add()
    {
        $input   = json_decode(file_get_contents("php://input"));
        $camposRequeridos = [
            'descricao'  => 'string',
            'contatoId'  => 'int',
            'tipo'       => 'int'
        ];

        $input = $this->validarRequeridos($input, $camposRequeridos);
        if ($input) {
            $email = new Emails();
            $email->setDescricao(htmlentities($input->descricao, ENT_QUOTES, 'UTF-8'));
            $email->setContato($input->contatoId);
            $email->setTipo($input->tipo);
            if ($email->add())
                $this->getView(
                    'json-insert-id', 
                    ['id' => $email->getId()],
                    200
                );
            else 
                $this->getView(
                    'json-message', 
                    ['message' => 'Erro, tente novamente!'],
                    500
                );
        } else {
            $this->getView(
                'json-message', 
                ['message' => 'Erro, verifique os dados e tente novamente!'],
                400
            ); 
        }
    }

    public function upd()
    {
       
        $input   = json_decode(file_get_contents("php://input"));
        $camposRequeridos = [
            'descricao'  => 'string',
            'contatoId'  => 'int',
            'tipo'       => 'int',
            'id'         => 'int'
        ];

        $input = $this->validarRequeridos($input, $camposRequeridos);
        if ($input) {
            $email = new Emails();
            $email->setId($input->id);
            $email->setDescricao(htmlentities($input->descricao, ENT_QUOTES, 'UTF-8'));
            $email->setContato($input->contatoId);
            $email->setTipo($input->tipo);
            if ($email->upd())
            $this->getView(
                'json-message', 
                ['message' => 'Cadastrado com sucesso!'],
                200
            );
        else 
            $this->getView(
                'json-message', 
                ['message' => 'Erro, tente novamente!'],
                500
            );
        } else {
            $this->getView(
                'json-message', 
                ['message' => 'Erro, verifique os dados e tente novamente!'],
                400
            ); 
        }
    }

    public function del($id)
    {
        $email = new Emails();
        if ($id) {
            $id = (int) $id;
            $resultado = $email->del($id);
            if ($resultado) {
                $this->getView(
                    'json-message', 
                    ['message' => 'Excluido com sucesso!'],
                    200
                );
            }
        } else {
            $this->getView('json-404', null, 404);
        }
    }
}
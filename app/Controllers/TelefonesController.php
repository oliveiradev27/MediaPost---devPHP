<?php

namespace App\MediaPost\Controllers;

use App\MediaPost\Models\Telefones;
use App\MediaPost\Controllers\BaseController;

class TelefonesController extends BaseController
{
    public function get($id)
    { 
        $telefone = new Telefones();
         if ($id) {
            $id = (int) $id;
            $data['telefones'] = $telefone->get($id);
        } else {
            $data['telefones'] = $telefone->getAll();
        }
        $this->getView('json-telefones', $data);
    }

    public function getByContato($id)
    { 
        $telefone = new Telefones();
         if ($id) {
            $id = (int) $id;
            $data['telefones'] = $telefone->getByContato($id);
            $this->getView('json-telefones', $data);
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
            $telefone = new Telefones();
            $telefone->setDescricao(htmlentities($input->descricao, ENT_QUOTES, 'UTF-8'));
            $telefone->setContato($input->contatoId);
            $telefone->setTipo($input->tipo);
            if ($telefone->add())
                $this->getView(
                    'json-insert-id', 
                    ['id' => $telefone->getId()],
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
            $telefone = new Telefones();
            $telefone->setId($input->id);
            $telefone->setDescricao(htmlentities($input->descricao, ENT_QUOTES, 'UTF-8'));
            $telefone->setContato($input->contatoId);
            $telefone->setTipo($input->tipo);
            if ($telefone->upd())
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
        $telefone = new Telefones();
        if ($id) {
            $id = (int) $id;
            $resultado = $telefone->del($id);
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
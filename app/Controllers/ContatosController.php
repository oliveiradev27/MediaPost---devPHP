<?php

namespace App\MediaPost\Controllers;

use App\MediaPost\Models\Contatos;
use App\MediaPost\Controllers\BaseController;

class ContatosController extends BaseController
{
    public function index()
    {
        $data['title'] = 'MediaPost | Gerenciamento de Contatos';
        $this->getView("main", $data);
    }

    public function add()
    {
        $input   = json_decode(file_get_contents("php://input"));
        $camposRequeridos = [
            'nome'  => 'string'
        ];

        $input = $this->validarRequeridos($input, $camposRequeridos);
        if ($input) {
            $contato = new Contatos();
            $input   = json_decode(file_get_contents("php://input"));
            $contato->setNome(htmlentities($input->nome, ENT_QUOTES, 'UTF-8'));
            if ($contato->add())
                $this->getView(
                    'json-insert-id', 
                    ['id' => $contato->getId()],
                    200
                );
            else 
                $this->getView(
                    'json-message', 
                    ['message' => 'Erro, verifique os dados e tente novamente!'],
                    400
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
            'id'    => 'int',
            'nome'  => 'string'
        ];

        $input = $this->validarRequeridos($input, $camposRequeridos);
        if ($input) {
        $contato = new Contatos();
        $contato->setId(htmlentities($input->id, ENT_QUOTES, 'UTF-8'));
        $contato->setNome(htmlentities($input->nome, ENT_QUOTES, 'UTF-8'));
        if ($contato->upd())
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

    public function get($id, $limit = null, $offset = null, $termo = null)
    { 
        $limit  = (int) $limit;
        $offset = (int) $offset;
        $termo  = (string) $termo;
        $contato = new Contatos();
         if ($id) {
            $id = (int) $id;
            $data['contatos'] = $contato->get($id);
        } else {
            if ($termo)
                $data = $contato->getByBusca($termo);
            else if ($limit)
                $data['contatos'] = $contato->getByPaginacao($limit, $offset);
            else
                $data['contatos'] = $contato->getAll();
        }
        $this->getView('json-contatos', $data);
    }

    public function getQuantidade()
    { 
           $contato = new Contatos();
            $data['quantidade'] = $contato->getQuantidadeTotal();
            $data['entidade']   = 'contatos';
        $this->getView('json-count', $data);
    }


    public function del($id)
    {
        $contato = new Contatos();
        if ($id) {
            $id = (int) $id;
            $resultado = $contato->del($id);
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
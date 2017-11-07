<?php

namespace App\MediaPost\Models;

use App\MediaPost\Models\Dao\TelefonesDao;

class Telefones
{
    private $id, $descricao, $tipo, $contato;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getContato()
    {
        return $this->contato;
    }

    public function setContato($contato)
    {
        $this->contato = $contato;
    }

    public function get($id)
    {
        $id = (int) $id;
        $dao = new TelefonesDao();
        return $dao->get($id);
    }

    public function getAll()
    {
        $dao = new TelefonesDao();
        return $dao->getAll();
    }

    public function getByContato($id)
    {
        $id = (int) $id;
        $dao = new TelefonesDao();
        return $dao->getByContato($id);
    }

    public function del($id)
    {
        $id = (int) $id;
        $dao = new TelefonesDao();
        return $dao->del($id);
    }

    public function delByContato($id)
    {
        $id = (int) $id;
        $dao = new TelefonesDao();
        return $dao->delByContato($id);
    }

    public function add()
    {
        $dao = new TelefonesDao();
        $this->setId($dao->add($this));
        return $this->getId();
    }

    public function upd()
    {
        $dao = new TelefonesDao();
        return $dao->upd($this);
    }

}
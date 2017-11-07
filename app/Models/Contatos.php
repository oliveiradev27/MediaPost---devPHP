<?php

namespace App\MediaPost\Models;

use App\MediaPost\Models\Dao\ContatosDao;
use App\MediaPost\Models\Emails;
use App\MediaPost\Models\Telefones;

class Contatos 
{
    private $id, $nome;
 
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function get($id)
    {
        $id = (int) $id;
        $dao = new ContatosDao();
        return $dao->get($id);
    }

    public function getAll()
    {
        $dao = new ContatosDao();
        return $dao->getAll();
    }

    public function getByPaginacao($limit, $offiset)
    {
        $dao = new ContatosDao();
        return $dao->getByPaginacao($limit, $offiset);
    }

    public function getQuantidadeTotal()
    {
        $dao = new ContatosDao();
        return $dao->getQuantidadeTotal();
    }

    public function getByBusca($termo)
    {
        $dao = new ContatosDao();
        return $dao->getByBusca($termo);
    }

    public function add()
    {
        $dao = new ContatosDao();
        $this->setId($dao->add($this));
        return $this->getId();
    }

    public function upd()
    {
        $dao = new ContatosDao();
        $this->setId($dao->upd($this));
        return $this->getId();
    }

    public function del($id)
    {
        $id = (int) $id;
        $telefones = new Telefones();
        $telefones->delByContato($id);
        $emails = new Emails();
        $emails->delByContato($id);
        $dao = new ContatosDao();
        return $dao->del($id);

    }
}
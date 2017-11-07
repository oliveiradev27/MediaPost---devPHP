<?php

namespace App\MediaPost\Models;

use App\MediaPost\Models\Dao\TipoTelefoneDao;

class TipoTelefone
{
    private $id, $descricao;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
    
    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao)
    {
        $this->descricao = $descricao;
    }

    public function get($id)
    {
        $id = (int) $id;
        $dao = new TipoTelefoneDao();
        return $dao->get($id);
    }

    public function getAll()
    {
        $dao = new TipoTelefoneDao();
        return $dao->getAll();
    }
   
}
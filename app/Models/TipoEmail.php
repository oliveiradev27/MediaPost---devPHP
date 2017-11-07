<?php

namespace App\MediaPost\Models;

use App\MediaPost\Models\Dao\TipoEmailDao;

class TipoEmail
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
        $dao = new TipoEmailDao();
        return $dao->get($id);
    }

    public function getAll()
    {
        $dao = new TipoEmailDao();
        return $dao->getAll();
    }
}
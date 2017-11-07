<?php

namespace App\MediaPost\Models\Dao;

use App\MediaPost\Models\TipoTelefone;
use App\MediaPost\Interfaces\Dao;
use App\MediaPost\Config\Database;
use \PDO;

class TipoTelefoneDao implements Dao
{
    public function get($id)
    {
        $conn = Database::getConnection()->prepare('SELECT * FROM tipos_telefone WHERE id = :id');
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchObject('App\MediaPost\Models\TipoTelefone');
        
    }

    public function getAll(){

        $conn = Database::getConnection()->prepare(
                    'SELECT * FROM tipos_telefone'
        );

        $conn->execute();
        return $conn->fetchAll(
                 PDO::FETCH_CLASS,
                 'App\MediaPost\Models\TipoTelefone'
        );
    }

    public function add($data){
    }

    public function upd($data){
    }

    public function del($id){
    }
}
<?php

namespace App\MediaPost\Models\Dao;

use App\MediaPost\Models\TipoEmail;
use App\MediaPost\Interfaces\Dao;
use App\MediaPost\Config\Database;
use \PDO;

class TipoEmailDao implements Dao
{
    public function get($id)
    {
        $conn = Database::getConnection()->prepare('SELECT * FROM tipos_email WHERE id = :id');
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchObject('App\MediaPost\Models\TipoEmail');
        
    }

    public function getAll(){

        $conn = Database::getConnection()->prepare(
                    'SELECT * FROM tipos_email'
        );

        $conn->execute();
        return $conn->fetchAll(
                 PDO::FETCH_CLASS,
                 'App\MediaPost\Models\TipoEmail'
        );
    }

    public function add($data){
    }

    public function upd($data){
    }

    public function del($id){
    }
}
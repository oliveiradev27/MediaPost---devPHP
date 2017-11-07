<?php

namespace App\MediaPost\Models\Dao;

use App\MediaPost\Models\Telefones;
use App\MediaPost\Interfaces\Dao;
use App\MediaPost\Config\Database;
use \PDO;

class TelefonesDao implements Dao
{
    public function get($id)
    {
        $conn = Database::getConnection()->prepare(
            'SELECT 
                telefones.id, 
                telefones.descricao, 
                contatos.id as contato,
                tipos_telefone.id as tipo
            FROM 
                telefones 
            INNER JOIN 
                contatos
            ON contatos.id = telefones.contato_id
            INNER JOIN
                tipos_telefone
            ON tipos_telefone.id = telefones.tipo_id 
            WHERE telefones.id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchObject('App\MediaPost\Models\Telefones');
        
    }

    public function getByContato($id)
    {
        $conn = Database::getConnection()->prepare(
            'SELECT 
                telefones.id, 
                telefones.descricao, 
                contatos.id as contato,
                tipos_telefone.descricao as tipo
            FROM 
                telefones 
            INNER JOIN 
                contatos
            ON contatos.id = telefones.contato_id
            INNER JOIN
                tipos_telefone
            ON tipos_telefone.id = telefones.tipo_id 
            WHERE contatos.id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchAll(PDO::FETCH_CLASS, 'App\MediaPost\Models\Telefones');
        
    }

    public function getAll(){

        $conn = Database::getConnection()->prepare(
                    'SELECT * FROM telefones'
        );

        $conn->execute();
        return $conn->fetchAll(
                 PDO::FETCH_CLASS,
                 'App\MediaPost\Models\Telefones'
        );
    }

    public function add($data){
        $conn = Database::getConnection()->prepare(
            'INSERT INTO 
                telefones (descricao, contato_id, tipo_id) 
            VALUES 
                (:descricao, :contato_id, :tipo_id)'
        );
        $conn->bindValue(':descricao', $data->getDescricao(), PDO::PARAM_STR);
        $conn->bindValue(':contato_id', $data->getContato(), PDO::PARAM_INT);
        $conn->bindValue(':tipo_id', $data->getTipo(), PDO::PARAM_INT);
        $conn->execute();
        return Database::getConnection()->lastInsertId();
    }

    public function upd($data){
        $conn = Database::getConnection()->prepare(
            'UPDATE 
                telefones 
            SET 
                descricao   = :descricao, 
                contato_id  = :contato_id,
                tipo_id     = :tipo_id
            WHERE id = :id'
        );
        $conn->bindValue(':id',   $data->getId(),   PDO::PARAM_INT);
        $conn->bindValue(':descricao', $data->getDescricao(), PDO::PARAM_STR);
        $conn->bindValue(':contato_id', $data->getContato(), PDO::PARAM_INT);
        $conn->bindValue(':tipo_id', $data->getTipo(), PDO::PARAM_INT);
        $conn->execute();
        return $conn->rowCount();
    }

    public function del($id){
        $conn = Database::getConnection()->prepare(
            'DELETE FROM telefones WHERE id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->rowCount();
    }

    public function delByContato($id){
        $conn = Database::getConnection()->prepare(
            'DELETE FROM telefones WHERE contato_id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->rowCount();
    }
}
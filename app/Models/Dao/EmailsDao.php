<?php

namespace App\MediaPost\Models\Dao;

use App\MediaPost\Models\Emails;
use App\MediaPost\Interfaces\Dao;
use App\MediaPost\Config\Database;
use \PDO;

class EmailsDao implements Dao
{
    public function get($id)
    {
        $conn = Database::getConnection()->prepare('SELECT * FROM emails WHERE id = :id' );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchObject('App\MediaPost\Models\Emails');
        
    }

    public function getByContato($id)
    {
        $conn = Database::getConnection()->prepare(
            'SELECT 
                emails.id, 
                emails.descricao, 
                contatos.id as contato,
                tipos_email.descricao as tipo
            FROM 
                emails 
            INNER JOIN 
                contatos
            ON contatos.id = emails.contato_id
            INNER JOIN
                tipos_email
            ON tipos_email.id = emails.tipo_id 
            WHERE contatos.id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchAll(PDO::FETCH_CLASS, 'App\MediaPost\Models\Emails');
        
    }

    public function getAll(){

        $conn = Database::getConnection()->prepare(
                    'SELECT * FROM emails'
        );

        $conn->execute();
        return $conn->fetchAll(
                 PDO::FETCH_CLASS,
                 'App\MediaPost\Models\Emails'
        );
    }

    public function add($data){
        $conn = Database::getConnection()->prepare(
            'INSERT INTO 
                emails (descricao, contato_id, tipo_id) 
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
                emails 
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
            'DELETE FROM emails WHERE id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->rowCount();
    }

    public function delByContato($id){
        $conn = Database::getConnection()->prepare(
            'DELETE FROM emails WHERE contato_id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->rowCount();
    }

}
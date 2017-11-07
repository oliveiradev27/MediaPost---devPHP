<?php

namespace App\MediaPost\Models\Dao;

use App\MediaPost\Models\Contatos;
use App\MediaPost\Interfaces\Dao;
use App\MediaPost\Config\Database;
use \PDO;

class ContatosDao implements Dao
{
    public function get($id)
    {
        $conn = Database::getConnection()->prepare('SELECT * FROM contatos WHERE id = :id' );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchObject('App\MediaPost\Models\Contatos');
        
    }

    public function getByPaginacao($limit, $offiset)
    {
        $conn = Database::getConnection()->prepare(
            'SELECT * FROM 
                contatos
            ORDER BY contatos.nome ASC 
            LIMIT :offiset, :limit'
        );
        $conn->bindValue(':limit',   $limit, PDO::PARAM_INT);
        $conn->bindValue(':offiset', $offiset, PDO::PARAM_INT);
        $conn->execute();
        return $conn->fetchAll(
                    PDO::FETCH_CLASS,            
                    'App\MediaPost\Models\Contatos'
        );
        
    }

    public function getQuantidadeTotal()
    {
        $conn = Database::getConnection()->prepare(
            'SELECT COUNT(*) as total FROM contatos'
        );
        $conn->execute();
        return $conn->fetch(PDO::FETCH_OBJ)->total;
        
    }

    public function getByBusca($termo)
    {
        $conn = Database::getConnection()->prepare(
            'SELECT contatos.*
             FROM 
                contatos
            LEFT JOIN 
                emails
            ON 
                emails.contato_id = contatos.id
            LEFT JOIN 
                telefones
            ON telefones.contato_id = contatos.id
            WHERE
                contatos.nome  LIKE :termo
            OR
                telefones.descricao LIKE :termo
            OR
                emails.descricao LIKE :termo
            GROUP BY contatos.id
            ORDER BY contatos.nome ASC'
        );
        $conn->bindValue(':termo', '%'.$termo.'%', PDO::PARAM_STR);
        $conn->execute();
        $data['contatos'] = $conn->fetchAll(
                                PDO::FETCH_CLASS,            
                                'App\MediaPost\Models\Contatos'
        );
        $data['quantidade'] = $conn->rowCount();
        return $data;
    }


    public function getAll(){

        $conn = Database::getConnection()->prepare(
                    'SELECT * FROM contatos'
        );

        $conn->execute();
        return $conn->fetchAll(
                 PDO::FETCH_CLASS,
                 'App\MediaPost\Models\Contatos'
        );
    }

    public function add($data){
        $conn = Database::getConnection()->prepare(
            'INSERT INTO contatos (nome) VALUES (:nome)'
        );
        $conn->bindValue(':nome', $data->getNome(), PDO::PARAM_STR);
        $conn->execute();
        return Database::getConnection()->lastInsertId();
    }

    public function upd($data){
        $conn = Database::getConnection()->prepare(
            'UPDATE contatos SET nome = :nome WHERE id = :id'
        );
        $conn->bindValue(':nome', $data->getNome(), PDO::PARAM_STR);
        $conn->bindValue(':id',   $data->getId(),   PDO::PARAM_INT);
        $conn->execute();
        return $conn->rowCount();
    }

    public function del($id){
        $conn = Database::getConnection()->prepare(
            'DELETE FROM contatos WHERE id = :id'
        );
        $conn->bindValue(':id', $id, PDO::PARAM_INT);
        $conn->execute();
        return $conn->rowCount();
    }
}

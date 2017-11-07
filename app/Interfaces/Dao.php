<?php

namespace App\MediaPost\Interfaces;

interface Dao 
{
    public function get($id);
    public function del($id);
    public function add($data);
    public function upd($data);
    public function getAll();
}
<?php

namespace App\Interfaces;

interface TaskInterface
{
    public function getAll();
    public function getById($id);
    public function create($data);
    public function update($newData, $id);
}

<?php
namespace Eployee\app\Interfaces;

interface Manageable{
    public function create(array $data);
    public function getAll();
    public function update(int $id, array $data);
    public function remove(int $id);
}
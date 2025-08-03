<?php

namespace App\Core;
use Exeption;

class repository{
    protected $data = [];
    protected $nextId=1;




    public function __construct()
    {
        $this->data = [];
        $this->nextId = 1;
    }

    public function findAll():array
    {
        return $this->data;
    }

    public function findById(int $id): ?object{
        return $this->data[$id] ?? null;
    }

    public function save(object $item){
        if (!($item instanceof Identifible)){
            throw new Exeption("Item must implement Identifible interface");
        }
       $id = $item->getId();
       if ($id===0){
        $id = $this->nextId++;
        $reflector =  new \ReflectionClass($item);
        $property = $reflector->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($item, $id);

       }
         $this->data[$id] = $item;
    }

    public function delete(int $id): void {
        if (isset($this->data[$id])) {
            unset($this->data[$id]);
        }
    }

    public function clear(): void {
        $this->data = [];
        $this->nextId = 1;
    }

    public function count(): int {
        return count($this->data);
    }

    

}
<?php
namespace app\models;
use app\interfaces\Identifiable;


class Employees implements Identifiable{
    private $id;
    private $name;
    private $position;
    private $salary;


    public function __construct($id, $name, $position, $salary) {
        $this->id = 0;
        $this->name = $name;
        $this->position = $position;
        $this->salary = $salary;
    }

    public function getId():int {
        return $this->id;
    }
    public function getName():string {
        return $this->name;
    }
    public function getPosition():string {
        return $this->position;
    }
    public function getSalary():float {
        return $this->salary;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setPosition(string $position): void {
        $this->position = $position;
    }

    public function setSalary(float $salary): void {
        $this->salary = $salary;
    }

    public function __toString(): string {
        return "ID: {$this->id} | Name: {$this->name} | Position: {$this->position} | Salary: \${$this->salary}";
    }
}
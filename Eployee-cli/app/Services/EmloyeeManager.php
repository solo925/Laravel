<?php

namespace App\Services;

use App\Core\Repository;
use App\Interfaces\Manageable;
use App\Models\Employee;

class EmployeeManager extends Repository implements Manageable
{
    public function create(array $data): Employee
    {
        $employee = new Employee(
            $data['name'],
            $data['position'],
            $data['salary']
        );
        $this->save($employee);
        return $employee;
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function update(int $id, array $data): ?Employee
    {
        $employee = $this->findById($id);
        if (!$employee) {
            return null;
        }

        if (isset($data['name'])) $employee->setName($data['name']);
        if (isset($data['position'])) $employee->setPosition($data['position']);
        if (isset($data['salary'])) $employee->setSalary($data['salary']);

        $this->save($employee); // re-save
        return $employee;
    }

    public function remove(int $id): bool
    {
        return $this->delete($id);
    }
}


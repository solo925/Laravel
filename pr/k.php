Perfect! Since you want a **CLI-based management system in pure PHP using OOP** (classes, abstraction, inheritance, interfaces, etc.) — **without a database**, and using an **in-memory dictionary (array)** instead — here's a **complete, clean, and educational CLI project** that demonstrates **core PHP OOP mastery**.

---

## ✅ Project: **Employee Management System (CLI)**
- No database — uses **in-memory array (dictionary)**
- Fully **OOP**: Abstraction, Encapsulation, Inheritance, Interfaces
- PSR-4 autoloading via `composer.json`
- CLI interface with menu
- Exception handling
- Proper separation of concerns

---

### 📁 Project Structure

```
employee-cli/
│
├── app/
│   ├── Models/
│   │   └── Employee.php
│   │
│   ├── Services/
│   │   └── EmployeeManager.php
│   │
│   ├── Interfaces/
│   │   └── Manageable.php
│   │
│   └── Core/
│       ├── Repository.php
│       └── Identifiable.php
│
├── lib/
│   └── CLI.php
│
├── public/
│   └── index.php
│
├── .gitignore
└── composer.json
```

---

### ✅ Step 1: `composer.json`

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Lib\\": "lib/"
        }
    }
}
```

Run:  
```bash
composer install
```

---

### ✅ Step 2: Autoloading via `composer` (no need to write custom autoloader)

We’ll rely on Composer’s autoloader.

---

### ✅ Step 3: Core Interfaces & Traits

#### `app/Core/Identifiable.php`

```php
<?php
// app/Core/Identifiable.php
namespace App\Core;

interface Identifiable
{
    public function getId(): int;
}
```

#### `app/Core/Repository.php` (Generic In-Memory Storage)

```php
<?php
// app/Core/Repository.php
namespace App\Core;

use Exception;

class Repository
{
    protected $data = [];
    protected $nextId = 1;

    public function findAll(): array
    {
        return $this->data;
    }

    public function findById(int $id): ?object
    {
        return $this->data[$id] ?? null;
    }

    public function save(object $item): void
    {
        if (!($item instanceof Identifiable)) {
            throw new Exception("Item must implement Identifiable interface.");
        }

        $id = $item->getId();
        if ($id === 0) {
            $id = $this->nextId++;
            $reflector = new \ReflectionClass($item);
            $property = $reflector->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($item, $id);
        }
        $this->data[$id] = $item;
    }

    public function delete(int $id): bool
    {
        if (isset($this->data[$id])) {
            unset($this->data[$id]);
            return true;
        }
        return false;
    }

    public function clear(): void
    {
        $this->data = [];
        $this->nextId = 1;
    }

    public function count(): int
    {
        return count($this->data);
    }
}
```

---

### ✅ Step 4: Interface for Management

#### `app/Interfaces/Manageable.php`

```php
<?php
// app/Interfaces/Manageable.php
namespace App\Interfaces;

interface Manageable
{
    public function create(array $data);
    public function getAll();
    public function update(int $id, array $data);
    public function remove(int $id);
}
```

---

### ✅ Step 5: Employee Model

#### `app/Models/Employee.php`

```php
<?php
// app/Models/Employee.php
namespace App\Models;

use App\Core\Identifiable;

class Employee implements Identifiable
{
    private $id;
    private $name;
    private $position;
    private $salary;

    public function __construct($name = '', $position = '', $salary = 0)
    {
        $this->id = 0;
        $this->name = $name;
        $this->position = $position;
        $this->salary = $salary;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function setSalary(float $salary): void
    {
        $this->salary = $salary;
    }

    public function __toString(): string
    {
        return "ID: {$this->id} | Name: {$this->name} | Position: {$this->position} | Salary: \${$this->salary}";
    }
}
```

---

### ✅ Step 6: Employee Manager (Service Layer)

#### `app/Services/EmployeeManager.php`

```php
<?php
// app/Services/EmployeeManager.php
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
```

---

### ✅ Step 7: CLI Helper

#### `lib/CLI.php`

```php
<?php
// lib/CLI.php
namespace Lib;

class CLI
{
    public static function write($message)
    {
        echo $message . PHP_EOL;
    }

    public static function read($prompt = "> ")
    {
        self::write($prompt, false);
        return trim(fgets(STDIN));
    }

    public static function clear()
    {
        system('clear || cls');
    }

    public static function pause()
    {
        self::read("Press Enter to continue...");
    }
}
```

---

### ✅ Step 8: Main CLI App

#### `public/index.php`

```php
#!/usr/bin/env php
<?php

// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\EmployeeManager;
use Lib\CLI;

$manager = new EmployeeManager();

function displayMenu()
{
    CLI::write("\n--- Employee Management System ---");
    CLI::write("1. List All Employees");
    CLI::write("2. Add Employee");
    CLI::write("3. View Employee");
    CLI::write("4. Update Employee");
    CLI::write("5. Delete Employee");
    CLI::write("6. Exit");
}

function createEmployee(EmployeeManager $manager)
{
    CLI::write("\n--- Add New Employee ---");
    $name = CLI::read("Enter name:");
    $position = CLI::read("Enter position:");
    $salary = (float)CLI::read("Enter salary:");

    $emp = $manager->create([
        'name' => $name,
        'position' => $position,
        'salary' => $salary
    ]);

    CLI::write("✅ Employee #{$emp->getId()} added successfully!");
}

function viewAll(EmployeeManager $manager)
{
    $employees = $manager->getAll();
    if (empty($employees)) {
        CLI::write("📭 No employees found.");
        return;
    }

    CLI::write("\n📋 All Employees:");
    foreach ($employees as $emp) {
        CLI::write("  " . $emp);
    }
}

function viewOne(EmployeeManager $manager)
{
    $id = (int)CLI::read("Enter employee ID:");
    $emp = $manager->findById($id);

    if ($emp) {
        CLI::write("\n👉 " . $emp);
    } else {
        CLI::write("❌ Employee not found.");
    }
}

function updateEmployee(EmployeeManager $manager)
{
    $id = (int)CLI::read("Enter employee ID to update:");
    $emp = $manager->findById($id);

    if (!$emp) {
        CLI::write("❌ Employee not found.");
        return;
    }

    CLI::write("Current: " . $emp);
    CLI::write("Leave blank to keep current value.");

    $name = CLI::read("New name ({$emp->getName()}):");
    $position = CLI::read("New position ({$emp->getPosition()}):");
    $salary = CLI::read("New salary ({$emp->getSalary()}):");

    $data = [];
    if (!empty($name)) $data['name'] = $name;
    if (!empty($position)) $data['position'] = $position;
    if (!empty($salary) && is_numeric($salary)) $data['salary'] = (float)$salary;

    $manager->update($id, $data);
    CLI::write("✅ Employee updated.");
}

function deleteEmployee(EmployeeManager $manager)
{
    $id = (int)CLI::read("Enter employee ID to delete:");
    if ($manager->remove($id)) {
        CLI::write("🗑️  Employee deleted.");
    } else {
        CLI::write("❌ Employee not found.");
    }
}

// Main loop
while (true) {
    displayMenu();
    $choice = CLI::read("Choose an option (1-6):");

    match ($choice) {
        '1' => viewAll($manager),
        '2' => createEmployee($manager),
        '3' => viewOne($manager),
        '4' => updateEmployee($manager),
        '5' => deleteEmployee($manager),
        '6' => (CLI::write("👋 Goodbye!"), exit),
        default => CLI::write("❗ Invalid option. Try again.")
    };

    CLI::pause();
}
```

---

## ✅ How to Run

1. Save all files.
2. Open terminal in project root.
3. Run:

```bash
php public/index.php
```

---

## ✅ Sample Output

```
--- Employee Management System ---
1. List All Employees
2. Add Employee
3. View Employee
4. Update Employee
5. Delete Employee
6. Exit
Choose an option (1-6): 2
> Enter name: Alice Johnson
> Enter position: Developer
> Enter salary: 75000
✅ Employee #1 added successfully!
Press Enter to continue...
```

---

## ✅ OOP Concepts Demonstrated

| Concept           | Used In |
|------------------|--------|
| **Classes**       | `Employee`, `EmployeeManager` |
| **Abstraction**   | `Repository` base class |
| **Inheritance**   | `EmployeeManager` extends `Repository` |
| **Encapsulation** | Private properties with getters/setters |
| **Interfaces**    | `Manageable`, `Identifiable` |
| **Autoloading**   | PSR-4 via Composer |
| **Exception Handling** | Type checks in `Repository` |
| **Separation of Concerns** | Models, Services, CLI |

---

## ✅ Want to Extend?

- Add `Department` class
- Export to JSON
- Search/filter employees
- Sort by salary/name
- Persistence to JSON file

---

Let me know if you want:
- A downloadable ZIP
- Unit tests (PHPUnit)
- Command pattern for CLI
- Help generating random employees

This project is perfect for **learning advanced PHP OOP** without frameworks or databases. 🚀
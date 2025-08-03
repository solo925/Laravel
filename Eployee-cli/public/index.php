<?php
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
        '6' => function() { CLI::write("👋 Goodbye!"); exit(); },
        default => CLI::write("❗ Invalid option. Try again.")
    };

    CLI::pause();
}
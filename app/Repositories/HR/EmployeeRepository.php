<?php

namespace App\Repositories\HR;

use App\Models\HR\EmployeeModel;

class EmployeeRepository
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();  // EmployeeModel object
    }

    // Fetch all employees
    public function getAllEmployees()
    {
        
        return $this->employeeModel->getEmployees();
    }

    // Fetch a single employee by ID
    public function getEmployeeById($id)
    {
        return $this->employeeModel->getEmployeeById($id);
    }

    // Create a new employee
    public function createEmployee($data)
    {
        return $this->employeeModel->createEmployee($data);
    }

    // Update an existing employee
    public function updateEmployee($id, $data)
    {
        return $this->employeeModel->updateEmployee($id, $data);
    }

    // Delete an employee by ID
    public function deleteEmployee($id)
    {
        return $this->employeeModel->deleteEmployee($id);
    }
}

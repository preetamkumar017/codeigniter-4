<?php

namespace App\Services\HR;

use App\Repositories\HR\EmployeeRepository;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct()
    {
        $this->employeeRepository = new EmployeeRepository();  // EmployeeRepository object
    }

    // Get all employees
    public function getAllEmployees()
    {
        
        return $this->employeeRepository->getAllEmployees();
    }

    // Get employee by ID
    public function getEmployeeById($id)
    {
        return $this->employeeRepository->getEmployeeById($id);
    }

    // Add a new employee
    public function createEmployee($data)
    {
        return $this->employeeRepository->createEmployee($data);
    }

    // Update employee
    public function updateEmployee($id, $data)
    {
        return $this->employeeRepository->updateEmployee($id, $data);
    }

    // Delete employee
    public function deleteEmployee($id)
    {
        return $this->employeeRepository->deleteEmployee($id);
    }
}

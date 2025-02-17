<?php

namespace App\Controllers\hr;

use App\Services\hr\EmployeeService;
use CodeIgniter\Controller;
use App\Services\framework\StakeholderMenuMapService;
use App\Services\Globle\Config\MenuServices;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct()
    {
        
        $this->service = new StakeholderMenuMapService();
        $this->employeeService = new EmployeeService();
        $this->menuService = new MenuServices();
        
        
    }

    public function index()
    {
        
        
           
        
        // Fetch data using the service layer
        $employees = $this->employeeService->getAllEmployees();

        // Pass data to the view for rendering
        return view('hr/employee/index', ['employees' => $employees]);
       

        
    }

    public function show($id)
    {
        // Fetch a single employee using service layer
        $employee = $this->employeeService->getEmployeeById($id);

        // Pass employee data to the view for rendering
        return view('hr/employee/show', ['employee' => $employee]);
    }
    // Show form to create a new employee
    public function create()
    {
        echo "Hello from create method";
        // Render the form view
        return view('hr/employee/create');
    }
    public function edit($id)
    {
        echo "Hello from create method";
        $employee = $this->employeeService->getEmployeeById($id);
        // print_r($employee);

        // Pass employee data to the view for rendering
        // Render the form view
        return view('hr/employee/edit', ['employee' => $employee]);
    }
    // Add new employee (store)
    public function store()
    {
        $data = $this->request->getPost();  // Get form data
        $this->employeeService->createEmployee($data);  // Calling service to insert data
        return redirect()->to('public//hr/employees/');  // Redirect after insert
    }

    // Update employee
    public function update()
    {
        echo "Hello from update method";
        $data = $this->request->getPost();  // Get form data
        $this->employeeService->updateEmployee($data['id'], $data);  // Calling service to update data
        return redirect()->to('public/hr/employees');
    }

    // Delete employee
    public function delete($id)
    {
        echo "Hello from delete method";
        $this->employeeService->deleteEmployee($id);  // Calling service to delete data
        return redirect()->to('public/hr/employees/');
    }
}

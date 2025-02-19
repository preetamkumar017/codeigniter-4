<?php

namespace App\Controllers\hr;

use App\Services\hr\EmployeeService;
use CodeIgniter\Controller;
use App\Services\framework\StakeholderMenuMapService;
use App\Services\Globle\Config\MenuServices;

class PersonalIformationController extends Controller
{
    protected $employeeService;

    public function __construct()
    {
        
        $this->employeeService = new EmployeeService();
    }
    
    public function index()
    {
        // Fetch data using the service layer
        $employees = $this->employeeService->getAllEmployees();

        // Pass data to the view for rendering
        return view('hr/Profile/personal_information', ['employees' => $employees]);
       

        
    }
}
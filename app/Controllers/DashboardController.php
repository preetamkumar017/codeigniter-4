<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Services\Auth\UserService;
use App\Services\hr\EmployeeService;
use App\Services\framework\StakeholderMenuMapService;
use App\Services\Globle\Config\MenuServices;

class DashboardController extends Controller
{
    protected $userService;
    protected $service;
    protected $employeeService;
    protected $menuService;

    public function __construct()
    {
        // Load UserService to handle business logic
        $this->userService = new UserService();
        $this->service = new StakeholderMenuMapService();
        // Initialize service layer to handle business logic
        $this->employeeService = new EmployeeService();
        $this->menuService = new MenuServices();
    }
    public function index()
    {
        

        $session = session();
        $message = $session->getFlashdata('allData');
        $menuHierarchy = [];
        
        function getReversedMenuHierarchy($menuService, $menu) {
            if (!isset($menu['parent_m_id']) || empty($menu['parent_m_id'])) {
                return $menu; 
            }        
            $parentMenu = $menuService->getMenuById($menu['parent_m_id']);        
            return getReversedMenuHierarchy($menuService, $parentMenu); 
        }
        
        if (!empty($message->menu)) {
            foreach ($message->menu as $menu) {
                $menuHierarchy[] = getReversedMenuHierarchy($this->menuService, $menu);
            }
        }
                
        return view('Home/dashboard', ['menuData' => $menuHierarchy]);
    }
}

<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Services\Auth\UserService;
use App\Services\hr\EmployeeService;
use App\Services\framework\StakeholderMenuMapService;
use App\Services\Globle\Config\MenuServices;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\API\ResponseTrait;
// use Config\Services;

use Predis\Client;


class LoginController extends BaseController
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

    // Show login form
    public function index()
    {
        return view('auth/login');
    }

    // Handle login request
    use ResponseTrait;

    public function login() {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
    
        if (empty($email) || empty($password)) {
            return redirect()->to('public/auth/login')->with('error', 'Email and password are required');
        }
    
        $user = $this->userService->validateUser($email, $password);
        if (!$user) {
            return redirect()->to('public/auth/login')->with('error', 'Invalid email or password');
        }
    
        $userId = $user->id;
        $result = $this->service->getStakeholderMenuMapById(1, "E", $userId);
    
        $ids = array_map(function($row) {
            return $row['menu_id'];
        }, $result);
    
        $menusByIds = $this->menuService->getMenusByIds($ids);
    
        $links = [];
        foreach($menusByIds as $menu) {
            $links[] = $menu['link'];
            if (!empty($menu['sublinks'])) {
                $links = array_merge($links, explode(',', $menu['sublinks']));
            }
        }
    
     
// Create a new Redis client
        $redis = new Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);

        // Save a simple test value
        // $simpleKey = 'simple_test_key';
        // $simpleValue = 'Hello, Redis!';
        // $isSaved = $redis->setex($simpleKey, 600, $simpleValue); // Cache for 10 minutes
        
        $cacheKey = "user_{$userId}_links";
        $isSaved =  $redis->setex($cacheKey, 6000, json_encode($links)); // Cache for 10 minutes


        if ($isSaved) {
            log_message('debug', 'Simple value successfully saved to Redis with key: ' . $cacheKey);
        } else {
            log_message('error', 'Failed to save simple value to Redis with key: ' . $cacheKey);
        }

        // Retrieve the simple test value
        $retrievedValue = $redis->get($cacheKey);
        if ($retrievedValue) {
            log_message('debug', 'Retrieved simple cached value: ' . $retrievedValue);
        } else {
            log_message('error', 'Failed to retrieve simple cached value for key: ' . $cacheKey);
        }

        $key = getenv('encryption.key');
        if (!$key) {
            log_message('error', 'JWT encryption key not set.');
            return redirect()->to('public/auth/login')->with('error', 'Internal server error.');
        }
        $payload = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'logged_in' => true,
                'links' => $links,
                'exp' => time() + (60 * 60 * 24)
        ];
        
        $token = JWT::encode($payload, $key, 'HS256');
        
        $isMobile = strpos($this->request->getHeaderLine('User-Agent'), 'Mobile') !== false;

        if ($isMobile) {
            return $this->respond(['token' => $token], 200);
        } else {
            session()->set([
                'user_id' => $userId,
                // 'roles' => $roles,
                'logged_in' => true
            ]);
            return redirect()->to('public/dashboard');
        }
    }

    private function getUserLinks($roles)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('role_links');
        $builder->select('link')->whereIn('role_id', $roles);
        $result = $builder->get()->getResultArray();

        $links = array_column($result, 'link');
        return $links;
    }


    // Logout the user
    public function logout()
    {
        // Destroy the session
        session()->destroy();
        return redirect()->to('/public/auth/login');
    }
}

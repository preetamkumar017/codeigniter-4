<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Services\Auth\UserService;

class LoginController extends BaseController
{
    protected $userService;

    public function __construct()
    {
        // Load UserService to handle business logic
        $this->userService = new UserService();
    }

    // Show login form
    public function index()
    {
        return view('auth/login');
    }

    // Handle login request
    public function login()
    {
        // Get form data
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validate inputs
        if (empty($email) || empty($password)) {
            return redirect()->to('public/auth/login')->with('error', 'Email and password are required');
        }

        // Validate user credentials using the service layer
        $user = $this->userService->validateUser($email, $password);

        if ($user) {
            // Set session data for logged-in user
            session()->set([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'logged_in' => true
            ]);
            
        echo '<pre>';
        print_r(session()->get());
            // Redirect to dashboard
            return redirect()->to('public/dashboard');
        } else {
            // If invalid credentials, show error message
            return redirect()->to('public/auth/login')->with('error', 'Invalid email or password');
        }
    }

    // Logout the user
    public function logout()
    {
        // Destroy the session
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        
        echo '<pre>';
        print_r(session()->get());
        // Check if the user is logged in
        // if (!session()->get('logged_in')) {
        //     return redirect()->to('/auth/login');
        // }

        // Load dashboard view
        // return view('dashboard');
    }
}

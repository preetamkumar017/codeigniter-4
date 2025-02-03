<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        echo '<pre>';
        print_r(session()->get());
        // Check if the user is not logged in
        // if (!session()->get('logged_in')) {
        //     return redirect()->to('public/auth/login');
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // This method can be used to modify the response
    }
}

<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Filters\FilterHelpers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class DatabaseSwitchFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    }

    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Your code here...
    }


}
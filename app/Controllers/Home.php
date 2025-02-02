<?php

namespace App\Controllers;

class Home extends BaseController
{
    
    private $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        if ($this->db->connect()) {
            echo 'Database is connected';
        } else {
            echo 'Database is not connected';
        }
        return view('welcome_message');
    }
}

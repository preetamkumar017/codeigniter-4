<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;

class Home extends BaseController
{
    private $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = Services::session()->get('db_connection');
    }

    public function index(): string
    {
        if ($this->db) {
            // Print connection details
            // echo 'Database is connected<br>';
            // print_r($this->db);
            $builder = $this->db->table('user');
            $results = $builder->get()->getResult();

            foreach ($results as $row) {
                echo 'ID: ' . $row->id . '<br>';
                echo 'Name: ' . $row->name . '<br>';
                // echo 'Email: ' . $row->email . '<br>';
                echo '<hr>';
            }
        } else {
            echo 'Database is not connected';
        }
        
        return view('login');
    }
}
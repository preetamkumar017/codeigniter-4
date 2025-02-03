<?php
// app/Controllers/ExampleController.php

namespace App\Controllers;
use App\Libraries\DatabaseSwitcher;
use App\Controllers\BaseController;
use Config\Database;

class ExampleController extends BaseController
{


    public function index()
    {
       // Load the database configuration
       $dbConfig = new Database();

       // Attempt to connect to database2
       try {
           // Create a connection using the database2 configuration
           $db2 = \Config\Database::connect('database2');

           // Perform a simple query to check the connection
           $query = $db2->query('SELECT * from users; '); // This is a simple query to check if the connection works
            print_r($query->getResult());
           // If the query executes successfully, the connection is good
           if ($query) {
               return "Database2 is connected successfully!";
           }
       } catch (\Exception $e) {
           // Handle any connection errors
           return "Database2 connection failed: " . $e->getMessage();
       }

       return "Database2 connection failed for an unknown reason.";
    }
}
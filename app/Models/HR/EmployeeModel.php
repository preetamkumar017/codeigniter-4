<?php

namespace App\Models\HR;

use CodeIgniter\Model;
use Config\Database;

class EmployeeModel extends Model
{
    protected $table = 'employees';  // Table name
    protected $primaryKey = 'id';    // Primary key
    protected $allowedFields = ['name', 'email', 'phone', 'address'];  // Allowed fields

    // Constructor
    public function __construct()
    {


        // Connect to the database dynamically using the specified connection
        $this->db = \Config\Database::connect('database2');  // Dynamically set the DB connection

        // print_r($this->db);
    }

    

    // Insert employee
    public function createEmployee($data)
    {
        // Get the last inserted ID
        // $lastId = $this->;
        $lastId = $this->db->table($this->table)->selectMax('id')->get()->getRow()->id;
        echo '<pre>';
        print_r($lastId);
        // Increment the ID by 1
        $data['id'] = $lastId + 1;
        return $this->insert($data);
    }

    // Get all employees
    public function getEmployees()
    {
       
        $builder = $this->db->table($this->table);
        $query = $builder->get();
        return $query->getResult();  // Get result as objects
    }

    // Get employee by ID
    public function getEmployeeById($id)
    {
       
        return $this->db->table($this->table)->where('id', $id)->get()->getRow();
    }

    // Update employee
    public function updateEmployee($id, $data)
    {
        return $this->update($id, $data);
    }

    // Delete employee
    public function deleteEmployee($id)
    {
        return $this->delete($id);
    }
}




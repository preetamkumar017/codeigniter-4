<?php

namespace App\Models\Auth;

use CodeIgniter\Model;
use Config\Database;

class UserModel extends Model
{
    protected $table = 'users';  // Users table
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Optional: Use hashing before saving the password
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

        // Constructor
        public function __construct()
        {
            // Initialize database connection dynamically
            $session = \Config\Services::session();
    
            // Get dynamic database configuration from session or config
            if ($session->has('db_connection')) {
                $dbConnection = $session->get('db_connection');
            } else {
                // Default database connection
                $dbConnection = 'default';
            }
    
            // Connect to the database dynamically using the specified connection
            $this->db = \Config\Database::connect('database2');  // Dynamically set the DB connection
        }
    
    
        
    // Password hashing before insert or update
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // Method to get user by email
    public function getUserByEmail($email)
    {
        // echo "Fetching user by email from the database: ".$email;
        // print_r($this->db->table($this->table)->where('email', $email)->get()->getRow());
        return $this->db->table($this->table)->where('email', $email)->get()->getRow();
        // return $this->where('email', $email)->first();
    }
}

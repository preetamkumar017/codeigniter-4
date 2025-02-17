<?php

namespace App\Session;

use CodeIgniter\Session\Handlers\DatabaseHandler;

class CustomDatabaseHandler extends DatabaseHandler
{
    public function write($session_id, $session_data): bool
    {
        $time = time(); // Use UNIX timestamp (BIGINT)
        $data = [
            'id'         => $session_id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'timestamp'  => $time, // Fix for PostgreSQL
            'data'       => $session_data,
        ];

        return $this->db->table($this->table)->replace($data);
    }
}

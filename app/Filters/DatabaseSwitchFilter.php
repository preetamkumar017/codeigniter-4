<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Database\Config as DatabaseConfig;
use CodeIgniter\Exceptions\PageNotFoundException;

class DatabaseSwitchFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $host = $request->getServer('HTTP_HOST');
        $subdomain = explode('.', $host)[0];

        $companyDatabaseConfig = $this->getCompanyDatabaseConfig($subdomain);

        if ($companyDatabaseConfig) {
            try {
                $db = \Config\Database::connect([
                    'DSN'           => '',
                    'hostname'      => $companyDatabaseConfig['hostname'],
                    'username'      => $companyDatabaseConfig['username'],
                    'password'      => $companyDatabaseConfig['password'],
                    'database'      => $companyDatabaseConfig['database'],
                    'DBDriver'      => 'Postgre',
                    'DBPrefix'   => '',
                    'pConnect'   => false,
                    'DBDebug'    => true,
                    'charset'    => 'utf8',
                    'swapPre'    => '',
                    'failover'   => [],
                    'port'       => 5432,
                    'dateFormat' => [
                        'date'     => 'Y-m-d',
                        'datetime' => 'Y-m-d H:i:s',
                        'time'     => 'H:i:s',
                    ],
                ]);


                // Store the database connection in the session
                \CodeIgniter\Config\Services::session()->set('db_connection', $db);

            } catch (\Exception $e) {
                // Handle connection error
                throw new PageNotFoundException("Database connection failed: " . $e->getMessage());
            }
        } else {
            throw new PageNotFoundException("Company not found for subdomain: " . $subdomain);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Clean up or log after the request
    }

    private function getCompanyDatabaseConfig($subdomain)
    {
        // Load from a config file or environment variables in a real application
        $companyConfig = [
            'company1' => [
                'hostname' => 'localhost',
                'username' => 'postgres',
                'password' => '123',
                'database' => 'company1_db',
            ],
            'company2' => [
                'hostname' => 'localhost',
                'username' => 'company2_user',
                'password' => 'password2',
                'database' => 'company2_db',
            ]
        ];

        return $companyConfig[$subdomain] ?? null;
    }
}
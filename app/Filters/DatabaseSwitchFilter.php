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

        // Check if the database connection is already set in the session
        $dbConnection = \CodeIgniter\Config\Services::session()->get('db_connection');
        
        if ($dbConnection) {
            // If already set, no need to reconnect. Just return.
            return;
        }
    
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
                session()->regenerate(false);
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
        
        // Connect to the default database to fetch company database details
        $db = \Config\Database::connect();
        
        // Query to get the database configuration for the given subdomain
        $builder = $db->table('company_database_config');
        $companyConfig = $builder->where('company_name', $subdomain)->get()->getRowArray();

        // Check if the configuration was found and return the details
        if ($companyConfig) {
            return [
                'hostname' => $companyConfig['hostname'],
                'username' => $companyConfig['username'],
                'password' => $companyConfig['password'],
                'database' => $companyConfig['database_name'],
            ];
        }

    // Return null if no matching company was found
    return null;
    }
}
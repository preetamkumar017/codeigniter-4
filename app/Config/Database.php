<?php
namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';

    public array $default = [];

    public array $database2 = [];

    public function __construct()
    {
        parent::__construct();

        $this->default = [
            'DSN'        => '',
            'hostname'   => '172.16.225.1',
            'username'   => 'postgres',
            'password'   => '123',
            'database'   => 'sinha',
            'schema'     => 'public',
            'DBDriver'   => 'Postgre',
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
            ]];

        $subdomain = $this->getSubdomain();
        $dbDetails = $this->getDatabaseDetailsFromMaster($subdomain);
        
        // Debugging - log to file
        // log_message('debug', 'Fetched Database Details: ' . print_r($dbDetails, true));

        if ($dbDetails) {
            $this->database2 = [
                'DSN'        => '',
                'hostname'   => $dbDetails['hostname'],
                'username'   => $dbDetails['username'],
                'password'   => $dbDetails['password'],
                'database'   => $dbDetails['database'],
                'schema'     => 'public',
                'DBDriver'   => 'Postgre',
                'DBPrefix'   => '',
                'pConnect'   => false,
                'DBDebug'    => true,
                'charset'    => 'utf8',
                'swapPre'    => '',
                'failover'   => [],
                'port'       => 5432,
            ];
        }

        // log_message('debug', 'Database2 Config: ' . print_r($this->database2, true));
    }

    private function getSubdomain(): string
    {
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $parts = explode('.', $host);
        return count($parts) > 2 ? $parts[0] : 'default';
    }

    private function getDatabaseDetailsFromMaster(string $subdomain): ?array
    {
        // log_message('debug', 'Fetched Company Config: ' . print_r($subdomain, true));
        $db = \Config\Database::connect($this->default);
        $builder = $db->table('company_database_config');

        $companyConfig = $builder->where('company_name', $subdomain)->get()->getRowArray();

        // Log the fetched company config
        // log_message('debug', 'Fetched Company Config: ' . print_r($companyConfig, true));

        if ($companyConfig) {
            return [
                'hostname' => $companyConfig['hostname'],
                'username' => $companyConfig['username'],
                'password' => $companyConfig['password'],
                'database' => $companyConfig['database_name'],
            ];
        }

        return null;
    }

    public $session = [
        'driver' => 'CodeIgniter\Session\Handlers\DatabaseHandler',
        'config' => [
            'table_name' => 'ci_sessions',
            'table_column_session_id' => 'id',
            'table_column_last_activity' => 'timestamp',
            'table_column_user_data' => 'data',
        ],
    ];
}
<?php
// app/Libraries/DatabaseSwitcher.php

use CodeIgniter\Database\ConnectionInterface;

class DatabaseSwitcher
{
    private $defaultConnection;
    private $database2Connection;

    public function __construct(ConnectionInterface $defaultConnection, ConnectionInterface $database2Connection)
    {
        $this->defaultConnection = $defaultConnection;
        $this->database2Connection = $database2Connection;
    }

    public function switchToDatabase2()
    {
        $this->database2Connection->connect();
    }

    public function switchToDefault()
    {
        $this->defaultConnection->connect();
    }
}
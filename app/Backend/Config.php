<?php

namespace App\Backend;

use function App\Safely\getSettings;

class Config
{
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPass;
    private $version;

    public function __construct()
    {
        $settings = getSettings();

        $this->dbHost = $settings['db_host'];
        $this->dbName = $settings['db_name'];
        $this->dbUser = $settings['db_user'];
        $this->dbPass = $settings['db_pass'];

        $this->version = $settings['version'];
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function geDbHost()
    {
        return $this->dbHost;
    }

    public function geDbName()
    {
        return $this->dbName;
    }

    public function geDbUser()
    {
        return $this->dbUser;
    }

    public function geDbPass()
    {
        return $this->dbPass;
    }
}
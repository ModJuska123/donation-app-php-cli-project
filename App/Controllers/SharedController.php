<?php

namespace App\Controllers;

use App\Main\Database;

class SharedController
{
    protected $database;
    public function __construct()
    {
        $this->database = new Database();
    }
}
<?php

namespace App\Controllers;

use Libraries\Database\QueryBuilder;

class Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = new QueryBuilder;
        $this->db->getConnection();
    }
}
<?php

namespace App\Controllers;

use App\Models\User;
use Libraries\Request\Request;
use App\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user = new User; // User Model
    }

    /**
     * Index
     * 
     * @return array
     */
    public function index()
    {
        return $this->user->getAll();
    }

    /**
     * Get data by primary key
     * 
     * @return array
     */
    public function show($id)
    {
        return $this->user->findOrFail($id);
    }

    /**
     * Insert data into table
     * 
     * @return void
     */
    public function store(Request $request)
    {   
        $data = [
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'name' => $request->name
        ];

        return $this->user->insert($data);
    }
}
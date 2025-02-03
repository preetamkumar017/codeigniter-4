<?php

namespace App\Repositories\Auth;

use App\Models\Auth\UserModel;

class UserRepository
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Fetch user by email from the database
    public function getUserByEmail($email)
    {
        // echo "Fetching user by email from the database";
        return $this->userModel->getUserByEmail($email); // Calls the method from UserModel
    }
}

<?php

namespace App\Services\Auth;

use App\Repositories\Auth\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }


    public function validateUser($email, $password)
    {

        $user = $this->userRepository->getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            return $user; 
        }

        return null; 
    }
}

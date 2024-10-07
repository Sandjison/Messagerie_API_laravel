<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface
{
    /**
     * Create a new class instance.
     */
    public function login(array $data)
    {
        return Auth::attempt($data);
    }

    public function register(array $data)
    {
        return User::create($data);
    }
}

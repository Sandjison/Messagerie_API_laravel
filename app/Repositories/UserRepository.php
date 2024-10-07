<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;

class UserRepository implements UserInterface
{
    /**
     * Create a new class instance.
     */

    public function findUserById($id)
    {
        return User::find($id);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        // $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function showUser()
    {
        return User::all();
    }
}

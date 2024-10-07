<?php

namespace App\Interfaces;

interface UserInterface
{
    public function findUserById($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);

    public function showUser();
}

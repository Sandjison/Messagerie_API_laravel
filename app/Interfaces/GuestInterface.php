<?php

namespace App\Interfaces;

interface GuestInterface
{
    public function addGuest(array $data);
    public function deleteGuest($id);
}

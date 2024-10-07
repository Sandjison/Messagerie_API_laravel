<?php

namespace App\Repositories;
use App\Interfaces\GuestInterface;
use App\Models\Guest;

class GuestRepository implements GuestInterface
{
    /**
     * Create a new class instance.
     */
    public function addGuest(array $data)
    {
        return Guest::create($data);
    }

    public function deleteGuest($id)
    {
        $guest = Guest::findOrFail($id);
      
        return  $guest;
    }
}

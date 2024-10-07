<?php

namespace App\Repositories;
use App\Interfaces\GroupInterface;
use App\Models\File;
use App\Models\Group;


class GroupRepository implements GroupInterface
{
    /**
     * Create a new class instance.
     */
    public function createGroup(array $data)
    {
        return Group::create($data);
    }

    public function deleteGroup($id)
    {
        $group = Group::findOrFail($id);

        return $group;
    }
    public function showGroup()
    {
        return Group::all(); // Récupère tous les groupes de la base de données
    }

    public function sendFile($id)
    {
        return File::where('group_id', $id)->get();
    }
}

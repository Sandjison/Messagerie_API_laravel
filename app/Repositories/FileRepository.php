<?php

namespace App\Repositories;

use App\Models\File;
use App\Interfaces\FileInterface;
use App\Models\User;

class FileRepository implements FileInterface
{
    /**
     * Create a new class instance.
     */
    public function addFile(array $data)
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        
        $data['member_id'] = $user->id;

        return File::create($data);
    }

    public function deleteFile($id)
    {
        $file = File::findOrFail($id);
        return $file;
    }

    public function showFile($id)
    {
        return File::where('group_id', $id)->get();
    }
}

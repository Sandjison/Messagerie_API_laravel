<?php

namespace App\Interfaces;

interface FileInterface
{
    public function addFile(array $data);
    public function deleteFile($id);
    public function showFile($group_id);
}

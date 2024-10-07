<?php

namespace App\Interfaces;

interface GroupInterface
{
    public function createGroup(array $data);
    public function deleteGroup($id);
    public function sendFile($id);
    public function showGroup();
}

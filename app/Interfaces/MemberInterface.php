<?php

namespace App\Interfaces;

interface MemberInterface
{
    public function addMember(array $data);
    public function deleteMember(int $id);

}

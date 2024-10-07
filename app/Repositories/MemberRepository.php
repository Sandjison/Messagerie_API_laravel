<?php

namespace App\Repositories;

use App\Interfaces\MemberInterface;
use App\Models\Member;

class MemberRepository implements MemberInterface
{
    /**
     * Create a new class instance.
     */
    public function addMember(array $data)
    {
        return Member::create($data);
    }

    public function deleteMember($id)
    {
        $member = Member::findOrFail($id);
        return $member;
    }
}

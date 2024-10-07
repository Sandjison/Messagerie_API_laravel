<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
    ];

    public function Group()
    {
        return $this->hasMany(Group::class);
    }

    // Relation avec le modèle User
    public function user()
    {
        return $this->hasMany(User::class);
    }

   
}

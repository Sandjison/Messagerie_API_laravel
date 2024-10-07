<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id', // Ajout de user_id
    ];

      /**
     * Définir la relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->hasMany(File::class);
    }

    public function guest()
    {
        return $this->hasMany(Guest::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}

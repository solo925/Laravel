<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_user_id',
        'username',
        'display_name',
        'bio',
        'avatar_url',
    ];
}

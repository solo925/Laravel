<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $fillable = [
        'name',
        'owner_id',

    ];
    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function users(){
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }
}

<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function tasks(){
        return $this->hasMany(Task::class);
    }
}

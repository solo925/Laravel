<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = ['body', 'user_id','post_id'];

    function user(){
        return $this->belongsTo(User::class);
    }
    function post(){
        return $this->belongsTo(Post::class);
    }
}

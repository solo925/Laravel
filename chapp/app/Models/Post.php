<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comments;

class Post extends Model
{
  protected $fillable = ['title', 'description', 'user_id','image_url'];

  public function user(){
    return $this->belongsTo(User::class);
  }
  public function comments(){
    return $this->hasMany(Comments::class);
  }

}

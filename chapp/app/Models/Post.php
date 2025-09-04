<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comments;
use App\Models\Likes;

class Post extends Model
{
  protected $fillable = ['title', 'description', 'user_id','image_url'];

  public function user(){
    return $this->belongsTo(User::class);
  }
  public function comments(){
    return $this->hasMany(Comments::class);
  }

  public function likes(){
    return $this->hasMany(Likes::class);
  }

  /**
   * Check if a user has liked this post
   */
  public function isLikedBy($userId)
  {
    return $this->likes()->where('user_id', $userId)->exists();
  }

  /**
   * Get the like count for this post
   */
  public function getLikeCountAttribute()
  {
    return $this->likes()->count();
  }

  /**
   * Toggle like for a user
   */
  public function toggleLike($userId)
  {
    $existingLike = $this->likes()->where('user_id', $userId)->first();
    
    if ($existingLike) {
      $existingLike->delete();
      return false; // Unlike
    } else {
      $this->likes()->create(['user_id' => $userId]);
      return true; // Like
    }
  }
}

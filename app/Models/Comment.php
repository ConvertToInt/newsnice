<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    public function likes()
    {
        return $this->morphToMany('App\Models\User', 'likeable', 'likes')->whereDeletedAt(null);
    }

    /**
     * Check whether user has liked an object
     */
    public function isLiked($type) 
    {
        return $this->likes()
            ->where('likeable_id', $this->id)
            ->where('likeable_type', $this->getMorphClass()) //gets the type from the morph map defined in appserviceprovider
            ->exists();
    } 
}

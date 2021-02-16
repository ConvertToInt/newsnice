<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment');
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

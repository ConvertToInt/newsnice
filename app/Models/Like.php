<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\Likeable;

class Like extends Model
{
    use HasFactory;
    use Likeable;
    use SoftDeletes;

    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    /**
     * Get all of the articles that are assigned this like.
     */
    public function articles()
    {
        return $this->morphedByMany('App\Models\Article', 'likeable');
    }

    /**
     * Get all of the comments that are assigned this like.
     */
    public function comments()
    {
        return $this->morphedByMany('App\Models\Comment', 'likeable');
    }

}

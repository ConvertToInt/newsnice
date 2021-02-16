<?php

namespace App\Http\Traits;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Article;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

trait Likeable {

    use SoftDeletes;

    /**
     * Like an object
     */
    public static function like($request,$existing_like) 
    {
        Like::create([
            'user_id'       => Auth::id(),
            'likeable_id'   => $request->id,
            'likeable_type' => $request->type,
        ]);
    }

    /**
     * Unlike an object
     */
    public static function unlike($request,$existing_like) 
    { 
        if (is_null($existing_like->deleted_at)) {
            $existing_like->delete();
        } else {
            $existing_like->restore();
        }
    }

    /**
     * Toggle a like of a comment or article
     */
    public static function toggleLike($request) {

        $existing_like = Like::withTrashed()->whereLikeableType($request->type)->whereLikeableId($request->id)->whereUserId(Auth::id())->first();

        if (is_null($existing_like)) {
            return self::like($request,$existing_like);
        } else {
            return self::unlike($request,$existing_like);
        }
    }

    /**
     * Relationship between like and user
     */
    public function likes()
    {
        return $this->morphToMany('App\Models\User', 'likes');
    }

}
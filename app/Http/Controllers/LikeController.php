<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Like;
use App\Models\Comment;

class LikeController extends Controller
{
    public function toggleLike(Request $request, ? Article $article, ? Comment $comment)
    { 
        Like::toggleLike($request);
    }

    public function checkLikes(Request $request, ? Article $article, ? Comment $comment)
    {
        $type = $request->type;

        if ($type == "Article"){
            return $article->likes()->count();
            
        } elseif ($type == "Comment"){
            return $comment->likes()->count();
        }
    }

    public function checkLiked(Request $request, ? Article $article, ? Comment $comment)
    {
        $type = $request->type;

        if ($type == "Article"){
            return $article->isLiked($type);
        } elseif ($type == "Comment"){
            return $comment->isLiked($type);
            
        }
    }
}

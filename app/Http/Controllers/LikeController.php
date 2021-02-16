<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Like;
use App\Models\Comment;

class LikeController extends Controller
{
    public function toggleLike(Request $request)
    { 
        Like::toggleLike($request);
    }
}

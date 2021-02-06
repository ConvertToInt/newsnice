<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article) {

        $request->validate([
            'body' => 'required|max:10000'
        ]);

        $comment =  new Comment;
        $comment->user_id = Auth::id();
        $comment->article_id = $article->id;
        $comment->body = $request->body;

        $comment->save();

        return back();
    }

    public function reply(Request $request, Article $article) {

        $request->validate([
            'body' => 'required|max:10000'
        ]);

        $comment =  new Comment;
        $comment->user_id = Auth::id();
        $comment->article_id = $article->id;
        $comment->parent_id = $request->parent_id;
        $comment->body = $request->body;

        $comment->save();

        return back();
    }

    public function delete(Article $article, Comment $comment) {
        
        $comment->delete();
        
        $comments = Comment::where('post_id', $article->id)->whereNull('parent_id')->get();

        return back();
    }
}

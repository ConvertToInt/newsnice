<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggleFollow(Category $category){

        auth()
            ->user()
            ->toggleFollow($category);

        return back();

    }
}

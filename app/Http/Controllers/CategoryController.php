<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($category){
        $category;
        $categories = Article::where('category_id', $category->id);
    }
}

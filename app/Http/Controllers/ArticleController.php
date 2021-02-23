<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;

class ArticleController extends Controller
{
    public function index(Request $request) {
        $this->curl_api();

        if (! $request->cookie('categories')){
            $categories = json_encode(array(''));
            Cookie::queue('categories', $categories);
            // $response = new Response();
            // $categories = json_encode(array(''));
            // $response->withCookie(cookie('categories', $categories));
        }
        
        $categories = Category::get();
        $articles = Article::latest()->get();

        return view('article.index', [
            'articles'=>$articles,
            'categories'=>$categories]);
    }
    
    public function show(Article $article){
        $comments = Comment::where('article_id', $article->id)->whereNull('parent_id')->get();
        
        return view('article.show', [
            'article'=>$article,
            'comments'=>$comments]);
    }

    public function category(Request $request, Category $category){

        $following = json_decode($request->cookie('categories'));

        $categories = Category::get();
        $articles = Article::where('category_id', $category->id)->latest()->get();
        $category = $category->name;
        return view('article.index', [
            'articles'=>$articles,
            'categories'=>$categories,
            'currentCategory'=>$category,
            'following'=>$following]); // $currentCategory as $category clashes with the loop in index.blade.php displaying all categories
    }

    public function following_feed(Request $request){ // users personalised feed containing their followed categories
        $categories = Category::get();

        if (auth()->check()){
            $articles = auth()->user()->feed();
            return view('article.index', [
                'articles'=> $articles,
                'categories'=>$categories]);
        } else {
            $following = json_decode($request->cookie('categories'));
            $articles = array();
            foreach ($following as $category){
                $categoryId = Category::where('name',$category)->pluck('id')->toArray();
                $articles = array_merge($categoryId, $articles);
            }
            $articles = Article::whereIn('category_id', $articles)->latest()->get();
            return view('article.index', [
                'articles'=>$articles,
                'categories'=>$categories]);
            }
        
    }

    public function search(Request $request){
        // Get the search value from the request
        $search = $request->input('articles');
    
        // Search in the title and body columns from the posts table
        $articles = Article::query()
            ->where('title', 'LIKE', "%{$search}%")
            // ->orWhere('body', 'LIKE', "%{$search}%")
            ->get();
    
        // Return the search view with the resluts compacted
        return view('article.search', ['articles'=>$articles]);
    }

    public function curl_api(){
        // vars to get access token
        $url ='https://ssl.reddit.com/api/v1/access_token';
        $clientId = 'iqAiNXm8mhC0Ug';
        $clientSecret = 'Z4BRsGQUfPhr7NtTia-lStGzsKF_dA';

        // post variables
        $fields = array (
            'grant_type' => 'client_credentials'
        );

        $userAgent = 'blah:newsnice v0.1 by tdalgleish7';

        // prepare data for post
        $field_string = http_build_query($fields);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret) ));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl,CURLOPT_POST, 1);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $field_string);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $response = json_decode($response, true);
        //var_dump($response); // access_token should be here

        // now get the data
        $curl = curl_init('https://oauth.reddit.com/r/positive_news/new.json?limit=5');
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Authorization: bearer ' . $response['access_token'] ) );
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_USERAGENT, $userAgent);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $data =  json_decode($response); // decodes response 

        $results = ($data->data->children); // creates a variable of the response -> data -> children to then be processed in the blade

        $this->insertToDb($results); // inserts relevant info in to db

    }

    public function insertToDb($results){

        foreach ($results as $result){

            if($result->data->link_flair_text && $result->data->thumbnail != "default") // will only enter new articles if they have a thumbnail, and if they have a flair
            { 
                $category_exists = Category::select("*")->where("name", $result->data->link_flair_text)->exists(); // to check if the article already exists in database

                if (!$category_exists){ // will only run if the the variable $article returns false
                    $category = new Category;
                    $category->name = ucfirst(strtolower($result->data->link_flair_text)); // AND SLUGIFY?
                    $category->save();
                }

                $article_exists = Article::select("*")->where("id", $result->data->id)->exists(); // to check if the article already exists in database

                if (!$article_exists){ // will only run if the the variable $article returns false
                    $article = new Article;
                    $article->id = $result->data->id;
                    $article->title = $result->data->title;
                    $words = Str::words($result->data->title, 8); //max words 8
                    $article->slug = Str::slug($words, '_'); //slugifies 8 words
                    $article->thumbnail = $result->data->thumbnail;
                    $article->created_at = $result->data->created;
                    $article->category_id = Category::where('name', $result->data->link_flair_text)->value('id');
                    $article->url = $result->data->url_overridden_by_dest;
                    $article->save();
                }
            } 
        }         
    }
}

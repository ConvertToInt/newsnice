<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index() {

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

        $articles = Article::all();

        return view('article.index', ['articles'=>$articles]); //passes JSON array of posts to main page

        //dd($articles);

        }

        public function insertToDb($results){

            foreach ($results as $result){
                
                $exists = Article::select("*")->where("id", $result->data->id)->exists(); // to check if the article already exists in database

                if (!$exists){ // will only run if the the variable $article returns false
                    $article = new Article;
                    $article->id = $result->data->id;
                    $article->title = $result->data->title;
                    $article->thumbnail = $result->data->thumbnail;
                    $article->created_at = $result->data->created;
                    $article->flair = $result->data->link_flair_text;
                    $article->url = $result->data->url_overridden_by_dest;
                    $article->save();
                }
                
            }
                
        }
}

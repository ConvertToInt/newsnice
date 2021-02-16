@extends('layout')

@section('head')
    <link rel="stylesheet" href="{{url('css/article.css')}}">

    <style>
        
    </style>

    <?php
    
    $type = 'article';

    ?>
@endsection

@section('content')

    <h1 class="title has-text-centered has-text-weight-bold has-text-grey-darker is-size-3 mb-6"><a class="has-text-grey-darker" href="{{ route('home') }}">Home</a> | <a class="has-text-grey-darker" href="{{route('following_feed')}}">Following</a></h1>

        @foreach($articles as $article)
            @include('snippets._article')    
        @endforeach

@endsection
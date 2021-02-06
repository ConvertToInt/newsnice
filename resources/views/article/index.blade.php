@extends('layout')

@section('head')
    <link rel="stylesheet" href="{{url('css/article.css')}}">
@endsection

@section('content')

    <h1 class="title has-text-centered has-text-weight-bold is-size-3 has-text-grey-lighter mb-6"><a href="{{ route('home') }}">Home</a> | <a href="{{route('following_feed')}}">Following</a></h1>

        @foreach($articles as $article)
            <a href="{{route('article_show', ['article'=>$article->slug])}}">
                @include('snippets._article')
            </a>
        @endforeach

@endsection
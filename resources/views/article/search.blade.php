@extends('layout')

@section('head')
    
@endsection

@section('content')
@if($articles->isNotEmpty())
    @foreach ($articles as $article)
        <a href="{{route('article_show', ['article'=>$article->slug])}}">
            @include('snippets._article')
        </a>
    @endforeach
@else 
    <div>
        <h2>No posts found</h2>
    </div>
@endif
@endsection
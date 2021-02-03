@extends('layout')

@section('head')

@endsection

@section('content')

    @foreach($articles as $article)
        {{$article->title}}
    @endforeach

@endsection
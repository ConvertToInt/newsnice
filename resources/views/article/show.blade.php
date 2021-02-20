@extends('layout')

@section('head')

@endsection

@section('content')

    @include('snippets._article')

    @include('snippets._comments-replies')

    @include('snippets._comment_form')

@endsection
@extends('layout')

@section('head')
<style>
    .display-comment .display-comment{
        margin-left: 40px;
    }
</style>
@endsection

@section('content')

    @include('snippets._article')

    @include('snippets._comments-replies')

    @include('snippets._comment_form')

@endsection
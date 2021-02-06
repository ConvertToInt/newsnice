@extends('layout')

@section('head')
    <link rel="stylesheet" href="{{url('css/article.css')}}">
@endsection

@section('content')

    <h1 class="title has-text-centered has-text-weight-bold is-size-3 has-text-grey-lighter mb-6"><a href="{{ route('home') }}">Home</a> | <a href="{{route('following_feed')}}">Following</a></h1>

    <div class="columns is-centered">
        <div class="column is-half">

        @foreach($articles as $article)
            @include('snippets._article')
        @endforeach

        </div>
    </div>

@endsection
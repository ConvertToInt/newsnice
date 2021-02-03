@extends('layout')

@section('head')
    <link rel="stylesheet" href="{{url('css/article.css')}}">
@endsection

@section('content')

    <div class="columns is-centered">
        <div class="column is-half">

        @foreach($articles as $article)
            @include('snippets._article')
        @endforeach

        </div>
    </div>

@endsection
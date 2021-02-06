@extends('layout')

@section('head')

@endsection

@section('content')

<div class="columns is-centered">
    <div class="column is-half">

    <form method="POST" action="{{ route('settings_update', ['user'=>$user]) }}">
        @csrf
        @method('PATCH')

        <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input" type="text" name="name" value="{{$user->name}}">
        </div>
        </div>

        <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input class="input" type="email" name="email" value="{{$user->email}}">
        </div>
        </div>

        {{-- <div class="field">
        <label class="label">Password</label>
        <div class="control">
            <input class="input" type="email" placeholder="Update your password">
        </div>
        </div>

        <div class="field">
        <div class="control">
            <input class="input" type="email" placeholder="Confirm your password">
        </div>
        </div>--}}

        <div class="control">
        <button class="button is-primary" type="submit">Submit</button>
        </div>
    </form>

    </div>
</div>
@endsection
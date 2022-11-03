@extends('layouts.app')
@section('content')
    <div class="card-body">
        <div class='container-block'>
            <div class="user-block">
                <h3>General info</h3><span class='text'>
                    <div class='element'><span class='text'>User id </span> : {{ $user->id }}</div>
                    <div class='element'><span class='text'>User uuid </span> : {{ $user->uuid }}</div>
                    <div class='element'><span class='text'>Username </span> : {{ $user->username }}</div>
                    <div class='element'><span class='text'>Role </span> : {{ $user->role }}</div>
                    <div class='element'><span class='text'>Is disabled </span> : {{ $user->disabled == false ? 'No' : 'Yes' }}</div>
                    <div class='element'><span class='text'>Account created </span> : {{ $user->created_at }}</div>
                    <div class='element'><span class='text'>Last change was made </span> : {{ $user->updated_at }}</div>
            </div>
            <div class="user-block">
                <h3>Personal info</h3>
                <div class='element'><span class='text'>First name </span> : {{ $user->first_name }}</div>
                <div class='element'><span class='text'>Last name </span> : {{ $user->last_name }}</div>
                <div class='element'><span class='text'>Email </span class='text'> : {{ $user->email }}</div>
            </div>
            <div class="user-block">
                <h3>Last 20 loggin </h3>

                @foreach (Auth::user()->logins as $key => $val)
                    <span class='text'>{{ $key + 1 }} . {{ str_replace('~', ' from ', $val) }}</span>
                @endforeach
            </div>
        </div>
        <button class="BackBtn">
            <a href="{{ route('users') }}">Back </a>
        </button>
        
    </div>
@endsection

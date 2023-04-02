@extends('layouts.app')
@section('content')

<div class='centerBlock'>
    <div class="teamshow">
        <div class = "teamContainer teamInfo">
        <div class = 'teamElement'>
            Team ID: <b> {{$team->id}} </b>
        </div>
        <div class = 'teamElement'>
            Team Title: <b> {{$team->club_name}} </b>
        </div>
        <div class = 'teamElement'>
            Rating Points: <b> {{$team->club_rating_points}} </b>
        </div>
        <div class = 'teamElement'>
            Team Rank: <b> {{$team->club_rank}} </b>
        </div>
        <div class = 'teamElement'>
            Supporters Count: <b> {{$team->supporters}} </b>
        </div>
        <div class = 'teamElement'>
            Supporters Mood: <b> {{$team->supporters_mood}} </b>
        </div>
        <div class = 'teamElement'>
            Team Budget: <b> {{$team->budget}} </b>
        </div>
        <div class = 'teamElement'>
            Country: <b> {{$team->country_id}} </b>
        </div>
        <div class = 'teamElement'>
            Town: <b> {{$team->town_id}} </b>
        </div>
        <div class = 'teamElement'>
            User: <b> {{$team->user_id}} </b>
        </div>
        <div class = 'teamElement'>
            Created: <br><b> {{$team->created_at}} </b>
        </div>
        <div class = 'teamElement'>
            Last Changes: <br><b> {{$team->updated_at}} </b>
        </div>
    </div>
    <div> 
        <button class="button">
            <a href="{{ route('teamPlayers', [$team->id]) }}" class="text-sm text-gray-700 dark:text-gray-500">Players </a>
        </button>
    </div>

    <div style = 'display:flex; flex-direction:column; align-items: center; margin:0.5em;'>
        <button class="button">
            <a href="{{ route('generator') }}" class="text-sm text-gray-700 dark:text-gray-500">Generate another team</a>
        </button>

        <button class="button">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500">Back to dashboard</a>
        </button>
    </div>
</div>
@endsection

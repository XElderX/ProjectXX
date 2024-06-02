@extends('layouts.app')
@section('content')
    <div class="card-body">
        <div class='container-block'>
            <h2>Players List </h2>
            <div> Players count: <span style="color: #008000">{{count($players)}}</span></div>
            <div>
                @if ($errors->any())
            <div class="alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @elseif(session()->has('status_success'))
                <div class="alert alert-success">
                    {{ session()->get('status_success') }}
                </div>
        @endif      
                @foreach ($players as $player)
                <div class = "playerBlock">
                    <div class="container playershow">
                        <div class="fn">First name: <b> {{$player->first_name}} </b></div>
                        <div class="ln">Last name: <b> {{$player->last_name}} </b></div>
                        <div class="age"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'age', 'sort' => ($field === 'age' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Age:</a><b> {{$player->age}} </b></div>
                        <div class="height"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'height', 'sort' => ($field === 'height' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Height:</a>: <b> {{$player->height}} cm </b></div>
                        <div class="weight"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'weight', 'sort' => ($field === 'weight' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Weight:</a>: <b> {{$player->weight}} kg</b></div>
                        <div class="club">Club: <b> {{$player->club_id}} </b></div>
                        <div class="country">Nationality: <b>{{$player->country->country}} </b> 
                            <span id='flags' class='fi fi- {{ $player->country->flag }} '></span>
                        </div>
                        <div class="Position">Position: <b> {{$player->position}} </b></div>
                        <div class="value"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'value', 'sort' => ($field === 'value' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Value:</a>Value: <b> {{ number_format($player->value) }} &dollar;</b> </div>
                        <div class="salary"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'salary', 'sort' => ($field === 'salary' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Salary:</a>: <b> {{ number_format($player->salary) }} &dollar; </b></div>
                        <div class="bookings">Bookings: <b> {{$player->bookings}} </b></div>
                        <div class="injury">Injury days: <b> {{$player->injury_days}} </b></div>
                        <div class="fatigue"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'fatigue', 'sort' => ($field === 'fatigue' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Fatigue:</a><b> {{$player->fatique}} </b></div>
                        <div class="form"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'form', 'sort' => ($field === 'form' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Form:</a>Form: <b> {{$player->form}} </b></div>
                
                        <div class="gk" style='color:brown; margin-top:1em'><a href="{{ route('teamPlayers', [$club_id, 'field' => 'gk', 'sort' => ($field === 'gk' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Goalkeeping:</a> <b> {{ floor($player->gk * 100) / 100 }} </b></div>
                        <div class="def" style='color:brown; margin-top:1em'><a href="{{ route('teamPlayers', [$club_id, 'field' => 'def', 'sort' => ($field === 'def' && $sort === 'asc') ? 'desc' : 'asc'] ) }}">Defending:</a> <b> {{ floor($player->def * 100) / 100 }} </b> </div>
                        <div class="pm" style="color: brown; margin-top: 1em"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'pm', 'sort' => ($field === 'pm' && $sort === 'asc') ? 'desc' : 'asc']) }}">Playmaking:</a><b>{{ floor($player->pm * 100) / 100 }}</b></div>
                        <div class="pace" style="color: brown;"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'pace', 'sort' => ($field === 'pace' && $sort === 'asc') ? 'desc' : 'asc']) }}">Pace:</a><b>{{ floor($player->pace * 100) / 100 }}</b></div>
                        <div class="technique" style="color: brown;"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'tech', 'sort' => ($field === 'tech' && $sort === 'asc') ? 'desc' : 'asc']) }}">Technique:</a><b>{{ floor($player->tech * 100) / 100 }}</b></div>
                        <div class="pass" style="color: brown;"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'pass', 'sort' => ($field === 'pass' && $sort === 'asc') ? 'desc' : 'asc']) }}">Passing:</a><b>{{ floor($player->pass * 100) / 100 }}</b></div>
                        <div class="Head" style="color: brown; margin-bottom: 1em"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'heading', 'sort' => ($field === 'heading' && $sort === 'asc') ? 'desc' : 'asc']) }}">Heading:</a><b>{{ floor($player->heading * 100) / 100 }}</b></div>
                        <div class="str" style="color: brown; margin-bottom: 1em"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'str', 'sort' => ($field === 'str' && $sort === 'asc') ? 'desc' : 'asc']) }}">Striker:</a><b>{{ floor($player->str * 100) / 100 }}</b></div>
                        <div class="stamina" style="color: brown; margin-bottom: 1em"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'stamina', 'sort' => ($field === 'stamina' && $sort === 'asc') ? 'desc' : 'asc']) }}">Stamina:</a><b>{{ floor($player->stamina * 100) / 100 }}</b></div>
                        <div class="exp" style="color: rgb(46,139,87);"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'exp', 'sort' => ($field === 'exp' && $sort === 'asc') ? 'desc' : 'asc']) }}">Exp:</a><b>{{ floor($player->exp * 100) / 100 }}</b></div>
                        <div class="pot" style="color: rgb(46,139,87);"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'potential', 'sort' => ($field === 'potential' && $sort === 'asc') ? 'desc' : 'asc']) }}">Potential:</a><b>{{ floor($player->potential * 100) / 100 }}</b></div>
                        <div class="leadership" style="color: rgb(46,139,87);"><a href="{{ route('teamPlayers', [$club_id, 'field' => 'lead', 'sort' => ($field === 'lead' && $sort === 'asc') ? 'desc' : 'asc']) }}">Leadership:</a><b>{{ floor($player->lead * 100) / 100 }}</b></div>
                        <div class="created" style="border-top: 3px solid rgb(95,158,160, 0.8); padding-top:1em;">Created_at:<b>{{ $player->created_at }}</b></div>
                        <div class="upd" style="border-top: 3px solid rgb(95,158,160, 0.8); padding-top: 1em;"> Updated_at:<b>{{ $player->updated_at }}</b></div>
                        <button type="button" class="buttonFire" data-bs-toggle="modal" data-bs-target="#fire{{ $player->id }}">Fire</button>
                        @include('players.firePlayer')
                    </div>
                    </div>
                    @endforeach
                    <div style = 'display:flex; flex-direction:column; align-items: center; margin:0.5em;'>
                    <button class="button">
                        <a href="{{ route('genTeam', [$club_id] ) }}" class="text-sm text-gray-700 dark:text-gray-500">Back to team details</a>
                    </button>
            
                    <button class="button">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500">Back to dashboard</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

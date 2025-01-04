@extends('layouts.app')
@section('content')

<div>
    <div class="container playershow">
        <div class="fn">First name: <b> {{$player->first_name}} </b></div>
        <div class="ln">Last name: <b> {{$player->last_name}} </b></div>
        <div class="age">Age: <b> {{$player->age}} </b></div>
        <div class="height">Height: <b> {{$player->height}} cm </b></div>
        <div class="weight">Weight: <b> {{$player->weight}} kg</b></div>
        <div class="club">Club: <b> {{$player->club_id}} </b></div>
        <div class="country">Nationality: <b>{{$player->country->country}} </b> 
            <span id='flags' class='fi fi- {{ $player->country->flag }} '></span>
        </div>
        <div class="Position">Position: <b> {{$player->position}} </b></div>
        <div class="value">Value: <b> {{ number_format($player->value) }} &dollar;</b> </div>
        <div class="salary">Salary: <b> {{ number_format($player->salary) }} &dollar; </b></div>
        <div class="bookings">Bookings: <b> {{$player->bookings}} </b></div>
        <div class="injury">Injury days: <b> {{$player->injury_days}} </b></div>
        <div class="fatigue">Fatique: <b> {{$player->fatique}} </b></div>
        <div class="form">Form: <b> {{$player->form}} </b></div>

        <div class="gk" style='color:brown; margin-top:1em'>Goalkeeping: <b> {{ floor($player->gk * 100) / 100 }} </b></div>
        <div class="def" style='color:brown; margin-top:1em'>Defending: <b> {{ floor($player->def * 100) / 100 }} </b> </div>
        <div class="pm" style='color:brown; margin-top:1em'>Playmaking: <b> {{ floor($player->pm * 100) / 100 }} </b> </div>
        <div class="pace" style='color:brown;'>Pace: <b> {{ floor($player->pace * 100) / 100 }} </b></div>
        <div class="technique" style='color:brown;'>Technique: <b> {{ floor($player->tech * 100) / 100 }} </b> </div>
        <div class="pass" style='color:brown;'>Passing: <b> {{  floor($player->pass * 100) / 100 }} </b></div>
        <div class="Head" style='color:brown; margin-bottom:1em'>Heading: <b> {{  floor($player->heading * 100) / 100 }} </b></div>
        <div class="str" style='color:brown; margin-bottom:1em'>Striker: <b> {{  floor($player->str * 100) / 100 }} </b></div>
        <div class="stamina" style='color:brown; margin-bottom:1em'>Stamina: <b> {{  floor($player->stamina * 100) / 100 }} </b></div>

        <div class="exp" style='color: rgb(46,139,87);'>Exp: <b> {{ floor($player->exp * 100) / 100 }} </b></div>
        <div class="pot" style='color: rgb(46,139,87);'>Potential: <b> {{ floor($player->potential * 100) / 100 }} </b> </div>
        <div class="leadership" style='color: rgb(46,139,87);'>Leadership: <b> {{ floor($player->lead * 100) / 100}} </b></div>

        <div class="created" style="border-top: 3px solid rgb(95,158,160, 0.8); padding-top:1em;">Created_at: <b> {{$player->created_at}} </b></div>
        <div class="upd" style="border-top: 3px solid rgb(95,158,160, 0.8); padding-top: 1em;">Updated_at: <b> {{$player->updated_at}} </b></div>
    </div>
    <div style = 'display:flex; flex-direction:column; align-items: center; margin:0.5em;'>
        <button class="button">
            <a href="{{ route('generator') }}" class="text-sm text-gray-700 dark:text-gray-500">Generate another player</a>
        </button>

        <button class="button">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500">Back to dashboard</a>
        </button>
    </div>
</div>
@endsection

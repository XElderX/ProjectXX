@extends('layouts.app')
@section('content')
    <div class='main'>
        <div class='mainItem'>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p><strong>Opps Something went wrong</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif(session()->has('status_success'))
                <div class="alert alert-success">
                    {{ session()->get('status_success') }}
                </div>
            @endif

            <div class="title">
                <h3>Match Report</h3>
                <p>@if ($schedule->homeTeam->isNotEmpty())
                    {{ $schedule->homeTeam[0]->club_name }}
                @endif vs  
                @if ($schedule->awayTeam->isNotEmpty())
                {{ $schedule->awayTeam[0]->club_name }}
            @endif</p>

                <div style="display:flex; flex-direction:row; justify-content: space-between; border:2px solid black; padding:5px">

                    <div>
            <table>

                <tr>
                    <td> {{ $schedule->homeTeam[0]->club_name }}</td>
                    <td>{{ $schedule->homeTeam[0]->user->username }}</td>
                </tr>
                <tr>
                    <td>{{ $schedule->awayTeam[0]->club_name }}</td>
                    <td>{{ $schedule->awayTeam[0]->user->username }}</td>
                </tr>
                <tr>
                    <td>Competition</td>
                    <td>{{$schedule->type}}</td>
                </tr>
                <tr>
                    <td>Match date</td>
                    <td>{{$schedule->match_date}}</td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td>{{ $schedule->homeTeam[0]->country->town[0]->town_name }}, {{ $schedule->homeTeam[0]->country->country }}</td>
                </tr>
                <tr>
                    <td>Weather</td>
                    <td>{{ $schedule->homeTeam[0]->country->town[0]->weather }}</td>
                </tr>
                <!-- Add more rows as needed -->
            </table>
        </div>

            @if ($schedule->status === 'pending')
            <div>

            <h5>This match have not started yet.</h5>
            </div>
                
            @else

            <div>
                <h4>Match Statistics</h4>

                <table>

                    <tr>
                        <td> Attendance</td>
                        <td>{{ $schedule->attendance }}</td>
                    </tr>
                    <tr>
                        <td> Home team tactic</td>
                        <td>{{ $schedule->home_tactic }}</td>
                    </tr>
                    <tr>
                        <td>Home team lineup</td>
                        <td>{{$schedule->home_lineup}}</td>
                    </tr>
                    <tr>
                        <td>Away team tactic</td>
                        <td>{{$schedule->away_tactic}}</td>
                    </tr>
                    <tr>
                        <td>Away team lineup</td>
                        <td>{{$schedule->away_lineup}}</td>
                    </tr>
                </table>

            </div>
            </div>
            <h5>Report.</h5>
            

            @foreach ($report as $item)
            <div> <span>{{$item['min']}} minute </span> .  <span>{{$item['event']}}</span> </div>         
            @endforeach
                
            @endif
            </div> 
        </div>
    </div>
@endsection

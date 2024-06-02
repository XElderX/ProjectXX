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
                <p>
                    @if (!is_null($schedule->homeTeam))
                        {{ $schedule->homeTeam->club_name }}
                    @endif vs
                    @if (!is_null($schedule->awayTeam))
                        {{ $schedule->awayTeam->club_name }}
                    @endif
                </p>

                <div
                    style="display:flex; flex-direction:row; justify-content: space-between; border:2px solid black; padding:5px">

                    <div style= 'max-width:25%'>
                        <table>

                            <tr>
                                <td> {{ $schedule->homeTeam->club_name }}</td>
                                <td>{{ $schedule->homeTeam->user->username }}</td>
                            </tr>
                            <tr>
                                <td>{{ $schedule->awayTeam->club_name }}</td>
                                <td>{{ $schedule->awayTeam->user->username }}</td>
                            </tr>
                            <tr>
                                <td>Competition</td>
                                <td>{{ $schedule->type }}</td>
                            </tr>
                            <tr>
                                <td>Match date</td>
                                <td>{{ $schedule->match_date }}</td>
                            </tr>
                            <tr>
                                <td>Location</td>
                                @if (isset($schedule->homeTeam[0]->country->town[0]->town_name))
                                    <td>{{ $schedule->homeTeam[0]->country->town[0]->town_name }},
                                        {{ $schedule->homeTeam[0]->country->country }}</td>
                                @else
                                    <td>No Data</td>
                                @endif

                            </tr>
                            <tr>
                                <td>Weather</td>
                                @if (isset($schedule->homeTeam[0]->country->town[0]->weather))
                                    <td>{{ $schedule->homeTeam[0]->country->town[0]->weather }}</td>
                                @else
                                    <td>No Data</td>
                                @endif

                            </tr>
                        </table>
                        @if ($schedule->status !== 'pendin')
                        <table>
                            <tr style="display:flex;justify-content: center;align-items: flex-start;">
                                <td> Home team tactic</td>
                                <td>{{ $schedule->home_tactic }}</td>
                            </tr>
                            <tr
                                style="display:flex;justify-content: center; flex-direction: column;align-items: flex-start; padding: 1.5rem;">
                                <td>Home team lineup: </td>
                                <td>
                                    <ol class ="lineupList">
                                        @foreach (json_decode($schedule->home_lineup) as $player)
                                            <li>{{ $player->position }}: {{ $player->player->first_name }}
                                                {{ $player->player->last_name }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                        </table>
                        @endif
                    </div>


                    @if ($schedule->status === 'pendin')
                        <div>

                            <h5>This match have not started yet.</h5>
                        </div>
                    @else
                    <div style="width:50%">
                        <div class='center'>
                            <div class ='match_team'>
                                <a href="#">{{ $schedule->homeTeam->club_name }}</a> - <a href="#">{{ $schedule->awayTeam->club_name }}</a> 
                            </div>
                            {{-- TODO later when club main page made place url to club page --}}
                            <div class="space clear">&nbsp;</div>
                            <div class="space clear">&nbsp;</div>
                            <table align="center" style="margin: auto;">
                                <tbody>
                                    <tr>
                                        <td><img width="135" height="135" src="#">H</td>
                                        <td valign="middle" class="matchdetail_score">{{ $schedule->home_goals }}:{{ $schedule->away_goals }}</td>
                                        <td><img width="135" height="135" src="#">A</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="line clear" bis_skin_checked="1">&nbsp;</div>
                        <div align="center" bis_skin_checked="1">Played right now - 90. minute</div>
                        <div class="line clear" bis_skin_checked="1">&nbsp;</div>
                        <div style = "background-color: rgb(219,215,210) ">
                            <h5>Report.</h5>
                            <div class="line clear" bis_skin_checked="1">&nbsp;</div>
                            {{--             
                        <div>{{$report}}</div> --}}
                            @foreach ($report as $item)
                                @foreach ($item as $key => $value)
                                    <div style ="text-align: justify; padding:0 1em">
                                        <p><strong>{{ $key }}:</strong> {{ $value }}</p>
                                        <div class="line clear" bis_skin_checked="1">&nbsp;</div>
                                    </div>
                                @endforeach
                            @endforeach
                                </div>


                 

                    </div>
                        <div style= 'max-width:25%'>
                            <h4>Match Statistics</h4>
                            <table>
                                <tr style="display:flex;justify-content: center;align-items: flex-start;">
                                    <td> Attendance</td>
                                    <td>{{ $schedule->attendance }}</td>
                                </tr>
                                <tr style="display:flex;justify-content: center;align-items: flex-start;;">
                                    <td>Away team tactic</td>
                                    <td>{{ $schedule->away_tactic }}</td>
                                </tr>
                                <tr
                                    style="display:flex;justify-content: center;flex-direction: column;align-items: flex-start; padding: 1.5rem;">
                                    <td>Away team lineup: </td>
                                    <td>
                                        <ol class ="lineupList">
                                            @foreach (json_decode($schedule->away_lineup) as $player)
                                                <li>{{ $player->position }}: {{ $player->player->first_name }}
                                                    {{ $player->player->last_name }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>
                            </table>

                        </div>
                </div>
           

                {{-- @foreach ($report as $item)
            <div> <span>{{$item['min']}} minute </span> .  <span>{{$item['event']}}</span> </div>         
            @endforeach --}}
                @endif
            </div>
        </div>
    </div>
@endsection

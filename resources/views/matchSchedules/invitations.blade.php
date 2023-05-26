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
                <h3> Friendly Invitations</h3>
            </div>
            <div>
                <div class="title">
                    <h3> Your hosting match</h3>
                </div>
                <div style="display:flex; justify-content: space-between; border:2px solid black; padding:5px">
                    @if (!is_string($host))
                        <div>Match type: <div style="font-weight:900;">{{ $host->type }}</div>
                        </div>
                        <div>User: <div style="font-weight:900;">{{ $host->user->username }}</div>
                        </div>
                        <div>Team: <div style="font-weight:900;">{{ $host->hostTeam?->club_name }}
                                {{ $host->opponentTeam?->club_name }}</div>
                        </div>
                        <div>Plays: <div style="font-weight:900;">{{ $host->host_vanue ? 'At Home' : 'Away' }}</div>
                        </div>
                        <div>Match Date: <div style="font-weight:900;">{{ $host->match_date }}</div>
                        </div>
                        <div> <button type="button" class="button">
                                <a href="{{ route('cancelInvitation', [$host->id]) }}"
                                    class="text-sm text-gray-700 dark:text-gray-500">Cancel it</a>
                            </button> </div>
                    @else
                        <div style="display:flex; justify-content: space-between;">
                            <div>
                                {{ $host }}</div>
                            <div>
                                <form class="generateForm" action="{{ route('hostFriendly') }}" method="POST">
                                    <div class="row mb-3">
                                        @csrf
                                        <div class="fieldDiv">
                                            <label for="vanue"
                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Play vanue:</label>
                                            <div class="inputItem">
                                                <select class="" name="vanue" id="">
                                                    <option value="1">1 - Home</option>
                                                    <option value="2">2 - Away</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="fieldDiv">
                                            <label for="type"
                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Match Type</label>
                                            <div class="inputItem">
                                                <select class="" name="type" id="">
                                                    <option value="friendly">Friendly</option>
                                                    <option value="cup_friendly">Cup Friendly</option>
                                                    <option value="training">Training</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="button">Submit Host</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <div style="display:flex; flex-direction:column; justify-content: space-between; border:2px solid black; padding:5px">

                    @if ($invitations->isEmpty())
                        <p>There is no invitations yet.</p>
                    @else
                        @foreach ($invitations as $invitation)
                        <div style="display:flex; flex-direction:row; justify-content: space-between; border:2px solid black;">
                            <div>Match type: <div style="font-weight:900;">{{ $invitation->type }}</div>
                            </div>
                            <div>User: <div style="font-weight:900;">{{ $invitation->user->username }}</div>
                            </div>
                            <div>Opponent: 
                                <div style="font-weight:900;">{{ $invitation->hostTeam?->club_name }}</div>
                            </div>
                            <div>Your team: 
                                <div style="font-weight:900;">{{ $invitation->opponentTeam?->club_name }}</div>
                            </div>
                            <div>Play: <div style="font-weight:900;">{{ $invitation->host_vanue ? 'Away' : 'At Home' }}
                                </div>
                            </div>
                            <div>Match Date: <div style="font-weight:900;">{{ $invitation->match_date }}</div>
                            </div>
                            <div> <button type="button" class="button">
                                    <a href="{{ route('acceptInvitation', [$invitation->id]) }}"
                                        class="text-sm text-gray-700 dark:text-gray-500">Accept it</a>
                                </button> </div>
                        </div>
                        @endforeach
                    @endif
                </div>



                <button type="button" class="button">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500">Back to
                        dashboard</a>
                </button>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="card-body">
        <div class='container-block'>
            <h2>Players List </h2>
            <div>
                <table style="font-size:0.7rem">
                    <colgroup>
                        <col style="width: 30px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                        <col style="width: 150px">
                    </colgroup>
                    <thead class=''>
                        <tr>
                            <td>id</td>
                            <td>first_name</td>
                            <td>last_name</td>
                            <td>value</td>
                            <td>salary</td>
                            <td>height</td>
                            <td>weight</td>
                            <td>age</td>
                            <td>injury_days</td>
                            <td>fatique</td>
                            <td>position</td>
                            <td>club_id</td>
                            <td>country_id</td>
                            <td>created_at</td>
                            <td>updated_at</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody class=''>
                        @foreach ($players as $player)
                            <tr>
                                <td style="background-color:green">{{ $player->id }}</td>
                                <td style="height:1em;">{{ $player->first_name }}</td>
                                <td style="height:1em;">{{ $player->last_name }}</td>
                                <td style="height:1em;">{{ $player->value }}</td>
                                <td style="height:1em;">{{ $player->salary }}</td>
                                <td style="height:1em;">{{ $player->height }}</td>
                                <td style="height:1em;">{{ $player->weight }}</td>
                                <td style="height:1em;">{{ $player->age }}</td>
                                <td style="height:1em;">{{ $player->injury_days }}</td>
                                <td style="height:1em;">{{ $player->fatique }}</td>
                                <td style="height:1em;">{{ $player->position }}</td>
                                <td style="height:1em;">{{ $player->club_id }}</td>
                                <td style="height:1em;">{{ $player->country_id }}</td>
                                <td style="height:1em;">{{ $player->created_at }}</td>
                                <td style="height:1em;">{{ $player->updated_at }}</td>
                                <!-- Button trigger deletion modal -->
                                <td style="height:1em; display: flex;">
                                    <button  type="button" class="buttonSm" data-bs-toggle="modal"
                                        data-bs-target="#stats{{ $player->id }}">View Stats</button>
                                    @include('players.statsModalPlayer')

                                    <button type="button" class="buttonSm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $player->id }}">Delete</button>
                                    @include('players.deleteModalPlayer')
                                    <!-- Button trigger modal -->
                                    <button type="button" class="buttonSm" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $player->id }}">Edit
                                    </button>
                                    @include('players.editModalPlayer')</div>
                                </div>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                        </table>
                            {{ $players->links() }}
                            <!-- Button trigger modal -->
                            <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#create">Add player</button>
                            <button type="button" class="button">
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500">Back to dashboard</a>
                            </button>
                            <button type="button" class="button" data-bs-toggle="modal"
                             data-bs-target="#clear" style="float:left; background-color:rgb(255,56,0);
                              margin-right:50%; color:gold; border-radius:10px; border:2px solid rgb(49, 44, 13)">Delete ALL players
                            </button>
                            @include('players.clearAllPlayersModal')
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
                            @include('players.createModalPlayer')
                </div>
        </div>
    </div>
@endsection

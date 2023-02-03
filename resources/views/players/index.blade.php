@extends('layouts.app')
@section('content')
    <div class="card-body">
        <div class='container-block'>
            <h2>Players List </h2>
            <div>
                <table style="undefined;table-layout: fixed; width: 220px">
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
                    <thead class='tableHead'>
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
                    <tbody class='tableBody'>
                        @foreach ($players as $player)
                            <tr>

                                <td>{{ $player->id }}</td>
                                <td>{{ $player->first_name }}</td>
                                <td>{{ $player->last_name }}</td>
                                <td>{{ $player->value }}</td>
                                <td>{{ $player->salary }}</td>
                                <td>{{ $player->height }}</td>
                                <td>{{ $player->weight }}</td>
                                <td>{{ $player->age }}</td>
                                <td>{{ $player->injury_days }}</td>
                                <td>{{ $player->fatique }}</td>
                                <td>{{ $player->position }}</td>
                                <td>{{ $player->club_id }}</td>
                                <td>{{ $player->country_id }}</td>
                                <td>{{ $player->created_at }}</td>
                                <td>{{ $player->updated_at }}</td>


                                {{-- <td>{{ $player->id }}</td>
                                <td>{{ $player->first_name }}</td>
                                <td>{{ $player->last_name }}</td>
                                <td>{{ $player->value }}</td>
                                <td>{{ $player->salary }}</td>
                                <td>{{ $player->height }}</td>
                                <td>{{ $player->budget }}</td>
                                <td><span id='flags' class='fi fi-{{ $player->country->flag }}'> </span>
                                    {{ $player->country->country }} </td>
                                <td>{{ $player->town->town_name ?? '-' }} </td>
                                <td>{{ $player->user->username ?? '-' }} </td>
                                <td>{{ $player->created_at }} </td>
                                <td>{{ $player->updated_at }} </td> --}}
                                <!-- Button trigger deletion modal -->
                                <td>
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#stats{{ $player->id }}">View Stats</button>
                                    @include('players.statsModalPlayer')

                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $player->id }}">Delete</button>
                                    @include('players.deleteModalPlayer')
                                    <!-- Button trigger modal -->
                                    <button type="button" class="button" data-bs-toggle="modal"
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
        <button>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Back to dashboard</a>
        </button>
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

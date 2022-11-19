@extends('layouts.app')
@section('content')
    <div class="card-body">
        <div class='container-block'>
            <h2>CLubs List </h2>
            <div>
                <table style="undefined;table-layout: fixed; width: 220px">
                    <colgroup>
                        <col style="width: 50px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 50px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                    </colgroup>
                    <thead class='tableHead'>
                        <tr>
                            <td>ID</td>
                            <td>Club Title</td>
                            <td>Club_rating_points</td>
                            <td>Club rank</td>
                            <td>Supporters</td>
                            <td>Supporters_mood</td>
                            <td>Budget</td>
                            <td>Country</td>
                            <td>Town</td>
                            <td>User</td>
                            <td>Created_at</td>
                            <td>Updated_at</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody class='tableBody'>
                        @foreach ($clubs as $club)
                            <tr>
                                <td>{{ $club->id }}</td>
                                <td>{{ $club->club_name }}</td>
                                <td>{{ $club->club_rating_points }}</td>
                                <td>{{ $club->club_rank }}</td>
                                <td>{{ $club->supporters }}</td>
                                <td>{{ $club->supporters_mood }}</td>
                                <td>{{ $club->budget }}</td>
                                <td><span id='flags' class='fi fi-{{ $club->country->flag }}'> </span>
                                    {{ $club->country->country }} </td>
                                <td>{{ $club->town->town_name ?? '-' }} </td>
                                <td>{{ $club->user->username ?? '-' }} </td>
                                <td>{{ $club->created_at }} </td>
                                <td>{{ $club->updated_at }} </td>
                                <!-- Button trigger deletion modal -->
                                <td>
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $club->id }}">Delete</button>
                                    @include('clubs.deleteModal')
                                    <!-- Button trigger modal -->
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $club->id }}">Edit
                                    </button>
                                    @include('clubs.editModal')
                                </div>
                            </div>
                            </td>
                            </tr>
                                @endforeach
                            </tbody>
                            </table>
                                {{ $clubs->links() }}
        <!-- Button trigger modal -->
        <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#addClub">Add club</button>
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
        @include('clubs.addModal')
    </div>
    </div>
    </div>
@endsection

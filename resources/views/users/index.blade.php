@extends('layouts.app')
@section('content')
    <div class="card-body">
        <div class='container-block'>
            <h2>Users List </h2>

            <div>
                <table style="undefined;table-layout: fixed; width: 220px">
                    <colgroup>
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                        <col style="width: 150px">
                    </colgroup>
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>username</td>
                            <td>role</td>
                            <td>email</td>
                            <td>disabled</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->email }}</td>
                                <td> {{ $user->disabled == false ? 'No' : 'Yes' }} </td>
                                <td>


                                    <!-- Button trigger modal -->
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#viewUser{{ $user->uuid }}">
                                        View details
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="viewUser{{ $user->uuid }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Account
                                                        {{ $user->username }} details</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class='container-block'>
                                                            <div class="user-block">
                                                                <h3>General info</h3><span class='text'>
                                                                    <div class='element'><span class='text'>User id
                                                                        </span> : {{ $user->id }}</div>
                                                                    <div class='element'><span class='text'>User uuid
                                                                        </span> : {{ $user->uuid }}</div>
                                                                    <div class='element'><span class='text'>Username
                                                                        </span> : {{ $user->username }}</div>
                                                                    <div class='element'><span class='text'>Role </span> :
                                                                        {{ $user->role }}</div>
                                                                    <div class='element'><span class='text'>Is disabled
                                                                        </span> :
                                                                        {{ $user->disabled == false ? 'No' : 'Yes' }}</div>
                                                                    <div class='element'><span class='text'>Account
                                                                            created </span> : {{ $user->created_at }}</div>
                                                                    <div class='element'><span class='text'>Last change
                                                                            was made </span> : {{ $user->updated_at }}
                                                                    </div>
                                                            </div>
                                                            <div class="user-block">
                                                                <h3>Personal info</h3>
                                                                <div class='element'><span class='text'>First name </span>
                                                                    : {{ $user->first_name }}</div>
                                                                <div class='element'><span class='text'>Last name </span>
                                                                    : {{ $user->last_name }}</div>
                                                                <div class='element'><span class='text'>Email </span
                                                                        class='text'> : {{ $user->email }}</div>
                                                            </div>
                                                            <div class="user-block">
                                                                <h3>Last 20 loggin </h3>

                                                                @foreach (Auth::user()->logins as $key => $val)
                                                                    <div class='text'>{{ $key + 1 }} .
                                                                        {{ str_replace('~', ' from ', $val) }}</div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="button"><a href="{{ route('users.ban', $user->uuid) }}">{{ $user->disabled == false ? 'Disable' : 'Unban' }}</a></button>

                                    {{-- <a href="{{ route('users.show', $user->uuid) }}">View user details</a> --}}
                                    

                                    {{-- <form class="actions" action="/users/ban/{{ $user->uuid }}" method="post">
                                <button>
                                    <a class="btn btn-success" href=""><i class="fa-solid fa-pen-to-square"></i>Disable</a>
                                </button>
                                @csrf 
                                 @method('DELETE')
                                <button><i class="fa-solid fa-xmark"></i>Delete</button>
                            </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

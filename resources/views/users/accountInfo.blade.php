@extends('layouts.app')
@section('content')
    <div class="card-body flex-col">
        <div class="flex items-center">
            <div class="user-block">
                                    <h3>General info</h3><span class='text'>
                    <div class='element'><span class='text'>User id </span> : {{ $user->id }}</div>
                    <div class='element'><span class='text'>User uuid </span> : {{ $user->uuid }}</div>
                    <div class='element'><span class='text'>Username </span> : {{ $user->username }}</div>
                    <div class='element'><span class='text'>Role </span> : {{ $user->role }}</div>
                    <div class='element'><span class='text'>Is disabled </span> : {{ $user->disabled == false ? 'No' : 'Yes' }}</div>
                    <div class='element'><span class='text'>Account created </span> : {{ $user->created_at }}</div>
                    <div class='element'><span class='text'>Last change was made </span> : {{ $user->updated_at }}</div>
            </div>
            <div class="flex-col">
                <div class="user-block">
                                            <h3>Personal info</h3>
                    <div class='element'><span class='text'>First name </span> : {{ $user->first_name }}</div>
                    <div class='element'><span class='text'>Last name </span> : {{ $user->last_name }}</div>
                    <div class='element'><span class='text'>Email </span class='text'> : {{ $user->email }}</div>
                </div>
                <div> 
                    <form class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="{{ route('user.update', auth()->user()->id) }}" method="POST">
                    <div class="newProductDiv row mb-3">
                        @csrf
                    <div class="col-sm-10"> 
                                      <h3>Active club</h3>                   
                        <select name="club_id" id="" class="form-control">
                            @if ($user->club_id !== null)
                            <option>
                                {{ $user->userClub->club_name }}</option>    
                            @endif
                            @foreach ($clubs as $club)
                                @if ( $club->id === $user->club_id)
                                    @continue
                                @endif
                                <option value="{{ $club->id }}">
                                    {{ $club->club_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <button type="submit" class="button">Submit</button>
                </form>
                    {{-- <div class='element'><span class='text'>Club </span> : {{ $user->club_id }}</div> --}}
                </div>
            </div>
        </div>
        <div class="user-block">
            <h3>Last 20 loggin </h3>

            @foreach (Auth::user()->logins as $key => $val)
                <div class='text'>{{ $key + 1 }} . {{ str_replace('~', ' from ', $val) }}</div>
            @endforeach
        </div>
        <button ype="button" class="button">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Back to
                dashboard</a>
        </button>
        
    </div>
@endsection

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
            <h3> Propose friendly</h3>
        </div>
        
        <form class="generateForm" action="{{ route('proposeFriendly') }}" method="POST">
            <div class="row mb-3">
                @csrf
                <div class="fieldDiv">
                    <label for="vanue"
                        class="w-96 block text-gray-700 text-sm font-bold mb-2">Play vanue:</label>
                    <div class="">
                        <select class="" name="vanue" id="">                    
                            <option value="1">1 - Home</option>
                            <option value="2">2 - Away</option>     
                        </select>
                    </div>
                </div>
                    <div class="fieldDiv">
                        <label for="opponent_id" class="w-96 block text-gray-700 text-sm font-bold mb-2">Opponent id:</label>                 
                        <div class="inputItem">
                            <input type="number" name="opponent_id" class="" id="">
                        </div>                 
                    </div>    
                    </div>
            <button type="submit" class="button">Submit</button>
        </form>
    </div>   
    <button type="button" class="button">
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Back to
            dashboard</a>
    </button>      
</div>
@endsection

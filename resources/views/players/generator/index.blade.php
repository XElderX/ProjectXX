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
            <h3> Generate player</h3>
        </div>
        
        <form class="generateForm" action="{{ route('playerGenerator') }}" method="POST">
            <div class="row mb-3">
                @csrf

                <div class="fieldDiv">
                    <label for="type"
                        class="w-96 block text-gray-700 text-sm font-bold mb-2">Type:</label>
                    <div class="">
                        <select class="" name="type">
                            
                            <option value="1">1 - Player</option>
                            <option value="2">2 - Youth player</option>
                            <option value="3">3 - Trainer</option>         
                        </select>
                    </div>
                </div>

                    <div class="fieldDiv">
                        <label for="country_id" class="w-96 block text-gray-700 text-sm font-bold mb-2">Country (optional):</label>                 
                            <div class="inputItem">
                                <select name="country_id" id="" class="">
                                    <option value="0" selected disabled>Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>                   
                    </div>    

                    <div class="fieldDiv">
                        <div>
                        <label for="Club_id"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Club id (optional)</label>
                        </div>
                        <div class="inputItem">
                                <input type="text" name="club_id" class="" id="club_id" defaultValue="0">
                        </div>
                    </div>

                    <div class="fieldDiv">
                        <div>
                        <label for="Club_id"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Age (optional)</label>
                        </div>
                        <div class="inputItem">
                                <input type="number" name="age" class="" id="age" defaultValue="0">
                        </div>
                    </div>

                    <div class="fieldDiv">
                            <label for="Position" class="w-96 block text-gray-700 text-sm font-bold mb-2">Favourite
                                Position (optional): 
                            </label>
                        <div class="inputItem">
                            <select name="position" id="" class="">
                                <option value="0" selected disabled>Select position</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position }}">
                                        {{ $position }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            <button type="submit" class="button">Submit</button>
        </form>
    </div>
            
            
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
    </div>
    
</div>
@endsection
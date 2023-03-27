@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 

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
                        <select class="" name="type" id="selectt">                    
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
                        <label for="quality"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Youth Quality</label>
                        </div>
                        <div class="inputItem">
                                <input type="text" name="quality" class="" id="quality">
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

        <div class="title">
            <h3> Generate Team</h3>
        </div>
        
        <form class="generateForm" action="{{ route('teamGenerator') }}" method="POST">
            <div class="row mb-3">
                @csrf
                <div class="fieldDiv">
                    <label for="type"
                        class="w-96 block text-gray-700 text-sm font-bold mb-2">Type:</label>
                    <div class="">
                        <select class="" name="team_type" id="teamType">                    
                            <option value="1">1 - Club</option>
                            <option value="2">2 - National Team</option>
                            <option value="3">3 - Youth Team</option>         
                        </select>
                    </div>
                </div>
                <div class="fieldDiv">
                    <label for="title"
                        class="w-96 block text-gray-700 text-sm font-bold mb-2">User Id:</label>
                    <div class="">
                        <div class="inputItem">
                            <input type="text" name="user_id" class="" id="title">
                    </div>
                    </div>
                </div>
                <div class="fieldDiv">
                    <label for="title"
                        class="w-96 block text-gray-700 text-sm font-bold mb-2">Title: (required)</label>
                    <div class="">
                        <div class="inputItem">
                            <input type="text" name="title" class="" id="title">
                    </div>
                    </div>
                </div>
                    <div class="fieldDiv">
                        <label for="country_id" class="w-96 block text-gray-700 text-sm font-bold mb-2">Country (required):</label>                 
                            <div class="inputItem">
                                <select name="country_id" id="teamCountry" class="">
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
                        <label for="town_id"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Town(optional)</label>
                        </div>
                        <div class="inputItem">
                            <select name="town_id" id="teamTown" class="">
                                <option value="0" selected disabled>Select Town</option>
                                            
                                        {{-- @foreach (App\Http\Controllers\ClubController::getTowns(1) as $town)
                                        
                                        <option value="{{ $town->id }}"> 
                                            {{ $town->town_name }}
                                        </option>
                                            @endforeach --}}
                                                                               
                            </select>
                        </div>
                    </div>

                </div>

            <button type="submit" class="button">Submit</button>
        </form>
    </div>
    </div>
    
</div>

<script type="text/javascript">
$('#selectt').on('change', function(e) {
    // get the selected value
    let val = $(this).val();
    if (val != 2) {
    $("#quality").attr("disabled", "disabled");
  } else {
    $("#quality").removeAttr("disabled");
  }
}).trigger("change");


$('#teamCountry').on('change', function(e) {
    let val = $(this).val();
    if (val) {
        const optionsElements = document.getElementsByClassName('options') || false;
        while (optionsElements.length > 0) optionsElements[0].remove();

        var APP_URL = {!! json_encode(url('/')) !!}
			e.preventDefault();
			$.ajax({
			    url: APP_URL + "/get-towns/" + val,
			    type: "GET", // 
			    success: function(data){
                    data.forEach(element => {
                        var option = document.createElement("option");
                        option.value = element['id'];
                        option.text = element['town_name'];
                        option.classList.add('options');
                        $("#teamTown").append(option);   
                    });	
			    },
			    error: function(data){
			    },
			});
        }
}).trigger("change");


$('#teamCountry').on('change', function(e) {
    // get the selected value
    let val = $(this).val();
    if (!val) {
    $("#teamTown").attr("disabled", "disabled");
  } else {
    $("#teamTown").removeAttr("disabled");
  }
}).trigger("change");
</script>

@endsection

@extends('layouts.app')
@section('content')
{{-- No used --}}


<div class="createContainer">
    <form class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('countries.store') }}" method="POST">
        <div class="newProductDiv row mb-3">
            @csrf
            <label for="Country title" class="w-96 block text-gray-700 text-sm font-bold mb-2">Country name:</label>
            <div class="col-sm-10">
                <input type="text" name="country" class="w-96 form-control" id="country" placeholder="name (ex. Lithuania)">
            </div>
            <label for="Population" class="w-96 block text-gray-700 text-sm font-bold mb-2">How many people lives (Population)</label>
            <div class="col-sm-10">
                <input type="number" name="population" class="w-96 form-control" id="population" placeholder="population (ex. 150000)">
            </div>
            <label for="flag" class="w-96 block text-gray-700 text-sm font-bold mb-2">flag url</label>
            <div class="col-sm-10">
                <input type="text" name="flag" class="w-96 form-control" id="flag" placeholder="flag (ex. gr)">
            </div>
            <label for="timezone" class="w-96 block text-gray-700 text-sm font-bold mb-2">Timezone</label>
            <div class="col-sm-10">
                <input type="text" name="timezone" class="w-96 form-control" id="timezone" placeholder="timezone (ex. gr)">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
            </div>
        </div>
    </form>



    {{-- <div class="title-container">Add name into database:</div>
    <form class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('person_names') }}" method="POST">
        <div class="newProductDiv row mb-3">
            @csrf
            <label for="Person Name" class="w-96 block text-gray-700 text-sm font-bold mb-2">Person Name:</label>
            <div class="col-sm-10">
                <input type="text" name="p_name" class="w-96 form-control" id="p_name" placeholder="name (ex. Petras)">
            </div>
            <label for="Frequently" class="w-96 block text-gray-700 text-sm font-bold mb-2">How common this name (1 rare - 10 very common):</label>
            <div class="col-sm-10">
                <select class="form-control" name="frequently">
                    <option selected>Pick how frequently is used</option>
                    <option value="1">1 - Very Rare</option>
                    <option value="2">2 - Mostly Rare</option>
                    <option value="3">3 - Rare</option>
                    <option value="4">4 - Uncommon</option>
                    <option value="5">5 - Neither Common nor rare</option>
                    <option value="6">6 - Common</option>
                    <option value="7">7 - Fairly common</option>
                    <option value="8">8 - Mostly common</option>
                    <option value="9">9 - Very Common</option>
                    <option value="10">10 - Frequently common</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
            </div>
        </div>
    </form>

    <div class="back-link"><a href="{{ route('person_names') }}">Back to previous page</a></div>
     --}}
</div>
    
@endsection
@extends('layouts.app')
@section('content')
    <div class="card-body">
        <div class='container-block'>
            <h2>Towns List </h2>
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
                        <col style="width: 150px">
                    </colgroup>
                    <thead class='tableHead'>
                        <tr>
                            <td>ID</td>
                            <td>Town</td>
                            <td>Population</td>
                            <td>Country</td>
                            <td>Weather</td>
                            <td>Created</td>
                            <td>Updated</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody class='tableBody'>
                        @foreach ($towns as $town)
                            <tr>
                                <td>{{ $town->id }}</td>
                                <td>{{ $town->town_name }}</td>
                                <td>{{ $town->population }}</td>
                                <td>{{ $town->country->country }} <span id='flags'
                                        class='fi fi-{{ $town->country->flag }} '></span> </td>
                                <td>{{ $town->weather }} </td>
                                <td>{{ $town->created_at }} </td>
                                <td>{{ $town->updated_at }} </td>
                                <!-- Button trigger deletion modal -->
                                <td>
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $town->id }}">Delete</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="delete{{ $town->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Record deletion
                                                        confirmation</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are your sure to delete this Town?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="button"><a
                                                            href="{{ route('town.delete', [$town->id]) }}">Delete</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $town->id }}">Edit
                                    </button>

                                    <div class="modal fade" id="edit{{ $town->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Town</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                                                        action="{{ route('towns.update', [$town->id]) }}" method="POST">
                                                        <div class="newProductDiv row mb-3">
                                                            @csrf
                                                            <label for="Town title"
                                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Town
                                                                name:</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="town_name"
                                                                    class="w-96 form-control" id="town_name"
                                                                    value="{{ $town->town_name }}">
                                                            </div>
                                                            <label for="Country"
                                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Country:</label>
                                                            <div class="col-sm-10">
                                                                <select name="country_id" id=""
                                                                    class="form-control">
                                                                    <option value="{{ $town->country_id }}">
                                                                        {{ $town->country->country }} </option>
                                                                    @foreach ($countries as $country)
                                                                        @if ($country->id === $town->country_id)
                                                                            @continue
                                                                        @endif
                                                                        <option value="{{ $country->id }}">
                                                                            {{ $country->country }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <label for="Population"
                                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">How
                                                                many
                                                                people lives (Population)</label>
                                                            <div class="col-sm-10">
                                                                <input type="number" name="population"
                                                                    class="w-96 form-control" id="population"
                                                                    value="{{ $town->population }}">
                                                            </div>
                                                            <label for="flag"
                                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Weather</label>
                                                            <div class="col-sm-10">
                                                                <select name="weather" id="" class="form-control">
                                                                    <option value="{{ $town->weather }}">
                                                                        {{ $town->weather }}</option>
                                                                    @foreach ($allweather as $weather)
                                                                        @if ($weather === $town->weather)
                                                                            @continue
                                                                        @endif
                                                                        <option value="{{ $weather }}">
                                                                            {{ $weather }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="button">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                            </tr>
                                @endforeach
                            </tbody>
                            </table>
        {{ $towns->links() }}
        <!-- Button trigger modal -->
        <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#addTown">Add Town</button>
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
        <!-- Modal -->
        <div class="modal fade" id="addTown" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new Town</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                            action="{{ route('towns.store') }}" method="POST">
                            <div class="newProductDiv row mb-3">
                                @csrf
                                <label for="Town title" class="w-96 block text-gray-700 text-sm font-bold mb-2">Town
                                    name:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="town_name" class="w-96 form-control" id="town_name"
                                        placeholder="name (ex. Alytus)">
                                </div>
                                <label for="Country"
                                    class="w-96 block text-gray-700 text-sm font-bold mb-2">Country:</label>
                                <div class="col-sm-10">
                                    <select name="country_id" id="" class="form-control">
                                        <option value="" selected disabled>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="Population" class="w-96 block text-gray-700 text-sm font-bold mb-2">How many
                                    people lives (Population)</label>
                                <div class="col-sm-10">
                                    <input type="number" name="population" class="w-96 form-control" id="population"
                                        placeholder="population (ex. 150000)">
                                </div>
                                <label for="flag"
                                    class="w-96 block text-gray-700 text-sm font-bold mb-2">Weather</label>
                                <div class="col-sm-10">
                                    <select name="weather" id="" class="form-control">
                                        <option value="" selected disabled>Select current weather</option>
                                        @foreach ($allweather as $weather)
                                            <option value="{{ $weather }}">{{ $weather }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="button">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

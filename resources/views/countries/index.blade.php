@extends('layouts.app')
@section('content')
    <div class="card-body">
        <h2>Countries List </h2>
        <div class='container-block'>
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
                    <thead class='tableHead'>
                        <tr>
                            <td>ID</td>
                            <td>Country</td>
                            <td>Population</td>
                            <td>Flag</td>
                            <td>Created</td>
                            <td>Updated</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody class='tableBody'>
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->id }}</td>
                                <td>{{ $country->country }}</td>
                                <td>{{ $country->population }}</td>
                                <td><span id='flags' class='fi fi-{{ $country->flag }} '></span></td>
                                <td>{{ $country->created_at }} </td>
                                <td>{{ $country->updated_at }} </td>
                                <!-- Button trigger deletion modal -->
                                <td>
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $country->id }}">Delete</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="delete{{ $country->id }}" data-bs-backdrop="static"
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
                                                    Are your sure to delete this country?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="button"><a
                                                            href="{{ route('countries.delete', [$country->id]) }}">delete</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="button" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $country->id }}">
                                        Edit
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="edit{{ $country->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="edit">Add new Country</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                                                        action="{{ route('countries.update', [$country->id]) }}"
                                                        method="POST">
                                                        <div class="newProductDiv row mb-3">
                                                            @csrf
                                                            <label for="Country title"
                                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Country name:</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="country"
                                                                    class="w-96 form-control" id="country"
                                                                    value="{{ $country->country }}">
                                                            </div>
                                                            <label for="Population"
                                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">How
                                                                many
                                                                people lives (Population)</label>
                                                            <div class="col-sm-10">
                                                                <input type="number" name="population"
                                                                    class="w-96 form-control" id="population"
                                                                    value="{{ $country->population }}">
                                                            </div>
                                                            <label for="flag"
                                                                class="w-96 block text-gray-700 text-sm font-bold mb-2">flag
                                                                url</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="flag"
                                                                    class="w-96 form-control" id="flag"
                                                                    value="{{ $country->flag }}">
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
        {{ $countries->links() }}


        <!-- Button trigger modal -->
        <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#add">
            add
        </button>
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
        <!-- Modal -->
        <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new Country</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                            action="{{ route('countries.store') }}" method="POST">
                            <div class="newProductDiv row mb-3">
                                @csrf
                                <label for="Country title" class="w-96 block text-gray-700 text-sm font-bold mb-2">Country
                                    name:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="country" class="w-96 form-control" id="country"
                                        placeholder="name (ex. Lithuania)">
                                </div>
                                <label for="Population" class="w-96 block text-gray-700 text-sm font-bold mb-2">How many
                                    people lives (Population)</label>
                                <div class="col-sm-10">
                                    <input type="number" name="population" class="w-96 form-control" id="population"
                                        placeholder="population (ex. 150000)">
                                </div>
                                <label for="flag" class="w-96 block text-gray-700 text-sm font-bold mb-2">flag
                                    url</label>
                                <div class="col-sm-10">
                                    <input type="text" name="flag" class="w-96 form-control" id="flag"
                                        placeholder="flag (ex. gr)">
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

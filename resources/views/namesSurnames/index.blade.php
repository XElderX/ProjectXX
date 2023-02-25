@extends('layouts.app')
@section('content')
<div style="display: flex; flex-direction:column">
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
    </div>
    
    <div class="card-body">
        <div class='flex-container'>
            <div class="flex-item"> names
                <table>
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Popularity</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($names as $name)
                          <tr>
                            <td>{{ $name->name }}</td>
                            <td>{{ $name->country_id }}. {{ $name->country->country }} <span id='flags'
                              class='fi fi-{{ $name->country->flag }} '></span>
                            </td>
                            <td>{{ $name->popularity }}/10</td>
                            <td><button type="button" class="button" data-bs-toggle="modal"
                                data-bs-target="#deleteName{{ $name->id }}">Delete</button>
                            @include('namesSurnames.deleteName')
                            <!-- Button trigger modal -->
                            <button type="button" class="button" data-bs-toggle="modal"
                                data-bs-target="#editName{{ $name->id }}">Edit
                            </button>
                            @include('namesSurnames.updateName')
                          </div></td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>  
                  {{ $names->links() }}  
                  <div>
                    <form class="bg-white shadow-md rounded px-8 pt-4 pb-6 mb-2"
                    action="{{ route('nameSurname') }}" method="GET">
                    <h1>Filter</h1>
                  <select name="country_id" id="" class="form-control">
                    <option value="" selected disabled>Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                    @endforeach
                </select>
                <button type="submit" class="button">Select</button>
              </form>
            </div>
                </div>
            <div class="flex-item">surnames
                <table>
                    <thead>
                      <tr>
                        <th>Surname</th>
                        <th>Country</th>
                        <th>Popularity</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($surnames as $surname)                      
                          <tr>
                            <td>{{ $surname->surname }}</td>
                            <td>{{ $surname->country_id }}. {{ $surname->country->country }} <span id='flags'
                              class='fi fi-{{ $surname->country->flag }} '></span>
                            </td>
                            <td>{{ $surname->popularity }}/10</td>
                            <td><button type="button" class="button" data-bs-toggle="modal"
                              data-bs-target="#deleteSurname{{ $surname->id }}">Delete</button>
                              @include('namesSurnames.deleteSurname')
                          <button type="button" class="button" data-bs-toggle="modal"
                              data-bs-target="#editSurname{{ $surname->id }}">Edit
                          </button>
                          @include('namesSurnames.updateSurname')
                          </tr>                     
                      @endforeach
                    </tbody>
                  </table>
                  {{ $surnames->links() }}
                  </div>

                <div style="display:flex; flex-direction:column;">
                  <div>
                  <button> <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Back to dashboard</a>
                  </button>
                </div>
                  <div>
                    <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#addName">Add new name to the pool</button>
                    @include('namesSurnames.createName')
                  </div>
                </div>
                <div>
                  <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#addSurname">Add new surname to the pool</button>
                  @include('namesSurnames.createSurname')
                </div>
      </div>
    </div>
    </div>
</div>
@endsection

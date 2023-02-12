<div class="modal fade" id="addSurname" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">'
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new surnname to name pool</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="newPlayerForm bg-white shadow-md rounded px-8 pt-4 pb-6 mb-2"
                    action="{{ route('surnames.store') }}" method="POST">
                    <div class="playerAdd row mb-3">
                        @csrf
                        <div class="fieldDiv">
                        <label for="last names" class="w-96 block text-gray-700 text-sm font-bold mb-2">
                            Name:</label>
                        <div class="">
                            <input type="text" name="surname" class="" id="surname">
                        </div>
                    </div>
                    <div>
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
                    </div>
                    <div class="fieldDiv">

                        <label for="Popularity" class="w-96 block text-gray-700 text-sm font-bold mb-2">Popularity:</label>
                        <div class="">
                            <input type="text" name="popularity" class="" id="popularity">
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

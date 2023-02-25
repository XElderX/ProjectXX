<div class="modal fade" id="addName" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">'
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new name to name pool</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="newPlayerForm bg-white shadow-md rounded px-8 pt-4 pb-6 mb-2"
                    action="{{ route('names.store') }}" method="POST">
                    <div class="playerAdd row mb-3">
                        @csrf
                        <div class="fieldDiv">
                        <label for="First name" class="w-96 block text-gray-700 text-sm font-bold mb-2">
                            Name:</label>
                        <div class="">
                            <input type="text" name="name" class="" id="name">
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
                            <select class="form-control" name="popularity">
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
                    <div class="modal-footer">
                        <button type="button" class="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="button">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

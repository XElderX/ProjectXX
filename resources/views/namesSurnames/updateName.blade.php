<div class="modal fade" id="editName{{ $name->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit name record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="Form bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="{{ route('name.update', [$name->id]) }}" method="POST">
                    <div class="playerAdd row mb-3">
                        @csrf
                        <div class="fieldDiv">
                            <label for="First name" class="w-96 block text-gray-700 text-sm font-bold mb-2">
                                Name:</label>
                            <div class="">
                                <input type="text" name="name" class="" id="name"
                                    value="{{ $name->name }}">
                            </div>
                        </div>
                        <div style="display:flex; flex-direction:row; justify-content: space-between;
                        flex-wrap: nowrap;">
                            <label for="Country"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Country:</label>
                            <div class="col-sm-4">
                                <select name="country_id" id="" class="form-control">
                                    <option value="{{ $name->country_id }}">
                                        {{ $name->country->country }} </option>
                                    @foreach ($countries as $country)
                                        @if ($country->id === $name->country_id)
                                            @continue
                                        @endif
                                        <option value="{{ $country->id }}">
                                            {{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="fieldDiv">

                            <label for="Popularity"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Popularity:</label>
                            <div class="">
                                <input type="text" name="popularity" class="" id="popularity"
                                    value="{{ $name->popularity }}">
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

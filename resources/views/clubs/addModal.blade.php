<div class="modal fade" id="addClub" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Club</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form
                    class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="{{ route('clubs.store') }}" method="POST">
                    <div class="newProductDiv row mb-3">
                        @csrf
                        <label for="Town title"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Club Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="club_name"
                                class="w-96 form-control" id="club_name"
                                placeholder="Club Name">
                        </div>
                        <label for="club rating points"
                        class="w-96 block text-gray-700 text-sm font-bold mb-2">Club_rating_points:</label>
                        <div class="col-sm-10">
                            <input type="number" name="club_rating_points"
                                    class="w-96 form-control" id="club_rating_points"
                                    placeholder="club_rating_points">
                            </div>
                                <label for="club_rank"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Club_rank:</label>
                        <div class="col-sm-10">
                            <input type="number" name="club_rank"
                                class="w-96 form-control" id="club_rank"
                                placeholder="Club Rank">
                        </div>
                        <label for="supporters"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">How many supporters club have?</label>
                            <div class="col-sm-10">
                                <input type="number" name="supporters"
                                class="w-96 form-control" id="supporters"
                                placeholder="How many supporters">
                            </div>
                        <label for="supporters_mood"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">supporters_mood</label>
                        <div class="col-sm-10">
                            <select name="supporters_mood" id="" class="form-control">
                                <option value="" disabled selected>
                                    Supporters Mood</option>
                                @foreach ($moods as $mood)

                                @if (isset($club))      
                                @if ($mood === $club->supporters_mood)
                                    @continue
                                @endif
                                @endif
                                    <option value="{{ $mood }}">
                                        {{ $mood }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="budget"
                        class="w-96 block text-gray-700 text-sm font-bold mb-2">Club budget?</label>
                        <div class="col-sm-10">
                            <input type="number" name="budget"
                            class="w-96 form-control" id="budget"
                            placeholder="Club budget">
                        </div>
                        <label for="Country"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Country</label>
                            <label for="Country" class="w-96 block text-gray-700 text-sm font-bold mb-2">Country</label>
                            <div class="col-sm-10">
                                <select name="country_id" id="new" class="form-control dynamic" data-dependent='town_name'>
                                    <option value="" disabled selected>Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <label for="Town" class="w-96 block text-gray-700 text-sm font-bold mb-2">Town</label>
                            <div class="col-sm-10">
                                <select name="town_id" id="newa" class="form-control">
                                    <option value="" disabled selected>Select Town</option>
                                </select>
                            </div>
                            
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function () {
                                    $('#new').change(function () {
                                        var countryId = $(this).val();
                                        if (countryId) {
                                            $.ajax({
                                                url: '/get-towns/' + countryId,
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function (data) {
                                                    $('#newa').empty();
                                                    $('#newa').append('<option value="" disabled selected>Select Town</option>');
                                                    $.each(data, function (key, value) {
                                                        $('#newa').append('<option value="' + value.id + '">' + value.town_name + '</option>');
                                                    });
                                                }
                                            });
                                        } else {
                                            $('#newa').empty();
                                            $('#newa').append('<option value="" disabled selected>Select Town</option>');
                                        }
                                    });
                                });
                            </script>
                                 
                                    {{csrf_field()}}
                                    <label for="user_id"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Team owner id?</label>
                            <div class="col-sm-10">
                                <input type="number" name="user_id"
                                class="w-96 form-control" id="user_id"
                                value="{{ Auth::id() }}">
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

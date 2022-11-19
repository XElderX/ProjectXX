<div class="modal fade" id="edit{{ $club->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Club</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class=" newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="{{ route('club.update', [$club->id]) }}" method="POST">
                    <div class="newProductDiv row mb-3">
                        @csrf
                        <label for="Town title" class="w-96 block text-gray-700 text-sm font-bold mb-2">Club
                            Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="club_name" class="w-96 form-control" id="club_name"
                                value="{{ $club->club_name }}">
                        </div>
                        <label for="club rating points"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Club_rating_points:</label>
                        <div class="col-sm-10">
                            <input type="number" name="club_rating_points" class="w-96 form-control"
                                id="club_rating_points" value="{{ $club->club_rating_points }}">
                        </div>
                        <label for="club_rank"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">Club_rank:</label>
                        <div class="col-sm-10">
                            <input type="number" name="club_rank" class="w-96 form-control" id="club_rank"
                                value="{{ $club->club_rank }}">
                        </div>
                        <label for="supporters" class="w-96 block text-gray-700 text-sm font-bold mb-2">How many
                            supporters club have?</label>
                        <div class="col-sm-10">
                            <input type="number" name="supporters" class="w-96 form-control" id="supporters"
                                value="{{ $club->supporters }}">
                        </div>
                        <label for="supporters_mood"
                            class="w-96 block text-gray-700 text-sm font-bold mb-2">supporters_mood</label>
                        <div class="col-sm-10">
                            <select name="supporters_mood" id="" class="form-control">
                                <option value="{{ $club->supporters_mood }}">
                                    {{ $club->supporters_mood }}</option>
                                @foreach ($moods as $mood)
                                    @if ($mood === $club->supporters_mood)
                                        @continue
                                    @endif
                                    <option value="{{ $mood }}">
                                        {{ $mood }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="budget" class="w-96 block text-gray-700 text-sm font-bold mb-2">Club
                            budget?</label>
                        <div class="col-sm-10">
                            <input type="number" name="budget" class="w-96 form-control" id="budget"
                                value="{{ $club->budget }}">
                        </div>
                        <label for="Country" class="w-96 block text-gray-700 text-sm font-bold mb-2">Country</label>
                        <div class="col-sm-10">
                            <select class="form-control dynamic" name="country_id" id="{{ $club->id }}"
                                data-dependent='town_name'>
                                <option value="{{ $club->country_id }}">
                                    {{ $club->country->country }} </option>
                                @foreach ($countries as $country)
                                    @if ($country->id === $club->country->id)
                                        @continue
                                    @endif
                                    <option value="{{ $country->id }}">
                                        {{ $country->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="Town" class="w-96 block text-gray-700 text-sm font-bold mb-2">Town</label>
                        <div class="col-sm-10">
                            <select name="town_id" id="{{ $club->id . 'a' }}" class="form-control">
                                <option value="{{ $club->town_id }}">
                                    {{ $club->town->town_name ?? '-' }} </option>

                                @foreach (App\Http\Controllers\ClubController::getTowns($club->country->id) as $town)
                                    @if ($town->id === ($club->town->id ?? null))
                                        @continue
                                    @endif
                                    <option value="{{ $town->id }}">
                                        {{ $town->town_name }}</option>
                                @endforeach
                                @if (($club->town->id ?? null) !== null)
                                    <option value="">
                                        -</option>
                                @endif
                            </select>
                        </div>
                        {{ csrf_field() }}
                        <label for="user_id" class="w-96 block text-gray-700 text-sm font-bold mb-2">Team owner
                            id?</label>
                        <div class="col-sm-10">
                            <input type="number" name="user_id" class="w-96 form-control" id="user_id"
                                value="{{ $club->user_id }}">
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

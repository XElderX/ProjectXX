<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">'
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create custom Player</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="newPlayerForm bg-white shadow-md rounded px-8 pt-4 pb-6 mb-2"
                    action="{{ route('players.store') }}" method="POST">
                    <div class="playerAdd row mb-3">
                        @csrf
                        <div class="fieldDiv">
                        <label for="First name" class="w-96 block text-gray-700 text-sm font-bold mb-2">First
                            Name:</label>
                        <div class="">
                            <input type="text" name="first_name" class="" id="club_name">
                        </div>
                    </div>
                    <div class="fieldDiv">

                        <label for="Last Name" class="w-96 block text-gray-700 text-sm font-bold mb-2">Last
                            Name:</label>
                        <div class="">
                            <input type="text" name="last_name" class="" id="last_name">
                        </div>

                    </div>
                    <div class="fieldDiv">
                        <label for="Age" class="w-96 block text-gray-700 text-sm font-bold mb-2">Age:</label>
                        <div class="">
                            <input type="number" name="age" class=""
                                id="age">
                        </div>
                    </div>
                    <div class="fieldDiv">
                        <label for="height"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Height</label>
                            <div class="">
                                <input type="number" name="height" class="" id="height">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="weight" class="w-96 block text-gray-700 text-sm font-bold mb-2">Weight</label>
                            <div class="">
                                <input type="number" name="weight" class="" id="weight">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="club id"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Club_id</label>
                            <div class="">
                                <input type="number" name="club_id" class="" id="club_id">
                            </div>
                        </div>
                        <div class="fieldDiv">

                            <label for="Country"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Country_id</label>
                            <div class="">
                                <input type="number" name="country_id" class="" id="country_id">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="Position" class="w-96 block text-gray-700 text-sm font-bold mb-2">Favourite
                                Position </label>
                            <div class="">
                                <select name="position" id="" class="form-control">
                                    @foreach ($positions as $position)
                                        <option value="{{ $position }}">
                                            {{ $position }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="value" class="w-96 block text-gray-700 text-sm font-bold mb-2">Player
                                Value</label>
                            <div class="">
                                <input type="number" name="value" class="" id="value">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="salary" class="w-96 block text-gray-700 text-sm font-bold mb-2">Player
                                salary</label>
                            <div class="">
                                <input type="number" name="salary" class="" id="salary">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="bookings"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Bookings</label>
                            <div class="">
                                <input type="number" name="bookings" class="" id="bookings">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="injury days" class="w-96 block text-gray-700 text-sm font-bold mb-2">Injury
                                Days</label>
                            <div class="">
                                <input type="number" name="injury_days" class="" id="injury_days">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="fatigue"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Fatigue</label>
                            <div class="">
                                <input type="number" name="fatique" class="" id="fatigue">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="form" class="w-96 block text-gray-700 text-sm font-bold mb-2">Form</label>
                            <div class="">
                                <input type="text" name="form" class="" id="form">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="gk"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Goalkeeping</label>
                            <div class="">
                                <input type="text" name="gk" class="" id="gk">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="def"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Defending</label>
                            <div class="">
                                <input type="text" name="def" class="" id="def">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="pm"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Playmaking</label>
                            <div class="">
                                <input type="text" name="pm" class="" id="pm">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="pace" class="w-96 block text-gray-700 text-sm font-bold mb-2">Pace</label>
                            <div class="">
                                <input type="text" name="pace" class="" id="pace">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="tech"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Technique</label>
                            <div class="">
                                <input type="text" name="tech" class="" id="tech">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="pass"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Passing</label>
                            <div class="">
                                <input type="text" name="pass" class="" id="pass">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="heading"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Heading</label>
                            <div class="">
                                <input type="text" name="heading" class="" id="heading">
                            </div>
                        </div>
                            <div class="fieldDiv">
                            <label for="str"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Striking</label>
                            <div class="">
                                <input type="text" name="str" class="" id="str">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="stamina"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Stamina</label>
                            <div class="">
                                <input type="text" name="stamina" class="" id="stamina">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="exp"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Experence</label>
                            <div class="">
                                <input type="text" name="exp" class="" id="exp">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="potential"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Potential</label>
                            <div class="">
                                <input type="text" name="potential" class="" id="potential">
                            </div>
                        </div>
                        <div class="fieldDiv">
                            <label for="lead"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Leadership</label>
                            <div class="">
                                <input type="text" name="lead" class="" id="lead">
                            </div>
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

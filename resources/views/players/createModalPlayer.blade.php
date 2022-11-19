<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create customn Player</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="newProductForm bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="{{ route('players.store') }}" method="POST">
                    <div class="newProductDiv row mb-3">
                        @csrf
                        <label for="First name" class="w-96 block text-gray-700 text-sm font-bold mb-2">First
                            Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="first_name" class="w-96 form-control" id="club_name">

                        </div>
                        <label for="Last Name" class="w-96 block text-gray-700 text-sm font-bold mb-2">Last
                            Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="last_name" class="w-96 form-control" id="last_name">
                        </div>
                        <label for="Age" class="w-96 block text-gray-700 text-sm font-bold mb-2">Age:</label>
                        <div class="col-sm-10">
                            <input type="number" name="age" class="w-96 form-control"
                                id="ag>
                        </div>
                        <label for="height"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Height</label>
                            <div class="col-sm-10">
                                <input type="number" name="height" class="w-96 form-control" id="height">
                            </div>
                            <label for="weight" class="w-96 block text-gray-700 text-sm font-bold mb-2">Weight</label>
                            <div class="col-sm-10">
                                <input type="number" name="weight" class="w-96 form-control" id="weight">
                            </div>
                            <label for="club id"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Club_id</label>
                            <div class="col-sm-10">
                                <input type="number" name="club_id" class="w-96 form-control" id="club_id">
                            </div>

                            <label for="Country"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Country_id</label>
                            <div class="col-sm-10">
                                <input type="number" name="country_id" class="w-96 form-control" id="country_id">
                            </div>

                            <label for="Position" class="w-96 block text-gray-700 text-sm font-bold mb-2">Favourite
                                Position </label>
                            <div class="col-sm-10">
                                <select name="position" id="" class="form-control">
                                    @foreach ($positions as $position)
                                        <option value="{{ $position }}">
                                            {{ $position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="value" class="w-96 block text-gray-700 text-sm font-bold mb-2">Player
                                Value</label>
                            <div class="col-sm-10">
                                <input type="number" name="value" class="w-96 form-control" id="value">
                            </div>
                            <label for="salary" class="w-96 block text-gray-700 text-sm font-bold mb-2">Player
                                salary</label>
                            <div class="col-sm-10">
                                <input type="number" name="salary" class="w-96 form-control" id="salary">
                            </div>
                            <label for="bookings"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Bookings</label>
                            <div class="col-sm-10">
                                <input type="number" name="bookings" class="w-96 form-control" id="bookings">
                            </div>
                            <label for="injury days" class="w-96 block text-gray-700 text-sm font-bold mb-2">Injury
                                Days</label>
                            <div class="col-sm-10">
                                <input type="number" name="injury_days" class="w-96 form-control" id="injury_days">
                            </div>
                            <label for="fatigue"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Fatigue</label>
                            <div class="col-sm-10">
                                <input type="number" name="fatique" class="w-96 form-control" id="fatigue">
                            </div>
                            <label for="form" class="w-96 block text-gray-700 text-sm font-bold mb-2">Form</label>
                            <div class="col-sm-10">
                                <input type="text" name="form" class="w-96 form-control" id="form">
                            </div>
                            <label for="gk"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Goalkeeping</label>
                            <div class="col-sm-10">
                                <input type="text" name="gk" class="w-96 form-control" id="gk">
                            </div>
                            <label for="def"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Defending</label>
                            <div class="col-sm-10">
                                <input type="text" name="def" class="w-96 form-control" id="def">
                            </div>
                            <label for="pm"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Playmaking</label>
                            <div class="col-sm-10">
                                <input type="text" name="pm" class="w-96 form-control" id="pm">
                            </div>
                            <label for="pace" class="w-96 block text-gray-700 text-sm font-bold mb-2">Pace</label>
                            <div class="col-sm-10">
                                <input type="text" name="pace" class="w-96 form-control" id="pace">
                            </div>
                            <label for="tech"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Technique</label>
                            <div class="col-sm-10">
                                <input type="text" name="tech" class="w-96 form-control" id="tech">
                            </div>
                            <label for="pass"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Passing</label>
                            <div class="col-sm-10">
                                <input type="text" name="pass" class="w-96 form-control" id="pass">
                            </div>
                            <label for="heading"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Heading</label>
                            <div class="col-sm-10">
                                <input type="text" name="heading" class="w-96 form-control" id="heading">
                            </div>
                            <label for="str"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Striking</label>
                            <div class="col-sm-10">
                                <input type="text" name="str" class="w-96 form-control" id="str">
                            </div>
                            <label for="stamina"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Stamina</label>
                            <div class="col-sm-10">
                                <input type="text" name="stamina" class="w-96 form-control" id="stamina">
                            </div>
                            <label for="exp"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Experence</label>
                            <div class="col-sm-10">
                                <input type="text" name="exp" class="w-96 form-control" id="exp">
                            </div>
                            <label for="potential"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Potential</label>
                            <div class="col-sm-10">
                                <input type="text" name="potential" class="w-96 form-control" id="potential">
                            </div>
                            <label for="lead"
                                class="w-96 block text-gray-700 text-sm font-bold mb-2">Leadership</label>
                            <div class="col-sm-10">
                                <input type="text" name="lead" class="w-96 form-control" id="lead">
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

<!-- Modal -->
<div class="modal fade" id="stats{{ $player->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Player Skills</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="fn">First name: {{$player->first_name}}</div>
                    <div class="ln">Last name: {{$player->last_name}}</div>
                    <div class="age">Age: {{$player->age}}</div>
                    <div class="height">Height: {{$player->height}}</div>
                    <div class="weight">Weight: {{$player->weight}}</div>
                    <div class="club">Club: {{$player->club_id}}</div>
                    <div class="country">Nationality: {{$player->country_id}}</div>
                    <div class="Position">Position: {{$player->position}}</div>
                    <div class="value">Value: {{$player->value}}</div>
                    <div class="salary">Salary: {{$player->salary}}</div>
                    <div class="bookings">Bookings: {{$player->bookings}}</div>
                    <div class="injury">Injury days: {{$player->injury_days}}</div>
                    <div class="fatigue">Fatique: {{$player->fatique}}</div>
                    <div class="form">Form: {{$player->form}}</div>
                    <div class="gk">Goalkeeping: {{$player->gk}}</div>
                    <div class="def">Defending: {{$player->def}} </div>
                    <div class="pm">Playmaking: {{$player->pm}} </div>
                    <div class="pace">Pace: {{$player->pace}}</div>
                    <div class="technique">Technique: {{$player->tech}} </div>
                    <div class="pass">Passing: {{$player->pass}}</div>
                    <div class="Head">Heading: {{$player->heading}}</div>
                    <div class="str">Striker: {{$player->str}}</div>
                    <div class="stamina">Stamina: {{$player->stamina}}</div>
                    <div class="exp">Exp: {{$player->exp}}</div>
                    <div class="pot">Potential: {{$player->potential}} </div>
                    <div class="leadership">Leadership: {{$player->lead}}</div>
                    <div class="created">Created_at: {{$player->created_at}}</div>
                    <div class="upd">Updated_at: {{$player->updated_at}}</div>
                  </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="button" data-bs-dismiss="modal">Close</button>
                <button type="button" class="button"><a
                        href="{{ route('player.delete', [$player->id]) }}">Delete</a></button>
            </div>
        </div>
    </div>
</div>

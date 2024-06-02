<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePlayerRequest;
use App\Http\Requests\PlayerStoreRequest;
use App\Models\Country;
use App\Models\Player;
use App\Services\PlayerServices\GeneratePlayerService;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'players.index',
            [
                'players'   => Player::orderBy('id')->paginate(30),
                'positions' => Player::PLAYER_POSITIONS,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(PlayerStoreRequest $request)
    {
        $player = Player::create($request->all());

        return redirect()->route('players')->with('status_success', 'Player ID-' . $player->id . ' was updated successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(PlayerStoreRequest $request, $id)
    {
        $player = Player::findOrFail($id);
        $player->fill($request->all());
        $player->save();

        return redirect()->route('players')->with('status_success', 'Player ID-' . $player->id . ' was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Player::findOrFail($id);

        $player->delete();
        return redirect()->route('players')->with('status_success', 'Player ID- ' . $player->id . ' was deleted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $player = Player::where('id', '=', $id)->firstOrFail();

        return view('players.show', ['player' => $player]);
    }

    /**
     * Deletes entire table
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function clear($value)
    {
        if ($value == 'all') {
            Player::truncate(); // Delete all records from the "players" table
            return redirect()->back()->with('status_success', 'All players have been deleted.');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamPlayersList(Request $request, int $id, ?string $field = null)
    {
        $sortDirection = $request->query('sort', 'desc');

        if (isset($field)) {
            $players = Player::where('club_id', $id)->orderBy($field, $sortDirection)->get();
        } else {
            $players = Player::where('club_id', $id)->get();
        }
        return view(
            'players.teamPlayers',
            [
                'players'        => $players,
                'positions'      => Player::PLAYER_POSITIONS,
                'club_id'        => $id,
                'field'          => $field,
                'sort'           => $sortDirection
            ]
        );
    }

    /**
     * Dismiss player from the team squad.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function fire($id)
    {
        $player = Player::findOrFail($id);
        $teamId = $player->club_id;
        $player->club_id = null;
        $player->save();
        return redirect()->route('teamPlayers', [$teamId])->with('status_success', 'Player ID- ' . $player->id . ' was dismissed.');
    }
}

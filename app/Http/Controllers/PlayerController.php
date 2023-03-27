<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePlayerRequest;
use App\Http\Requests\PlayerStoreRequest;
use App\Models\Country;
use App\Models\Player;
use App\Services\PlayerServices\GeneratePlayerService;

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
                'players'   => Player::orderBy('id')->paginate(10),
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
}

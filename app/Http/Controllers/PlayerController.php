<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Models\Club;
use App\Models\Player;
use App\Providers\RouteServiceProvider;
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
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Player::findOrFail($id);

        $player->delete();
        return redirect()->route('players')->with('status_success', 'Player ID- ' . $player->id . ' was deleted.');
    }
}

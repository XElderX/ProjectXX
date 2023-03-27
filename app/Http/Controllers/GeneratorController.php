<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePlayerRequest;
use App\Http\Requests\GenerateTeamRequest;
use App\Models\Country;
use App\Models\Player;
use App\Models\Town;
use App\Services\PlayerServices\GeneratePlayerService;
use App\Services\TeamServices\GenerateTeamService;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    public function index()
    {
        return view(
            'generator.index',
            [
                'positions' => Player::PLAYER_POSITIONS,
                'countries' => Country::get(),
                'towns'     => Town::get()
            ]
        );
    }

    public function generatePlayer(GeneratePlayerRequest $request, GeneratePlayerService $generatePlayerService)
    {
        if ($player = $generatePlayerService->processRequest($request)) {
            $player->save();
            $id = $player->id;

            return redirect()->route('genPlayer', $id)->with('status_success', 'Player ID-' . $player->id . ' was generated successfully.');
            // return $this->success('Success');

        }
        return $this->error('Failed to generate a player.');
    }

    public function generateTeam(GenerateTeamRequest $request, GenerateTeamService $generateTeamService)
    {
        if ($team = $generateTeamService->processRequest($request)) {
            $id = $team->id;

            return redirect()->route('genTeam', $id)->with('status_success', 'Team ID-' . $team->id . ' was generated successfully.');
            // return $this->success('Success');

        }
        return $this->error('Failed to generate a Team.');
    }

    public static function getTowns($countryId)
    {
        $towns = Town::where('country_id', $countryId)->get();
        return $towns;
    }
}

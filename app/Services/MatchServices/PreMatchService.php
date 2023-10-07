<?php

namespace App\Services\MatchServices;

use App\Models\FriendlyInvitation;
use App\Models\MatchSchedule;
use App\Models\Player;

class PreMatchService extends MatchProposialService
{
    protected function matchSchedule(FriendlyInvitation $invitation)
    {
        $this->match->fillMatchData($invitation);
        $this->cancelRemainingInvitations($invitation);
        $this->match->save();
    }

    public function setTacticAndLineup($id, $request)
    {
        $this->match = MatchSchedule::findOrfail($id);

        if ($this->match->home_team_id === auth()->user()->club_id) {
            $lineup = $this->lineupResolve(($request));
            $tactic = $this->match->countDEF . '-' . $this->match->countMID . '-' . $this->match->countFOW;
            $this->match->setTactic($tactic);

            $collection = collect($lineup);
            $jsonObject = $collection->toJson();
            $this->match->setLineup($jsonObject);
        }

        if ($this->match->away_team_id === auth()->user()->club_id) {
            $lineup = $this->lineupResolve(($request));
            $tactic = $this->match->countDEF . '-' . $this->match->countMID . '-' . $this->match->countFOW;
            $this->match->setTactic($tactic, 'away');
            $collection = collect($lineup);
            $jsonObject = $collection->toJson();
            
            $this->match->setLineup($jsonObject, 'away');
        }
        unset($this->match->countGK, $this->match->countDEF, $this->match->countMID, $this->match->countFOW);
        $this->match->save();
        
        return $this->match;
    }

    private function lineupResolve($request)
    {
        $players = $request->players;
        $positions = $request->positions;

        $lineup = [];
        for ($i = 0; $i < 11; $i++) {
            if ($players[$i] == null) {
                continue;
            }
            $playerData = Player::findOrFail($players[$i]);
            if ($playerData->club_id !== auth()->user()->club_id) {
                throw new \Exception('error occured!! player is not this team player!! ');
            }
            $data = ['pos_no' => $i, 'player_id' => $players[$i], 'player' => $playerData, 'position' => $positions[$i], 'booked' => false, 'goals' => 0, 'assists' => 0, 'injury' => null];
            array_push($lineup, $data);
        }

        return $this->assignUnesignedPlayers($lineup);
    }

    private function assignUnesignedPlayers($lineup)
    {
        // Initialize count variables for each position
        $this->match->countGK = 0;
        $this->match->countDEF = 0;
        $this->match->countMID = 0;
        $this->match->countFOW = 0;

        // Count the number of players for each position
        foreach ($lineup as $player) {
            $position = $player['position'];
            switch ($position) {
                case 'GK':
                    $this->match->countGK++;
                    break;
                case 'DEF':
                    $this->match->countDEF++;
                    break;
                case 'MID':
                    $this->match->countMID++;
                    break;
                case 'FOW':
                    $this->match->countFOW++;
                    break;
            }
        }

        for ($i = 0; $i < count($lineup); $i++) {
            if ($lineup[$i]['position'] == null) {
                // Assign a position to a player
                $playerToAssignPosition = $lineup[$i]; // Select the player you want to assign a position to

                // Check the positions and assign a position with the lowest count
                if ($this->match->countGK < 1) {
                    $playerToAssignPosition['position'] = 'GK';
                    $this->match->countGK++;
                } elseif ($this->match->countDEF < $this->match->countMID && $this->match->countDEF < $this->match->countFOW) {
                    $playerToAssignPosition['position'] = 'DEF';
                    $this->match->countDEF++;
                } elseif ($this->match->countMID < $this->match->countFOW) {
                    $playerToAssignPosition['position'] = 'MID';
                    $this->match->countMID++;
                } else {
                    $playerToAssignPosition['position'] = 'FOW';
                    $this->match->countFOW++;
                }
                $lineup[$i] = $playerToAssignPosition;
            }
        }
        return $lineup;
    }
}

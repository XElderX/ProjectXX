<?php

namespace App\Services\MatchServices\MatchMechanics;

use App\Models\MatchSchedule;
use App\Models\Player;
use App\Services\MatchServices\BaseMatchEvents;
use App\Services\MatchServices\EventsStringTemplates\EventsTemplates;
use App\Services\MatchServices\MatchService;
use Exception;
use Illuminate\Support\Str;

class BaseMatchMechanics
{
    protected function lastManFoul(MatchService $base, string $activeTeam, string $eventDesc, int $minute)
    {
        $situationId = Str::random(4);
        $baseMatchEvents = new BaseMatchEvents;

        $squad = $this->selectOppositeTeamPlayers($activeTeam, $base);
        $player = $this->selectPlayers($squad);
        $model = $this->getPlayerModel($base->match, $activeTeam == BaseMatchEvents::HOME_TEAM ? BaseMatchEvents::AWAY_TEAM : BaseMatchEvents::HOME_TEAM, $player);

        if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
            $base->awayBooked[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $model->id, 'full_name' => $model->full_name, 'card' => 'red'];
            // $base->homeAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
        }
        if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
            $base->homeBooked[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $model->id, 'full_name' => $model->full_name, 'card' => 'red'];
            // $base->awayAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
        }
        
        $eventDesc .= $baseMatchEvents->reportEvent(
            $minute,
            eventName: EventsTemplates::TYPE_LASTFOUL,
            teamName: $activeTeam == BaseMatchEvents::HOME_TEAM
                ? $base->match->awayTeam->club_name
                : $base->match->homeTeam->club_name,
            player: $model,
            position: $player->position
        );
        $this->dismisalPlayer($base, $activeTeam, $player); //TODO If dismissed player is Goakeeper make  one of player from field to goal; also later if substitutes available substitute field player for goalkeeper
        return $eventDesc;
    }

    protected function setPiece($base, string $activeTeam, string $eventDesc, int $minute): string
    {
        $decision = rand(1, 10);
        if ($decision <= 3) {
            $eventDesc = $this->penalty($base, $activeTeam, $eventDesc, $minute);
        } else {
            $eventDesc = $this->freeKick($base, $activeTeam, $eventDesc, $minute);
        }

        return $eventDesc;
    }

    public function penalty($base, string $activeTeam, string $eventDesc, int $minute)
    {
        $situationId = Str::random(4);
        $baseMatchEvents = new BaseMatchEvents;
        // Get the team taking the penalty and the opposing team
        $penaltyTeam = $this->takingTeamPlayers($activeTeam, $base);
        $opposingTeam = $this->selectOppositeTeamPlayers($activeTeam, $base);
        $penaltyTaker = $this->selectTaker($penaltyTeam, 'penalty');
        $goalkeeper = $this->selectGoalkeeper($base, $activeTeam, $opposingTeam);
        $eventDesc = " Teisejas skyre 11 metru zyma, tad bus musamas baudinys!!! \n";
        $eventDesc = " $penaltyTaker->first_name $penaltyTaker->last_name stoja prie 11 metru atzymos, ir bandys nuginkluoti priesininku vartininka $goalkeeper->first_name  $goalkeeper->last_name \n";
        // dd($goalkeeper);
        // Determine the penalty outcome based on skills and randomness
        $isGoalScored = $this->simulateSetPieceOutcome('penalty', $penaltyTaker, $goalkeeper, $activeTeam);

        // Update the match event description
        if ($isGoalScored) {
            // Update the score or other relevant statistics
            $eventDesc .= $baseMatchEvents->reportEvent(
                $minute,
                eventName: EventsTemplates::TYPE_PENALTYSCORE,
                teamName: $activeTeam == BaseMatchEvents::HOME_TEAM
                ? $base->match->homeTeam->club_name
                : $base->match->awayTeam->club_name,
                player: $penaltyTaker
            );
            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $base->homeChance++;
                $base->homeTarget++;
                $base->homeScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $penaltyTaker->id, 'full_name' => $penaltyTaker->full_name];
                // $base->homeAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
            }
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $base->awayChance++;
                $base->awayTarget++;
                $base->awayScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $penaltyTaker->id, 'full_name' => $penaltyTaker->full_name];
                // $base->awayAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
            }
        } else {
            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $base->homeChance++;
                $base->homeTarget++;
                $base->awayKeeperSaves++;
            }
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $base->awayChance++;
                $base->awayTarget++;
                $base->homeKeeperSaves++;
            }
            $eventDesc .= $baseMatchEvents->reportEvent(
                $minute,
                eventName: EventsTemplates::TYPE_PENALTYSAVE,
                teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? $base->match->awayTeam->club_name
                    : $base->match->homeTeam->club_name,
                player: $goalkeeper
            );
        }
        return $eventDesc;
    }

    public function freeKick(MatchService $base, string $activeTeam, string $eventDesc, int $minute)
    {
        $situationId = Str::random(4);
        $baseMatchEvents = new BaseMatchEvents;
        // Get the team taking the penalty and the opposing team
        $penaltyTeam = $this->takingTeamPlayers($activeTeam, $base);
        $opposingTeam = $this->selectOppositeTeamPlayers($activeTeam, $base);
        $penaltyTaker = $this->selectTaker($penaltyTeam, 'freeKick');
        $goalkeeper = $this->selectGoalkeeper($base, $activeTeam, $opposingTeam);
        $eventDesc = " Teisejas paskyre laisva smugi i vartus \n";
        $eventDesc = " $penaltyTaker->first_name $penaltyTaker->last_name bandys pramusti priesininku sienele, bei nuginkluoti priesininku vartininka $goalkeeper->first_name  $goalkeeper->last_name \n";
        // dd($goalkeeper);
        // Determine the penalty outcome based on skills and randomness
        $isGoalScored = $this->simulateSetPieceOutcome('freeKick', $penaltyTaker, $goalkeeper, $activeTeam);

        // Update the match event description
        if ($isGoalScored) {

            // Update the score or other relevant statistics
            $eventDesc .= $baseMatchEvents->reportEvent(
                $minute,
                eventName: EventsTemplates::TYPE_FKSCORE,
                teamName: $activeTeam == BaseMatchEvents::HOME_TEAM
                    ? $base->match->homeTeam->club_name
                    : $base->match->awayTeam->club_name,
                player: $penaltyTaker
            );
            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $base->homeChance++;
                $base->homeTarget++;
                $base->homeScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $penaltyTaker->id, 'full_name' => $penaltyTaker->full_name];
                // $base->homeAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
            }
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $base->awayChance++;
                $base->awayTarget++;
                $base->awayScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $penaltyTaker->id, 'full_name' => $penaltyTaker->full_name];
                // $base->awayAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
            }
        } else {
            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $base->homeChance++;
                $base->homeTarget++;
                $base->awayKeeperSaves++;
            }
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $base->awayChance++;
                $base->awayTarget++;
                $base->homeKeeperSaves++;
            }
            $eventDesc .= $baseMatchEvents->reportEvent(
                $minute,
                eventName: EventsTemplates::TYPE_FKSAVE,
                teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? $base->match->awayTeam->club_name
                    : $base->match->homeTeam->club_name,
                player: $goalkeeper
            );
        }

        return $eventDesc;
    }

    public function selectGoalkeeper($base, string $activeTeam, array $players)
    {
        foreach ($players as $player) {
            if ($player->position === 'GK') {
              
                return  $this->getPlayerModel($base->match, $activeTeam == BaseMatchEvents::HOME_TEAM ? BaseMatchEvents::AWAY_TEAM : BaseMatchEvents::HOME_TEAM, $player); // Return the first goalkeeper found
            }
        }
        return null; // Return null if no goalkeeper is found
    }

    private function selectTaker(array $squad, string $role)
    {
        $bestPlayer = null;
        $bestValue = -1; // Initialize with a value lower than the possible player values

        foreach ($squad as $player) {
            // Calculate the player's value based on the given formula
            if ($role === 'penalty') {
                $playerValue = $player->str * 0.5 + $player->tech * 0.2;
            }
            if ($role === 'freeKick') {
                $playerValue = $player->str * 0.3 + $player->tech * 0.2 + $player->pass * 0.2;
            }

            // Check if the current player has a higher value than the best player found so far
            if ($playerValue > $bestValue) {
                $bestPlayer = $player;
                $bestValue = $playerValue;
            }
        }

        return $bestPlayer;
    }

    private function simulateSetPieceOutcome(string $type, Player $taker, Player $goalkeeper, string $activeTeam)
    {
        if ($type === 'penalty') {
            $takerSkill = ($taker->str * 0.5 + $taker->tech * 0.2);
            $keeperSkill = ($goalkeeper->gk * 0.7 + $goalkeeper->pace * 0.3);
            $probability = $takerSkill / ($takerSkill + $keeperSkill);
        } else if ($type === 'freeKick') {
            $bonus = $activeTeam == BaseMatchEvents::HOME_TEAM ? $this->awayDefending : $this->homeDefending;
            $takerSkill = ($taker->str * 0.5 + $taker->tech * 0.2 + $taker->pass * 0.3);
            $keeperSkill = ($goalkeeper->gk * 0.6 + $goalkeeper->pace * 0.4) * 2 + $bonus / 11;
            $probability = $takerSkill / ($takerSkill + $keeperSkill);
        }

        // Use a random value to determine the outcome
        $randomValue = mt_rand(0, 100) / 100; // Random value between 0 and 1

        // Return true for a scored penalty, false for a saved penalty
        return ($randomValue <= $probability);
    }

    public function getPlayerModel(MatchSchedule $match, string $activeTeam, object $playerModel)
    {
        $teamId = ($activeTeam == BaseMatchEvents::HOME_TEAM) ? $match->homeTeam->id : $match->awayTeam->id;
    
// dd($team);

        // $team->find
        // foreach ($team->player as $player) {
        //     dd($player);
        //     if ($player->id === $playerModel->player_id) {
        //         return $player;
        //     }
        // }
        echo('>>>>>>'.$playerModel->player_id.'<<<<<<');
        return Player::where('club_id', $teamId)
    ->where('id', $playerModel->player_id)
    ->get()->first();
    }

    private function takingTeamPlayers(string $activeTeam, MatchService $base)
    {
        $takingLineupPlayers = [];
        $players = $activeTeam == BaseMatchEvents::HOME_TEAM ? json_decode($base->match->home_lineup) : json_decode($base->match->away_lineup);
        foreach ($players as $player) {
            $takingLineupPlayers[] = Player::find($player->player_id);
        }
        return $takingLineupPlayers;
    }

    private function selectOppositeTeamPlayers(string $activeTeam, $base)
    {
        return $activeTeam == BaseMatchEvents::HOME_TEAM ? json_decode($base->match->away_lineup) : json_decode($base->match->home_lineup);
    }

    private function opponentTeamPlayers(bool $isHome, $base)
    {
        $oppositeLineupPlayers = [];
        $players = $isHome ? json_decode($base->match->away_lineup) : json_decode($base->match->home_lineup);
        foreach ($players as $player) {
            $oppositeLineupPlayers[] = Player::find($player->player_id);
        }
        return $oppositeLineupPlayers;
    } //finish

    private function selectPlayers($players): object
    {
        $scorerRand = rand(1, 20);
        $positions = [
            9 => "DEF",
            // 14 => "GK",
            18 => "MID",
            20 => "FOW",
        ];

        $position = "FOW"; // Default position
        foreach ($positions as $threshold => $pos) {
            if ($scorerRand <= $threshold) {
                $position = $pos;
                break;
            }
        }

        $filteredPlayers = array_filter($players, function ($player) use ($position) {
            return $player->position === $position;
        });

        $filteredPlayers = array_values($filteredPlayers);
        $randomIndex = array_rand($filteredPlayers);

        return $filteredPlayers[$randomIndex];
    }

    public function dismisalPlayer(MatchService $base, string $activeTeam, object $player): void
    {
        if (!($player instanceof Player)) {
          
            $player = Player::find($player->player_id);
        }
        try {
            $situationId = Str::random(4);
          
            $lineup = $activeTeam == BaseMatchEvents::HOME_TEAM ? $base->awayLineup : $base->homeLineup;
    

            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $lineup = $base->awayLineup;

                $base->awayDismissed[] = ['situation_id' => $situationId, 'min' => $base->minute, 'player_id' => $player->id, 'full_name' => $player->full_name];
            }
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $lineup = $base->homeLineup;
                $base->homeDismissed[] = ['situation_id' => $situationId, 'min' => $base->minute, 'player_id' => $player->id, 'full_name' => $player?->full_name];
            }
    
            // Assuming $base->homeLineup is your array and $player is the player to remove
            $playerIdToRemove = $player->player_id;
    
            // Use array_filter to create a new array without the matching player
            $lineup = array_filter($lineup, function ($item) use ($playerIdToRemove) {
                return $item->player_id !== $playerIdToRemove;
            });
            // Assign the modified lineup back to the correct property
            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $base->awayLineup = $lineup;
                echo '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@AWAY DISMISSED@@@@@@@@@@@@@@@@@@@@@@@';
            } else {
                $base->homeLineup = $lineup;
                echo '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@HOME DISMISSED@@@@@@@@@@@@@@@@@@@@@@@';
            }
    
            $base->isDismissed = true;
        } catch (Exception $e) {
            // Handle the exception here (e.g., log or throw a new exception)
            // You can add custom exception handling logic as needed.
            dd('An exception occurred: ' . $e->getMessage());
        }
    }

    public function isAdvance(float $strength, float $oppStrength, string $type = 'advance', ?int $stage = 1): bool
    {
        if ($type === 'advance') {
            $takerSkill = $strength;
            $defSkill = $oppStrength;
            $baseProbability = $takerSkill / ($takerSkill + $defSkill);
            // $probability = $baseProbability - ($baseProbability * (0.15 * ($stage)));

            $probability = $this->calculateProbability($stage, $takerSkill, $defSkill, $baseProbability);

            echo ("\n propability: " .$probability . "\n");
        } else if ($type === 'simple') { //TODO make attacker height influence
            $takerSkill = $strength;
            $keeperSkill = $oppStrength;
            $baseProbability = $takerSkill / ($takerSkill + $keeperSkill);
            $probability = $this->calculateProbability(1, $takerSkill, $keeperSkill, $baseProbability);
        } else if ($type === 'header') {
            $takerSkill = $strength;
            $keeperSkill = $oppStrength;
            $baseProbability = $takerSkill / ($takerSkill + $keeperSkill);
            $probability = $this->calculateProbability(1, $takerSkill, $keeperSkill, $baseProbability);
        } //TODO make gk height influnced in headers
        $randomValue = mt_rand(0, 100) / 100; // Random value between 0 and 1

        return ($randomValue <= $probability);
    }

    //recursive propability 
    function calculateProbability(int $stage, float $takerSkill, float $defSkill, float $baseProbability) {
        if ($stage <= 0) {
            return $baseProbability;
        }
    
        $firstReduction = $baseProbability - ($baseProbability * (0.15 * $stage));
        
        // Recursive call with stage reduced by 1
        return $this->calculateProbability($stage - 1, $takerSkill, $defSkill, $firstReduction);
    }
}

<?php

namespace App\Services\MatchServices\MatchMechanics;

use App\Services\MatchServices\BaseMatchEvents;
use App\Services\MatchServices\EventsStringTemplates\EventsTemplates;
use App\Services\MatchServices\MatchService;
use Illuminate\Support\Str;

class MatchMechanics extends BaseMatchMechanics
{
    public $homeDefending;
    public $awayDefending;

    public function eventPhases(array $marks) //determines possible event turns count 
    {
        $ratio = $marks[0] / $marks[1];

        return match (true) {
            $ratio > 2 => mt_rand(2, 3),
            $ratio > 1 => mt_rand(1, 3),
            $ratio > 0.5 => mt_rand(1, 2),
            default => mt_rand(1, 3),
        };
    }

    public function quickAttack(MatchService $base, int $minute, array $players, string $activeTeam, string $eventDesc)
    {
        $situationId = Str::random(4);
        $baseMatchEvents = new BaseMatchEvents;
        $scorer = $baseMatchEvents->playerToScore($players);
        $selectedPlayerModel = $this->getPlayerModel($base->match, $activeTeam, $scorer);
        echo('xXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
        $strike = $baseMatchEvents->calculateStrike($selectedPlayerModel, $activeTeam == BaseMatchEvents::HOME_TEAM ? $base->homeStriking : $base->awayStriking);
        $scoreChance = $baseMatchEvents->chanceToScore();
        $saveChance = $baseMatchEvents->chanceToSave($strike, $activeTeam == BaseMatchEvents::HOME_TEAM ? $base->homeGoalkeeping : $base->awayGoalkeeping);
        $eventDesc .= $baseMatchEvents->reportEvent($minute, EventsTemplates::TYPE_OPPORTUNITY, $activeTeam == BaseMatchEvents::HOME_TEAM ? $base->match->homeTeam->club_name : $base->match->awayTeam->club_name, $selectedPlayerModel);

        ($activeTeam == BaseMatchEvents::HOME_TEAM) ? $base->homeChance++ : $base->awayChance++;
        // $eventDesc = $this->lastManFoul($base, $isHome, $eventDesc, $minute);//DELETE
        // $eventDesc = $this->setPiece($base, $isHome, $eventDesc, $minute);
        if ($scoreChance >= $saveChance) {
            if (mt_rand(0, 20) === 0) {
                $eventDesc = $this->lastManFoul($base, $activeTeam, $eventDesc, $minute);
                $eventDesc = $this->setPiece($base, $activeTeam, $eventDesc, $minute);
            } else {
                if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                    $base->homeTarget++;
                    $base->homeScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $selectedPlayerModel->id, 'full_name' => $selectedPlayerModel->full_name];
                    // $base->homeAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
                }
                if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                    $base->awayTarget++;
                    $base->awayScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $selectedPlayerModel->id, 'full_name' => $selectedPlayerModel->full_name];
                    // $base->awayAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
                }

                $eventDesc .= $baseMatchEvents->reportEvent($minute, EventsTemplates::TYPE_SCORE, $activeTeam == BaseMatchEvents::HOME_TEAM ? $base->match->homeTeam->club_name : $base->match->awayTeam->club_name, $selectedPlayerModel);
                echo "Goal at minute $minute! \n";
            }
        } else {
            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $base->homeTarget++;
                $base->awayKeeperSaves++;
            }
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $base->awayTarget++;
                $base->homeKeeperSaves++;
            }
            $eventDesc .= $baseMatchEvents->reportEvent($minute, EventsTemplates::TYPE_SAVEGK, $activeTeam == BaseMatchEvents::HOME_TEAM ? $base->match->homeTeam->club_name : $base->match->awayTeam->club_name, $selectedPlayerModel);
            echo " Goalkeeper made save at minute $minute!\n";
        }
        $eventDesc .= $baseMatchEvents->resultEvent($minute, $base->homeGoals, $base->awayGoals, $base->match);
        // dd($base->match->homeTeam->player);

        echo "at minute $minute! Result is Home: $base->homeGoals - Away: $base->awayGoals\n";
        return $eventDesc . "\n";
    }

    public function foulScenario(string $activeTeam, float $attackerStrength, object $defender, int $minute, MatchService $base, int $baseFoul = 30)
    {
        $situationId = Str::random(4);
        $baseMatchEvents = new BaseMatchEvents;
        $selectedPlayerModel = $this->getPlayerModel($base->match, $activeTeam === BaseMatchEvents::HOME_TEAM ? BaseMatchEvents::AWAY_TEAM : BaseMatchEvents::HOME_TEAM, $defender);
        if ($selectedPlayerModel === null) {
            
        }
        $defenderStrength = $baseMatchEvents->calculateDefence($selectedPlayerModel, $activeTeam == BaseMatchEvents::HOME_TEAM ? $base->awayDefending : $base->homeDefending);
        //    dd($attackerStrength);
        // Calculate the likelihood of a foul
        $likelihoodOfFoul = (($baseFoul + $defenderStrength) - $attackerStrength);
        
        // Generate a random number between 0 and 100
        $randomNumber = mt_rand(0, 100);
        
        // Check if a foul occurs based on the likelihood
        
        $isSecondYellow = false;
        if ($randomNumber <= $likelihoodOfFoul) {
            if ($defender->booked) {
                echo('xXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
                $isSecondYellow = true;

                $this->dismisalPlayer($base, $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? BaseMatchEvents::HOME_TEAM
                    : BaseMatchEvents::AWAY_TEAM, $defender);
                if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                    $base->awayBooked[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $selectedPlayerModel->id, 'full_name' => $selectedPlayerModel->full_name, 'card' => '2ndYellow'];

                    // $base->homeAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
                }
                if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                    $base->homeBooked[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $selectedPlayerModel->id, 'full_name' => $selectedPlayerModel->full_name, 'card' => '2ndYellow'];
                    // $base->awayAssisters[] = ['situation_id' => $situationId, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
                }
                echo "2nd yellow card!!!!!!!!!!!\n";
            } else {
                $defender->booked = true;
                if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                    $base->awayBooked[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $selectedPlayerModel->id, 'full_name' => $selectedPlayerModel->full_name, 'card' => 'Yellow'];

                    $lineup = $base->awayLineup;
                    foreach ($lineup as &$player) {
                        echo('Loop - Player ID: ' . $player->player_id . ' Defender ID: ' . $defender->player_id . "\n");
                        if ($player->player_id === $defender->player_id) {
                            echo('yyyy');
                            $player->booked = true;
                        }
                    }
                    $base->awayLineup = $lineup;
                    echo '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@AWAY BOOKED@@@@@@@@@@@@@@@@@@@@@@@'. $defender->player_id;
                    
                } else if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                    $base->homeBooked[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $selectedPlayerModel->id, 'full_name' => $selectedPlayerModel->full_name, 'card' => 'Yellow'];
                    $lineup = $base->homeLineup;

                    foreach ($lineup as &$player) {
                        echo('Loop - Player ID: ' . $player->player_id . ' Defender ID: ' . $defender->player_id . "\n");
                        if ($player->player_id === $defender->player_id) {
                            echo('xxxx');
                            $player->booked = true;
                        }
                    }
                    $base->homeLineup = $lineup;
                
                    echo '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@HOME BOOKED @@@@@@@@@@@@@@@@@@@@@@@' . $defender->player_id;
                }
            }
            $base->isWarned = true;

            echo "YYellow card!!!!!!!!!!!\n";

            return $baseMatchEvents->reportEvent(
                $minute,
                eventName: $isSecondYellow ? EventsTemplates::TYPE_NDYELLOW : EventsTemplates::TYPE_YELLOW,
                teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? $base->match->awayTeam->club_name
                    : $base->match->homeTeam->club_name,
                player: $selectedPlayerModel,
                position: $defender->position
            );
        } else {
            return false;
        } //TODO FINISH
        //give player yellow or 2nd yellow
        //check if player have yellow
        //if yes dissmis that player
    }

    public function shootingStage(object $shooter, object $oppGoalkeeper, object $assister, string $scoreType, string $outcome, string $activeTeam, int $minute, MatchService $base)
    {
        $situationId = Str::random(4);
        $baseMatchEvents = new BaseMatchEvents;
        $luck1 = mt_rand(0, 50) / 10;
        $luck2 = mt_rand(0, 30) / 10;
        $luck3 = mt_rand(0, 50) / 10;

        if ($scoreType === 'simple') {
            $forwardStrength = $luck1 + ($shooter->str * 0.35) + ($shooter->tech * 0.25)  + ($shooter->pace * 0.25) + ($shooter->exp * 0.15) * (1.5 + 0.5 * ($shooter->form - 5));
            $assisterBonus = $luck3 + ($assister->pass * 0.35) + ($assister->tech * 0.05)  + ($assister->pace * 0.05) + ($assister->exp * 0.05) * (1.5 + 0.5 * ($assister->form - 5));
            $oppGoalkeeperStrength = $luck2 + (($oppGoalkeeper->gk * 0.45) + ($oppGoalkeeper->pace * 0.3)  + ($oppGoalkeeper->def * 0.05) + ($oppGoalkeeper->lead * 0.05) + ($oppGoalkeeper->exp * 0.15)) * (1.5 + 0.5 * ($oppGoalkeeper->form - 5));
        } else if ($scoreType === 'header') {
            $forwardStrength = $luck1 + ($shooter->str * 0.25) + ($shooter->header * 0.35) + ($shooter->tech * 0.1)  + ($shooter->pace * 0.15) + ($shooter->exp * 0.15) * (1.5 + 0.5 * ($shooter->form - 5));
            $assisterBonus = $luck3 + ($assister->pass * 0.35) + ($assister->tech * 0.05)  + ($assister->pace * 0.05) + ($assister->exp * 0.05) * (1.5 + 0.5 * ($assister->form - 5));
            $oppGoalkeeperStrength = $luck2 + (($oppGoalkeeper->gk * 0.4) + ($oppGoalkeeper->pace * 0.45) + ($oppGoalkeeper->exp * 0.15)) * (1.5 + 0.5 * ($oppGoalkeeper->form - 5));
        }
        // $nerfBonus = $outcome !== 'FOW' ? rand(13, 20) / 10 : 1;
        $totalStrength = ($forwardStrength) + $assisterBonus;
        $totalOppStrength = $oppGoalkeeperStrength;

        //TODO FINISH DO THIS SHOOTING
        // dd($shooter->full_name);
        if ($this->isAdvance($totalStrength, $totalOppStrength, $scoreType)) {

            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $base->homeChance++;
                $base->homeTarget++;
                $base->homeGoals++;
                $base->homeScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $shooter->id, 'full_name' => $shooter->full_name];
                $base->awayAssisters[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
            }
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $base->awayChance++;
                $base->awayTarget++;
                $base->awayGoals++;
                $base->awayScorers[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $shooter->id, 'full_name' => $shooter->full_name];
                $base->awayAssisters[] = ['situation_id' => $situationId, 'min' => $minute, 'player_id' => $assister->id, 'full_name' => $assister->full_name];
            }

            $outcome = $baseMatchEvents->reportEvent(
                $minute,
                eventName: $scoreType === 'simple' ? EventsTemplates::TYPE_SIMPLEGOAL : EventsTemplates::TYPE_HEADGOAL,
                teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? $base->match->awayTeam->club_name
                    : $base->match->homeTeam->club_name,
                player: $shooter,
                position: $shooter->position,
                opponent: $oppGoalkeeper,
                subPlayer: $assister
            );
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

            $outcome = $baseMatchEvents->reportEvent(
                $minute,
                eventName: $scoreType === 'simple' ? EventsTemplates::TYPE_SIMPLEGKSAVE : EventsTemplates::TYPE_HEADGKSAVE,
                teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? $base->match->awayTeam->club_name
                    : $base->match->homeTeam->club_name,
                player: $shooter,
                position: $shooter->position,
                opponent: $oppGoalkeeper,
                subPlayer: $assister
            );
        }

        return $outcome;
    }

    function Chance($chance, $universe = 100)
    {
        $chance = abs(intval($chance));
        $universe = abs(intval($universe));

        if (mt_rand(1, $universe) <= $chance) {
            return true;
        }

        return false;
    }
}

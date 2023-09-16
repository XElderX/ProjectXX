<?php

namespace App\Services\MatchServices\MatchMechanics;

use App\Services\MatchServices\EventsStringTemplates\EventsTemplates;

class MatchMechanics extends BaseMatchMechanics
{

    public $homeDefending;
    public $awayDefending;

    public function eventPhases(array $marks) //determines possible event turns count 
    {
        $ratio = $marks[0] / $marks[1];

        return match (true) {
            $ratio > 2 => rand(1, 6),
            $ratio > 1 => rand(1, 4),
            $ratio > 0.5 => rand(1, 3),
            default => rand(1, 2),
        };
    }

    public function quickAttack($base, $minute, $players, bool $isHome, $eventDesc)
    {
        $scorer = $base->playerToScore($players);

        $selectedPlayerModel = $this->getPlayerModel($base->match, $isHome, $scorer);
        $strike = $base->calculateStrike($selectedPlayerModel, $isHome ? $base->homeStriking : $base->awayStriking);
        $scoreChance = $base->chanceToScore();
        $saveChance = $base->chanceToSave($strike, $isHome ? $base->homeGoalkeeping : $base->awayGoalkeeping);
        $eventDesc .= $base->reportEvent($minute, EventsTemplates::TYPE_OPPORTUNITY, $isHome ? $base->match->homeTeam->club_name : $base->match->awayTeam->club_name, $selectedPlayerModel);
        
        ($isHome) ? $base->homeChance++ : $base->awayChance++;
        // $eventDesc = $this->lastManFoul($base, $isHome, $eventDesc, $minute);//DELETE
        // $eventDesc = $this->setPiece($base, $isHome, $eventDesc, $minute);
        if ($scoreChance >= $saveChance) {
            if (rand(0, 20) === 0) {
                $eventDesc = $this->lastManFoul($base, $isHome, $eventDesc, $minute);
                $eventDesc = $this->setPiece($base, $isHome, $eventDesc, $minute);
            } else {
                ($isHome) ? $base->homeTarget++ : $base->awayTarget++;
                ($isHome) ? $base->homeGoals++ : $base->awayGoals++;
                $eventDesc .= $base->reportEvent($minute, EventsTemplates::TYPE_SCORE, $isHome ? $base->match->homeTeam->club_name : $base->match->awayTeam->club_name, $selectedPlayerModel);
                echo "Goal at minute $minute! Home Team scores: $base->homeGoals\n";
            }
        } else {
            $eventDesc .= $base->reportEvent($minute, EventsTemplates::TYPE_SAVEGK, $isHome ? $base->match->homeTeam->club_name : $base->match->awayTeam->club_name, $selectedPlayerModel);
            echo "Away Goalkeeper made save at minute $minute!\n";
        }
        $eventDesc .= $base->resultEvent($minute, $base->homeGoals, $base->awayGoals, $base->match);
        // dd($base->match->homeTeam->player);

        echo "at minute $minute! Result is Home: $base->homeGoals - Away: $base->awayGoals\n";
        return $eventDesc . "\n";
    }

    public function foulScenario()
    {
    }
}

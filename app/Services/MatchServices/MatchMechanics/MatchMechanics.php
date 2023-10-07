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

    public function foulScenario(bool $isHome, float $attackerStrength, object $defender, $minute, $base)
    {
        $selectedPlayerModel = $this->getPlayerModel($base->match, !$isHome, $defender);
    // dd($defender);
        $defenderStrength = $base->calculateDefence($selectedPlayerModel, $isHome ? $base->awayDefending : $base->homeDefending);
    //    dd($attackerStrength);
        // Calculate the likelihood of a foul
        $likelihoodOfFoul = ((30 + $defenderStrength) - $attackerStrength);

        // Generate a random number between 0 and 100
        $randomNumber = mt_rand(0, 100);

        // Check if a foul occurs based on the likelihood

        $isSecondYellow = false;
        if ($randomNumber <= $likelihoodOfFoul) {
            if ($defender->booked) {
                $isSecondYellow = true;
                $this->dismisalPlayer($base, $isHome, $defender);
                echo "2nd yellow card!!!!!!!!!!!\n";
            } else {
                $defender->booked = true;
                echo "YYellow card!!!!!!!!!!!\n";
            }

            return $base->reportEvent(
                $minute,
                eventName: $isSecondYellow ? EventsTemplates::TYPE_NDYELLOW : EventsTemplates::TYPE_YELLOW,
                teamName: $isHome
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

<?php

namespace App\Services\MatchServices;

use App\Models\MatchSchedule;
use App\Services\MatchServices\MatchMechanics\MatchMechanics;


class MatchService extends BaseMatchEvents
{
    public $match;
    public $homeTactic;
    public $awayTactic;
    public $homeLineup = [];
    public $awayLineup = [];
    public $matchMechanics;

    public $homeGoalkeeping = 0;
    public $homeDefending = 0;
    public $homeMidfielding = 0;
    public $homeStriking = 0;

    public $awayGoalkeeping = 0;
    public $awayDefending = 0;
    public $awayMidfielding = 0;
    public $awayStriking = 0;

    public $homeGoals = 0;
    public $awayGoals = 0;
    public $homeChance = 0;
    public $awayChance = 0;

    public $homeTarget = 0;
    public $awayTarget = 0;
    public $isDismissed = false; //DEBUG VARIABLE

    public function __construct(MatchSchedule $match)
    {
        $this->match = $match;
        $this->matchMechanics = new MatchMechanics();
        $this->homeTactic = $match->home_tactic;
        $this->awayTactic = $match->away_tactic;

        $this->homeLineup = json_decode($match->home_lineup);
        $this->awayLineup = json_decode($match->away_lineup);

        // Usage:
        $this->homeTeamFetch($this);
        $this->awayTeamFetch($this);
    }

    public function simulateMatch()
    {
        $matchDuration = 90; // 90 minutes

        $homeStart = rand(0, 1);

        $homePossessionCount = 0;
        $awayPossessionCount = 0;

        $momentumFactor = 0.02; // A small value to decrease the probability of consecutive possessions
        $consecutivePossessionTeam = null;
        // Apply home advantage (5-10% better overall)
        $homeAdvantage = 1.05 + rand(0, 5) / 100; // Home team gets 5-10% advantage
        $this->homeMidfielding *= $homeAdvantage;

        // Calculate the luck factor (0-5%)
        $homeLuckFactor = rand(0, 50) / 100;
        $awayLuckFactor = rand(0, 50) / 100;
        $this->match->home_goals = 0;
        $this->match->away_goals = 0;
        $this->match->home_shots = 0;
        $this->match->away_shots = 0;
        $this->match->home_on_target = 0;
        $this->match->away_on_target = 0;
        $this->match->save();
        $report = [];

        for ($minute = 1; $minute <= $matchDuration; $minute++) {
            $this->homeTeamFetch($this);
            $this->awayTeamFetch($this);
            $totalMidfieldSkill = $this->homeMidfielding + $this->awayMidfielding;
            $totalDefSkill = $this->homeDefending + $this->awayDefending;
            $totalFowSkill = $this->homeStriking + $this->awayStriking;
            $this->matchMechanics->homeDefending = $this->homeDefending;
            $this->matchMechanics->awayDefending = $this->awayDefending;

            //JUST FOR DEBUGING
            // echo ">>>>>>>>>>>>>>>>>>$totalMidfieldSkill -$totalDefSkill -$totalFowSkill -<<<<<<<<<<<<<<<<<<<<<<<<<<<<";
            // if ($this->isDismissed) {
            //    print_r ($this->awayLineup);
            //    print_r ($this->homeLineup);
            //    die;

            // }

            $defaultHomePossessionProbability = $this->homeMidfielding / $totalMidfieldSkill; // Default possession probability without momentum
            $defaultAwayPossessionProbability = $this->awayMidfielding / $totalMidfieldSkill; // Default possession probability without momentum
            echo "midfielding home vs away: : $this->homeMidfielding - $this->awayMidfielding\n";
            echo "default kamuolio valdymo tikimybe: $defaultHomePossessionProbability - $defaultAwayPossessionProbability\n";
            $homePossessionProbability = $this->homeMidfielding / $totalMidfieldSkill;

            $awayPossessionProbability = $this->awayMidfielding / $totalMidfieldSkill;

            $eventDesc = '';
            // Calculate the probability of each team winning possession based on their midfield skill

            if ($minute === 1) {
                $homeStart ? $isHome = true : $isHome = false;
                $event = $this->startMatchHalf('first', $isHome, $this->match);
                $eventDesc .= $event;
            } elseif ($minute === 46) {
                $homeStart ? $isHome = true : $isHome = false;
                $event = $this->startMatchHalf('second', $isHome, $this->match);
                $eventDesc .= $event;
            } else {
                if ($consecutivePossessionTeam) {
                    if ($consecutivePossessionTeam === 'home') {
                        $homePossessionProbability -= $momentumFactor;
                        $awayPossessionProbability = $defaultAwayPossessionProbability; // Reset away team probability
                    } else {
                        $awayPossessionProbability -= $momentumFactor;
                        $homePossessionProbability = $defaultHomePossessionProbability; // Reset home team probability
                    }
                    $homePossessionProbability = max(min($homePossessionProbability, 1), 0);
                    $awayPossessionProbability = max(min($awayPossessionProbability, 1), 0);
                }

                $randa = rand(0, 100) / 100;
                // Determine which team wins possession for this minute
                if ($homePossessionProbability > $awayPossessionProbability) {
                    $isHome = $randa <= (($awayPossessionProbability / $homePossessionProbability)) ? true : false;
                } else if ($homePossessionProbability < $awayPossessionProbability) {
                    $isHome = $randa <= (($homePossessionProbability / $awayPossessionProbability)) ? false : true;;
                } else {
                    $isHome = rand(0, 1) ? true : false;
                }
            }

            // Update possession count and the consecutivePossessionTeam variable
            if ($isHome) {
                $homePossessionCount++;
                $consecutivePossessionTeam = 'home';
            } else {
                $awayPossessionCount++;
                $consecutivePossessionTeam = 'away';
            }
            // echo "possesion count home : $homePossessionCount  away: $awayPossessionCount\n";
            $eventDesc .= $this->eventIteration($minute, $isHome, $eventDesc, $homeLuckFactor, $awayLuckFactor);
            echo "~~~~~~~~~~~~\n";

            if ($minute !== 90 && $minute % 15 === 0) { //TODO FINISH THIS
                $eventDesc .= $this->provideMatchStatsEvent($this->match, $homePossessionCount, $minute, $this->homeChance, $this->awayChance, $this->homeTarget, $this->awayTarget);
            }
            if (strlen($eventDesc) < 8) {
                $eventDesc = "";
            } else {
                array_push($report, $eventDesc);
            }
            sleep(0);
        }
        $this->updateMatchStats(
            $this->match,
            $this->homeGoals,
            $this->awayGoals,
            $this->homeChance,
            $this->awayChance
        );
        $finalEvent = $this->finalEvent($this->match, $homePossessionCount);
        array_push($report, $finalEvent);
        $this->match->report = $report;

        dd($report);
    }

    public function eventIteration(int $minute, bool $isHome, string $eventDesc)
    {
        if ($isHome) {
            $players = json_decode($this->match->home_lineup);
            $oppPlayers = json_decode($this->match->away_lineup);
        } else {
            $players = json_decode($this->match->away_lineup);
            $oppPlayers = json_decode($this->match->home_lineup);
        }
  
        $marks = $this->attackDefenceMarks($isHome, $this->homeStriking, $this->awayStriking, $this->homeDefending, $this->awayDefending);
        $phases = $this->matchMechanics->eventPhases($marks);

        for ($i = 0; $i < $phases; $i++) {
            $event = mt_rand(0, 10000) / 100;
      
            $quickAttack = $this->calculateGoalProbability($marks[0], $marks[1], 0.05);
            if ($event <= $quickAttack) {
                $getDefender = $this->getRandomDefender($oppPlayers);
    
                $foul =  $this->matchMechanics->foulScenario($isHome, $marks[0], $getDefender, $minute, $this);
                if ($foul == false) {
                    $eventDesc .= $this->matchMechanics->quickAttack($this, $minute, $players, $isHome, $eventDesc);
                    break;
                } else {
                    $eventDesc .= $foul;
                }
            }
            
        }
        // dd($phases);

        // dd($quickAttack);
        //select possesioning teams players
        // Simulate a goal

        return $eventDesc . "\n";
    }
}

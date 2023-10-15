<?php

namespace App\Services\MatchServices;

use App\Models\MatchSchedule;
use App\Services\MatchServices\MatchMechanics\MatchMechanics;


class MatchService
{
    public $match;
    public $matchMechanics;
    public $baseMatchEvents;

    public $homeTactic;
    public $awayTactic;
    public $homeLineup = [];
    public $awayLineup = [];

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

    public $homeTeamName;
    public $awayTeamName;

    public $stage = 0;
    public $i = 1;

    public function __construct(MatchSchedule $match)
    {
        $this->match = $match;
        $this->matchMechanics = new MatchMechanics();
        $this->baseMatchEvents = new BaseMatchEvents();
        $this->homeTactic = $match->home_tactic;
        $this->awayTactic = $match->away_tactic;
        $this->homeTeamName = $match->awayTeam->club_name;
        $this->awayTeamName = $match->homeTeam->club_name;

        $this->homeLineup = json_decode($match->home_lineup);
        $this->awayLineup = json_decode($match->away_lineup);

        // Usage:
        $this->baseMatchEvents->homeTeamFetch($this);
        $this->baseMatchEvents->awayTeamFetch($this);
    }

    public function simulateMatch()
    {
        $matchDuration = 90; // 90 minutes

        $homeStart = mt_rand(0, 1);

        $homePossessionCount = 0;
        $awayPossessionCount = 0;

        $momentumFactor = 0.02; // A small value to decrease the probability of consecutive possessions
        $consecutivePossessionTeam = null;
        // Apply home advantage (5-10% better overall)
        $homeAdvantage = 1.05 + mt_rand(0, 5) / 100; // Home team gets 5-10% advantage
        $this->homeMidfielding *= $homeAdvantage;

        // Calculate the luck factor (0-5%)
        $homeLuckFactor = mt_rand(0, 50) / 100;
        $awayLuckFactor = mt_rand(0, 50) / 100;
        $this->match->home_goals = 0;
        $this->match->away_goals = 0;
        $this->match->home_shots = 0;
        $this->match->away_shots = 0;
        $this->match->home_on_target = 0;
        $this->match->away_on_target = 0;
        $this->match->save();
        $report = [];

        for ($minute = 1; $minute <= $matchDuration; $minute++) {
            $this->baseMatchEvents->homeTeamFetch($this);
            $this->baseMatchEvents->awayTeamFetch($this);
            $totalMidfieldSkill = $this->homeMidfielding + $this->awayMidfielding;
            $totalDefSkill = $this->homeDefending + $this->awayDefending;
            $totalFowSkill = $this->homeStriking + $this->awayStriking;
            // $this->matchMechanics->homeDefending = $this->homeDefending;
            // $this->matchMechanics->awayDefending = $this->awayDefending;
            // $this->matchMechanics->homeStriking = $this->homeStriking;
            // $this->matchMechanics->awayStriking = $this->awayStriking;

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
                $activeTeam = $homeStart ? BaseMatchEvents::HOME_TEAM : BaseMatchEvents::AWAY_TEAM;
                $event = $this->baseMatchEvents->startMatchHalf('first', $activeTeam, $this->match);
                $eventDesc .= $event;
            } elseif ($minute === 46) {
                $activeTeam = $homeStart ? BaseMatchEvents::HOME_TEAM : BaseMatchEvents::AWAY_TEAM;
                $event = $this->baseMatchEvents->startMatchHalf('second', $activeTeam, $this->match);
                $eventDesc .= $event;
            } else {
                if ($consecutivePossessionTeam) {
                    if ($consecutivePossessionTeam === BaseMatchEvents::HOME_TEAM) {
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
                    $activeTeam = $randa <= (($awayPossessionProbability / $homePossessionProbability)) ? BaseMatchEvents::HOME_TEAM : BaseMatchEvents::AWAY_TEAM;
                } else if ($homePossessionProbability < $awayPossessionProbability) {
                    $activeTeam = $randa <= (($homePossessionProbability / $awayPossessionProbability)) ? BaseMatchEvents::HOME_TEAM : BaseMatchEvents::AWAY_TEAM;
                } else {
                    $activeTeam = rand(0, 1) ? BaseMatchEvents::HOME_TEAM : BaseMatchEvents::AWAY_TEAM;
                }
            }

            // Update possession count and the consecutivePossessionTeam variable
            if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
                $homePossessionCount++;
                $consecutivePossessionTeam = BaseMatchEvents::HOME_TEAM;
            } 
            if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
                $awayPossessionCount++;
                $consecutivePossessionTeam = BaseMatchEvents::AWAY_TEAM;
            }
 
            // echo "possesion count home : $homePossessionCount  away: $awayPossessionCount\n";
            $eventDesc .= $this->eventIteration($minute, $activeTeam, $eventDesc, $homeLuckFactor, $awayLuckFactor);
            echo "~~~~~~~~~~~~\n"; 
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

            if ($minute !== 90 && $minute % 15 === 0) { //TODO FINISH THIS
                $eventDesc .= $this->baseMatchEvents->provideMatchStatsEvent($this->match, $homePossessionCount, $minute, $this->homeChance, $this->awayChance, $this->homeTarget, $this->awayTarget);
            }
            if (strlen($eventDesc) < 8) {
                $eventDesc = "";
            } else {
                array_push($report, $eventDesc);
            }
            sleep(0);
        }
        $this->baseMatchEvents->updateMatchStats(
            $this->match,
            $this->homeGoals,
            $this->awayGoals,
            $this->homeChance,
            $this->awayChance,
            $this->homeTarget,
            $this->awayTarget
        );
        $finalEvent = $this->baseMatchEvents->finalEvent($this->match, $homePossessionCount);
        array_push($report, $finalEvent);
        $this->match->report = $report;

        dd($report);
    }

    public function eventIteration(int $minute, string $activeTeam, string $eventDesc)
    {
        if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
            $players = json_decode($this->match->home_lineup);
            $oppPlayers = json_decode($this->match->away_lineup);
        } else {
            $players = json_decode($this->match->away_lineup);
            $oppPlayers = json_decode($this->match->home_lineup);
        }
  
        $marks = $this->baseMatchEvents->attackDefenceMarks($activeTeam, $this->homeStriking, $this->awayStriking, $this->homeDefending, $this->awayDefending);
        
        $quickEvent = mt_rand(0, 10000) / 100;
        
        $quickAttack = $this->baseMatchEvents->calculateGoalProbability($marks[0], $marks[1], 0.05);
        if ($quickEvent <= $quickAttack) {
            $getDefender = $this->baseMatchEvents->getRandomDefender($oppPlayers);

            $foul =  $this->matchMechanics->foulScenario($activeTeam, $marks[0], $getDefender, $minute, $this);
            
            echo 'cp3';
            if ($foul == false) {
                $this->i += 999;
                $eventDesc .= $this->matchMechanics->quickAttack($this, $minute, $players, $activeTeam, $eventDesc);
            } else {
                $eventDesc .= $foul;
            }
        }
        $phases = $this->matchMechanics->eventPhases($marks);
        $this->stage = 0; ///TODO create setter to reset to zero;
        $this->i = 1;
        do {
            $lastPhase = false;
            if ($this->i === $phases) {
                $lastPhase = true;
            }
            $advanceEvent = mt_rand(0, 100);
    
            echo ($activeTeam . ' Have ' . $phases . 'is last phase? ' . $lastPhase . ' currently is i = ' .$this->i . "\n");
            $chanceAdvance = $this->baseMatchEvents->advanceStage($advanceEvent, $activeTeam, $players, $oppPlayers, $minute, $lastPhase, $this);
    
            if ($chanceAdvance) {
                $eventDesc .= $chanceAdvance;
            }

        } while ($this->i <= $phases);

        return $eventDesc . "\n";
    }
}

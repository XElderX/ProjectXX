<?php

namespace App\Services\MatchServices;

use App\Models\MatchSchedule;
use App\Models\Player;
use App\Services\MatchServices\EventsStringTemplates\EventsTemplates;
use Illuminate\Database\Eloquent\Collection;

class MatchService extends BaseMatchEvents
{
    public $match;
    public $homeTactic;
    public $awayTactic;
    public $homeLineup;
    public $awayLineup;

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

    public function __construct(MatchSchedule $match)
    {
        $this->match = $match;
        $this->homeTactic = $match->home_tactic;
        $this->awayTactic = $match->away_tactic;
        $this->homeLineup = $match->home_lineup;
        $this->awayLineup = $match->away_lineup;

        $this->homeLineup = json_decode($match->home_lineup);
        $this->awayLineup = json_decode($match->away_lineup);

        // Fetch related Player models for home lineup
        $this->homeTeamFetch();
        // Fetch related Player models for away lineup
        $this->awayTeamFetch();
    }

    private function calculatePlayerSkills($playerData)
    {
        $player = Player::find($playerData->player_id);
        if ($player) {
            // Extract skills based on player's position
            $position = $playerData->position;
            $gkSkill = (float) $player->gk;
            $paceSkill = (float) $player->pace;
            $passSkill = (float) $player->pass;
            $defSkill = (float) $player->def;
            $pmSkill = (float) $player->pm;
            $techSkill = (float) $player->tech;
            $headingSkill = (float) $player->head;
            $strSkill = (float) $player->str;
            $staminaSkill = (float) $player->stamina;
            $expSkill = (float) $player->exp;
            $leadSkill = (float) $player->lead;
            $formSkill = (float) $player->form;

            // Calculate skills based on player's position
            if ($position === 'GK') {
                $skillProportions = Player::SKILL_PROPORTIONS['goalkeeper'];
                $goalkeeping = $gkSkill * $skillProportions['gk'] + $paceSkill * $skillProportions['pace'] + $passSkill * $skillProportions['pass'];
                $exp = ($goalkeeping / 3) * ($expSkill * 0.1);
                $form = (($goalkeeping / 3) + $exp) * ($formSkill * 0.1);
                $goalkeeping += $exp + $form + $leadSkill * 0.15;
                return $goalkeeping;
            } elseif ($position === 'DEF') {
                $skillProportions = Player::SKILL_PROPORTIONS['defender'];
                $defending = $defSkill * $skillProportions['def'] + $pmSkill * $skillProportions['pm'] + $techSkill * $skillProportions['tech'] + $headingSkill * $skillProportions['head'] + $passSkill * $skillProportions['pass'] + $paceSkill * $skillProportions['pace'];
                $exp = ($defending / 6) * ($expSkill * 0.13);
                $form = (($defending / 6) + $exp) * ($formSkill * 0.13);
                $defending += $exp + $form + $leadSkill * 0.17;
                return $defending;
            } elseif ($position === 'MID') {
                $skillProportions = Player::SKILL_PROPORTIONS['midfielder'];
                $midfielding = $defSkill * $skillProportions['def'] + $paceSkill * $skillProportions['pace'] + $passSkill * $skillProportions['pass'] + $techSkill * $skillProportions['tech'] + $headingSkill * $skillProportions['head'] + $pmSkill * $skillProportions['pm'];
                $exp = ($midfielding / 6) * ($expSkill * 0.13);
                $form = (($midfielding / 6) + $exp) * ($formSkill * 0.13);
                $midfielding += $exp + $form + $leadSkill * 0.17;
                return $midfielding;
            } elseif ($position === 'FOW') {
                $skillProportions = Player::SKILL_PROPORTIONS['striker'];
                $striking = $paceSkill * $skillProportions['pace'] + $passSkill * $skillProportions['pass'] + $techSkill * $skillProportions['tech'] + $headingSkill * $skillProportions['head'] + $strSkill * $skillProportions['stri'];
                $exp = ($striking / 5) * ($expSkill * 0.14);
                $form = (($striking / 5) + $exp) * ($formSkill * 0.15);
                $striking += $exp + $form + $leadSkill * 0.19;
                return $striking;
            }
        }

        return 0; // Return 0 if player not found or invalid position
    }

    public function homeTeamFetch()
    {
        // Check if $homeLineup is not null and is an array before proceeding
        if (is_array($this->homeLineup)) {
            foreach ($this->homeLineup as $playerData) {
                $skill = $this->calculatePlayerSkills($playerData);
                if ($skill > 0) {
                    $homeLineupPlayers[] = Player::find($playerData->player_id);
                    if ($playerData->position === 'GK') {
                        $this->homeGoalkeeping += $skill;
                    }
                    // Assign other skills based on position
                    elseif ($playerData->position === 'DEF') {
                        $this->homeDefending += $skill;
                    } elseif ($playerData->position === 'MID') {
                        $this->homeMidfielding += $skill;
                    } elseif ($playerData->position === 'FOW') {
                        $this->homeStriking += $skill;
                    }
                }
            }
        }
    }

    public function awayTeamFetch()
    {
        // Check if $awayLineup is not null and is an array before proceeding
        if (is_array($this->awayLineup)) {
            foreach ($this->awayLineup as $playerData) {
                $skill = $this->calculatePlayerSkills($playerData);
                if ($skill > 0) {
                    $awayLineupPlayers[] = Player::find($playerData->player_id);
                    if ($playerData->position === 'GK') {
                        $this->awayGoalkeeping += $skill;
                    }
                    // Assign other skills based on position
                    if ($playerData->position === 'DEF') {
                        $this->awayDefending += $skill;
                    } elseif ($playerData->position === 'MID') {
                        $this->awayMidfielding += $skill;
                    } elseif ($playerData->position === 'FOW') {
                        $this->awayStriking += $skill;
                    }
                }
            }
        }
    }
    public function simulateMatch()
    {
        $matchDuration = 90; // 90 minutes

        $homeStart = rand(0, 1);

        $homePossessionCount = 0;
        $awayPossessionCount = 0;

        $totalMidfieldSkill = $this->homeMidfielding + $this->awayMidfielding;

        $defaultHomePossessionProbability = $this->homeMidfielding / $totalMidfieldSkill; // Default possession probability without momentum
        $defaultAwayPossessionProbability = $this->awayMidfielding / $totalMidfieldSkill; // Default possession probability without momentum
        echo "midfielding home vs away: : $this->homeMidfielding - $this->awayMidfielding\n";
        echo "default kamuolio valdymo tikimybe: $defaultHomePossessionProbability - $defaultAwayPossessionProbability\n";
        $homePossessionProbability = $this->homeMidfielding / $totalMidfieldSkill;

        $awayPossessionProbability = $this->awayMidfielding / $totalMidfieldSkill;

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
            $eventDesc = '';
            // Calculate the probability of each team winning possession based on their midfield skill

            if ($minute === 1) {
                $homeStart ? $possessingTeam = 'home' : $possessingTeam = 'away';
                $event = $this->startMatchHalf('first', $possessingTeam, $this->match);
                $eventDesc .= $event;
            } elseif ($minute === 46) {
                $homeStart ? $possessingTeam = 'away' : $possessingTeam = 'home';
                $event = $this->startMatchHalf('second', $possessingTeam, $this->match);
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
                    $possessingTeam = $randa <= (($awayPossessionProbability / $homePossessionProbability)) ? 'home' : 'away';
                } else if ($homePossessionProbability < $awayPossessionProbability) {
                    $possessingTeam = $randa <= (($homePossessionProbability / $awayPossessionProbability)) ? 'away' : 'home';;
                } else {
                    $possessingTeam = rand(0, 1) ? 'home' : 'away';
                }
            }
            
            // Update possession count and the consecutivePossessionTeam variable
            if ($possessingTeam === 'home') {
                $homePossessionCount++;
                $consecutivePossessionTeam = 'home';
            } else {
                $awayPossessionCount++;
                $consecutivePossessionTeam = 'away';
            }
            if ($minute !== 90 && $minute % 15 === 0) { //TODO FINISH THIS
                $eventDesc .= $this->provideMatchStatsEvent($this->match, $homePossessionCount, $minute, $this->homeChance, $this->awayChance, $this->homeTarget, $this->awayTarget );
            }
            // echo "possesion count home : $homePossessionCount  away: $awayPossessionCount\n";
            $eventDesc .= $this->eventIteration($minute, $possessingTeam, $eventDesc, $homeLuckFactor, $awayLuckFactor);
            echo "~~~~~~~~~~~~\n";

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

    public function eventIteration(int $minute, string $possessingTeam, string $eventDesc)
    {
        $event = rand(0, 10000) / 100;

        echo "laikas $minute , komanda valdo kamuoli $possessingTeam eventoRollNr $event\n";

        $marks = $this->attackDefenceMarks($possessingTeam, $this->homeStriking, $this->awayStriking, $this->homeDefending, $this->awayDefending);

        // dd($marks);
        $goalProbability = $this->calculateGoalProbability($marks[0], $marks[1]);

        // dd($goalProbability);
        //select possesioning teams players
        $players = $possessingTeam === 'home' ?  $players = json_decode($this->match->home_lineup) :  $players = json_decode($this->match->away_lineup);
        // Simulate a goal
        if ($event <= $goalProbability) {
            $scorer = $this->playerToScore($players);

            $selectedPlayerModel = $this->getPlayerModel($this->match, $possessingTeam, $scorer);
            $strike = $this->calculateStrike($selectedPlayerModel, $possessingTeam === 'home' ? $this->homeStriking : $this->awayStriking);
            $scoreChance = $this->chanceToScore();
            $saveChance = $this->chanceToSave($strike, $possessingTeam === 'home' ? $this->homeGoalkeeping : $this->awayGoalkeeping);
            $eventDesc .= $this->reportEvent($minute, EventsTemplates::TYPE_OPPORTUNITY, $possessingTeam === 'home' ? $this->match->homeTeam->club_name : $this->match->awayTeam->club_name, $selectedPlayerModel);

            ($possessingTeam === 'home') ? $this->homeChance++ : $this->awayChance++;
            ($possessingTeam === 'home') ? $this->homeTarget++ : $this->awayTarget++;

            if ($scoreChance >= $saveChance) {
                ($possessingTeam === 'home') ? $this->homeGoals++ : $this->awayGoals++;
                $eventDesc .= $this->reportEvent($minute, EventsTemplates::TYPE_SCORE, $possessingTeam === 'home' ? $this->match->homeTeam->club_name : $this->match->awayTeam->club_name, $selectedPlayerModel);
                echo "Goal at minute $minute! Home Team scores: $this->homeGoals\n";
            } else {
                $eventDesc .= $this->reportEvent($minute, EventsTemplates::TYPE_SAVEGK, $possessingTeam === 'home' ? $this->match->homeTeam->club_name : $this->match->awayTeam->club_name, $selectedPlayerModel);
                echo "Away Goalkeeper made save at minute $minute!\n";
            }
            $eventDesc .= $this->resultEvent($minute, $this->homeGoals, $this->awayGoals, $this->match);
            // dd($this->match->homeTeam->player);

            echo "at minute $minute! Result is Home: $this->homeGoals - Away: $this->awayGoals\n";
            return $eventDesc . "\n";
        }
    }
}

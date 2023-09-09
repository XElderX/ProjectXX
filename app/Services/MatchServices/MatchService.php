<?php

namespace App\Services\MatchServices;

use App\Models\MatchSchedule;
use App\Models\Player;
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
        $homeLuckFactor = rand(0, 10) / 100;
        $awayLuckFactor = rand(0, 10) / 100;
        $this->match->home_goals = 0;
        $this->match->away_goals = 0;
        $this->match->home_shots = 0;
        $this->match->away_shots = 0;
        $this->match->home_on_target = 0;
        $this->match->away_on_target = 0;
        $this->match->save();
        $report = [];

        for ($minute = 1; $minute <= $matchDuration; $minute++) {
            $eventDesc = $minute . 'min: ';
            // Calculate the probability of each team winning possession based on their midfield skill
            if ($minute === 1) {
                $homeStart ? $possessingTeam = 'home' : $possessingTeam = 'away';
                $event = $this->startMatchHalf('first', $possessingTeam, $this->match);
                $eventDesc .= $event;
                echo "1st minute possesion has >$possessingTeam<<\n";
            } elseif ($minute === 46) {
                $homeStart ? $possessingTeam = 'away' : $possessingTeam = 'home';
                $event = $this->startMatchHalf('second', $possessingTeam, $this->match);
                $eventDesc .= $event;
                echo "46th minute possesion has >$possessingTeam<\n";
            } else {
                if ($consecutivePossessionTeam) {
                    if ($consecutivePossessionTeam === 'home') {
                        $homePossessionProbability -= $momentumFactor;
                        $awayPossessionProbability = $defaultAwayPossessionProbability; // Reset away team probability
                    } else {
                        $awayPossessionProbability -= $momentumFactor;
                        $homePossessionProbability = $defaultHomePossessionProbability; // Reset home team probability
                    }
                    $homePossessionProbability = max(min($homePossessionProbability, 1), 0); // Ensure the probability is within the valid range [0, 1]
                    $awayPossessionProbability = max(min($awayPossessionProbability, 1), 0); // Ensure the probability is within the valid range [0, 1]
                }

                $randa = rand(0, 100) / 100;
                // Determine which team wins possession for this minute
                if ($homePossessionProbability > $awayPossessionProbability) {
                    // echo "home poss better possesion Ratio: " . (($awayPossessionProbability / $homePossessionProbability) / 2)  . " **** randa $randa\n";
                    $possessingTeam = $randa <= (($awayPossessionProbability / $homePossessionProbability)) ? 'home' : 'away';
                } else if ($homePossessionProbability < $awayPossessionProbability) {
                    $possessingTeam = $randa <= (($homePossessionProbability / $awayPossessionProbability)) ? 'away' : 'home';
                    // echo "away poss better possesion Ratio: " . (($homePossessionProbability / $awayPossessionProbability) / 2) . " **** randa $randa\n";
                } else {
                    echo "equal possesion Ratio: **** randa $randa\n";
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
            // echo "possesion count home : $homePossessionCount  away: $awayPossessionCount\n";
            $eventDesc .= $this->eventIteration($minute, $possessingTeam, $eventDesc);


            // // Simulate events for each minute
            // $event = rand(1, 100); // Random number to determine events probability

            // // Probability of a goal being scored (you can adjust these probabilities as needed)
            // $goalProbability = 2; // 2% chance of a goal

            // // Probability of a foul happening
            // $foulProbability = 5; // 5% chance of a foul

            // // Probability of a card being shown
            // $cardProbability = 2; // 2% chance of a card

            // // Simulate a goal
            // if ($event <= $goalProbability) {
            //     $scorer = rand(1, 2); // Randomly select the team that scores (1: Home, 2: Away)
            //     if ($scorer === 1) {
            //         $homeGoals++;
            //     } else {
            //         $awayGoals++;
            //     }
            //     echo "Goal at minute $minute! Home: $homeGoals - Away: $awayGoals\n";
            // }

            // // Simulate a foul
            // if ($event <= $foulProbability) {
            //     $foulTeam = rand(1, 2); // Randomly select the team committing the foul (1: Home, 2: Away)
            //     echo "Foul at minute $minute! Foul by Team $foulTeam\n";
            // }

            // // Simulate a card being shown
            // if ($event <= $cardProbability) {
            //     $cardTeam = rand(1, 2); // Randomly select the team receiving the card (1: Home, 2: Away)
            //     $cardType = rand(0, 1); // Randomly choose between yellow (0) and red (1) card
            //     $cardColor = ($cardType === 0) ? 'Yellow' : 'Red';
            //     echo "$cardColor card shown at minute $minute! Team $cardTeam\n";
            // }

            // // Simulate other events and actions as needed

            // // Add a delay or sleep to create the real-time effect
            // // You can adjust the duration to control the match speed.
            echo "~~~~~~~~~~~~\n";

            $eventDesc .= " \n";
            array_push($report, $eventDesc);
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
        // $homePoss = round($homePossessionCount * 100 / 90);
        // $awayPoss = 100 - $homePoss;

        // $finalEvent = 'Rungtynes pasibaige rezultatu: ' . $this->match->homeTeam->club_name . ' ' . $this->match->home_goals . ' - ' . $this->match->away_goals . ' ' . $this->match->awayTeam->club_name . " \n";
        // $finalEvent .= 'Kamuolio kontrole: ' . $this->match->homeTeam->club_name . ' ' . $homePoss . ' - ' . $awayPoss . ' ' . $this->match->awayTeam->club_name . " \n";
        // $finalEvent .= 'Pavojingos progos rungtynese: ' . $this->match->homeTeam->club_name . ' ' . $this->homeChance . ' - ' . $this->awayChance . ' ' . $this->match->awayTeam->club_name . " \n";
        array_push($report, $finalEvent);
        $this->match->report = $report;

        dd($report);
    }

    public function eventIteration(int $minute, string $possessingTeam, string $eventDesc)
    {
        $event = rand(0, 10000) / 100;

        // Output the result with two decimal places
        $event = number_format($event, 4);
        echo "laikas $minute , komanda valdo kamuoli $possessingTeam eventoRollNr $event\n";
        if ($possessingTeam === 'home') {
            $attackMarks = $this->homeStriking;
            $defenceMarks = $this->awayDefending;
        } else {
            $attackMarks = $this->awayStriking;
            $defenceMarks = $this->homeDefending;
        }
        $goalProbability = $this->calculateGoalProbability($attackMarks, $defenceMarks);

        $players = $possessingTeam === 'home' ?  $players = json_decode($this->match->home_lineup) :  $players = json_decode($this->match->away_lineup);
        // Simulate a goal
        if ($event <= $goalProbability) {
            $scorerRand = rand(1, 10);
            $scorer = '';
            if ($scorerRand <= 7) {
                $filteredPlayers = array_filter($players, function ($player) {
                    return $player->position === "FOW";
                });

                $filteredPlayers = array_values($filteredPlayers);
            } elseif ($scorerRand <= 9) {
                $filteredPlayers = array_filter($players, function ($player) {
                    return $player->position === "MID";
                });

                $filteredPlayers = array_values($filteredPlayers);
            } else {
                $filteredPlayers = array_filter($players, function ($player) {
                    return $player->position === "DEF";
                });
                $filteredPlayers = array_values($filteredPlayers);
            }
            $randomIndex = array_rand($filteredPlayers);
            $scorer = $filteredPlayers[$randomIndex];
            // dd($scorer->player_id);

            // dd($selectedPlayer);

            // dd($scorer);
            // dd($this->match->homeTeam->player);
            if ($possessingTeam === 'home') {
                $selectedPlayer = $this->match->homeTeam->player->firstWhere('id', $scorer->player_id);
                $strike = (int)$selectedPlayer['str'] + ((int)$selectedPlayer['tech'] * 0.3) + ((int)$selectedPlayer['pace'] * 0.3);
                $strike *= ((int)$selectedPlayer['exp'] / 100) + 1;
                $strike += (-5 + (int)$selectedPlayer['form']);

                $strike += $this->homeStriking / 11;
                // dd($strike);
                echo "ATTCKER $this->homeStriking vs GOALKEEPER $this->awayGoalkeeping";

                $this->homeChance++;
                $saveChance = 100 / ($strike / $this->awayGoalkeeping);
                $saveChance >= 1 ?? $saveChance = 0.94;
                $scoreRoll = rand(1, 10000);
                $scoreChance = $scoreRoll / 100;

                $eventDesc .= $this->match->homeTeam->club_name . ' turi proga isvystiti puolima. ';

                echo "chance at $minute! Home Team chance: $scoreChance vs save $saveChance\n";
                if ($scoreChance >= $saveChance) {
                    $this->homeGoals++;
                    $eventDesc .= $this->match->homeTeam->club_name . ' pelno ivarti!! Ivartis pelnytas ' . $minute . ' min. Ivarcio autorius: ' . $selectedPlayer->first_name . ' ' . $selectedPlayer->last_name;

                    echo "Goal at minute $minute! Home Team scores: $this->homeGoals\n";
                } else {
                    $eventDesc .= $this->match->awayTeam->club_name . ' vartininkas atremia pavojingai ' . $selectedPlayer->first_name . ' ' . $selectedPlayer->last_name . ' spiriama kamuoli i jo saugomus vartus ';
                    echo "Away Goalkeeper made save at minute $minute!\n";
                }
                $eventDesc .= ' Rungtyniu rezultatas: ' . $this->match->homeTeam->club_name . ' ' . $this->homeGoals . ' - ' . $this->awayGoals . ' ' . $this->match->awayTeam->club_name;
            } else {
                $selectedPlayer = $this->match->awayTeam->player->firstWhere('id', $scorer->player_id);
                $strike = (int)$selectedPlayer['str'] + ((int)$selectedPlayer['tech'] * 0.3) + ((int)$selectedPlayer['pace'] * 0.3);
                $strike *= ((int)$selectedPlayer['exp'] / 100) + 1;
                $strike += (-5 + (int)$selectedPlayer['form']);
                echo "ATTCKER $this->awayStriking vs GOALKEEPER $this->homeGoalkeeping";
                $this->awayChance++;
                $saveChance = 100 / ($strike  / $this->homeGoalkeeping);
                $saveChance >= 1 ?? $saveChance = 0.94;
                $scoreRoll = rand(1, 10000);
                $scoreChance = $scoreRoll / 100;
                $eventDesc .= $this->match->awayTeam->club_name . ' turi proga isvystiti puolima. ';

                echo "chance at $minute! away Team chance: $scoreChance vs save $saveChance\n";
                if ($scoreChance >= $saveChance) {
                    $this->awayGoals++;
                    $eventDesc .= $this->match->awayTeam->club_name . ' pelno ivarti!! Ivartis pelnytas ' . $minute . 'min.  Ivarcio autorius: ' . $selectedPlayer->first_name . ' ' . $selectedPlayer->last_name;

                    echo "Goal at minute $minute! Home Team scores: $this->awayGoals\n";
                } else {
                    $eventDesc .= $this->match->homeTeam->club_name . ' vartininkas atremia pavojingai ' . $selectedPlayer->first_name . ' ' . $selectedPlayer->last_name . ' spiriama kamuoli i jo saugomus vartus ';
                    echo "Home Goalkeeper made save at minute $minute!\n";
                }
                $eventDesc .= ' Rungtyniu rezultatas: ' . $this->match->homeTeam->club_name . ' ' . $this->homeGoals . ' - ' . $this->awayGoals . ' ' . $this->match->awayTeam->club_name;
            }
            echo "at minute $minute! Result is Home: $this->homeGoals - Away: $this->awayGoals\n";
            return $eventDesc;
        }
    }

    public function calculateGoalProbability($attackMarks, $defenceMarks, $defaultGoalProbability = 0.1, $defaultAttackMarks = 100, $defaultDefenceMarks = 100, $scalingFactor = 20)
    {
        // Calculate the relative strength of the attack compared to the default equal marks
        $relativeAttackStrength = $attackMarks / $defenceMarks;

        $newGoalProbabilityPercentage = ($relativeAttackStrength * $defaultGoalProbability) * 100;

        // echo "$attackMarks, $defenceMarks ... ivarcio tikimybe: $newGoalProbabilityPercentage\n";
        return $newGoalProbabilityPercentage;
    }

    function sigmoid($x)
    {
        return 1 / (1 + exp(-$x));
    }
}

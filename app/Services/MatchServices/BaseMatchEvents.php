<?php

namespace App\Services\MatchServices;

use App\Models\MatchSchedule;
use App\Models\Player;
use App\Services\MatchServices\EventsStringTemplates\EventsTemplates;

class BaseMatchEvents extends EventsTemplates
{
    public function startMatchHalf(string $half, bool $isHome, MatchSchedule $match): string
    {
        if ($half === 'first') {
            $event = $isHome
                ? 'Namu komanda ' . $match->homeTeam->club_name . ' pradeda rungtynes su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. '
                : 'Sveciu komanda ' . $match->awayTeam->club_name . ' pradeda rungtynes su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. ';
        }
        if ($half === 'second') {
            $event = $isHome
                ? 'Namu komanda ' . $match->homeTeam->club_name . ' antra rungtyniu dali pradeda su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. '
                : 'Sveciu komanda ' . $match->awayTeam->club_name . ' antra rungtyniu dali pradeda su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. ';
        }
        return $event;
    }

    public function finalEvent(MatchSchedule $match, $homePossCount)
    {
        $homePoss = round($homePossCount * 100 / 90);
        $awayPoss = 100 - $homePoss;

        $finalEvent = 'Rungtynes pasibaige rezultatu: ' . $match->homeTeam->club_name . ' ' . $match->home_goals . ' - ' . $match->away_goals . ' ' . $match->awayTeam->club_name . " \n";
        $finalEvent .= 'Kamuolio kontrole: ' . $match->homeTeam->club_name . ' ' . $homePoss . ' - ' . $awayPoss . ' ' . $match->awayTeam->club_name . " \n";
        $finalEvent .= 'Pavojingos progos rungtynese: ' . $match->homeTeam->club_name . ' ' . $match->home_shots . ' - ' . $match->away_shots . ' ' . $match->awayTeam->club_name . " \n";
        return $finalEvent;
    }

    public function provideMatchStatsEvent(MatchSchedule $match, int $homePossCount, int $minute, int $homeChance, int $awayChance, int $homeTarget, int $awayTarget)
    {
        $homePoss = round($homePossCount * 100 / $minute);
        $awayPoss = 100 - $homePoss;

        $statsEvent = 'Rungtyniu ' . $minute . " min. \n";
        $statsEvent .= 'Kamuolio kontrole: ' . $match->homeTeam->club_name . ' ' . $homePoss . ' - ' . $awayPoss . ' ' . $match->awayTeam->club_name . " \n";
        $statsEvent .= 'Progos rungtynese: ' . $match->homeTeam->club_name . ' ' . $homeChance . ' - ' . $awayChance . ' ' . $match->awayTeam->club_name . " \n";
        $statsEvent .= 'Smugiai i vartus: ' . $match->homeTeam->club_name . ' ' . $homeTarget . ' - ' . $awayTarget . ' ' . $match->awayTeam->club_name . " \n";
        return $statsEvent;
    }

    public function updateMatchStats(
        MatchSchedule $match,
        int $homeGoals = 0,
        int $awayGoals = 0,
        int $homeShots = 0,
        int $awayShots = 0,
        int $homeTarget = 0,
        int $awayTarget = 0
    ) {
        $match->home_goals = $homeGoals;
        $match->away_goals = $awayGoals;
        $match->home_shots = $homeShots;
        $match->away_shots = $awayShots;
        $match->home_on_target = $homeTarget;
        $match->away_on_target = $awayTarget;
        $match->save();
    }

    public function attackDefenceMarks(bool $isHome, float $homeStr, float $awayStr, float $homeDef, float $awayDef): array
    {
        return $isHome ? [$homeStr, $awayDef] : [$awayStr, $homeDef];
    }

    public function calculateGoalProbability($attackMarks, $defenceMarks, $defaultGoalProbability = 0.1, $defaultAttackMarks = 100, $defaultDefenceMarks = 100, $scalingFactor = 20)
    {
        // Calculate the relative strength of the attack compared to the default equal marks
        $relativeAttackStrength = $attackMarks / $defenceMarks;

        $newGoalProbabilityPercentage = ($relativeAttackStrength * $defaultGoalProbability) * 100;

        // echo "$attackMarks, $defenceMarks ... ivarcio tikimybe: $newGoalProbabilityPercentage\n";
        return $newGoalProbabilityPercentage;
    }

    public function playerToScore($players): object
    {
        $scorerRand = rand(1, 10);
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
        return  $filteredPlayers[$randomIndex];
    }

    // public function getPlayerModel(MatchSchedule $match, string $possessingTeam, object $scorer)
    // {
    //     if ($possessingTeam === 'home') {
    //         return  $match->homeTeam->player->firstWhere('id', $scorer->player_id);
    //     } else {
    //         return $match->awayTeam->player->firstWhere('id', $scorer->player_id);
    //     }
    // }

    public function calculateStrike(Player $selectedPlayer, $teamStr)
    {
        $strike = (int)$selectedPlayer['str'] + ((int)$selectedPlayer['tech'] * 0.3) + ((int)$selectedPlayer['pace'] * 0.3);
        $strike *= ((int)$selectedPlayer['exp'] / 100) + 1;
        $strike += (-5 + (int)$selectedPlayer['form']);
        $strike += $teamStr / 11;

        return $strike;
    }

    public function chanceToScore():float
    {
        $scoreRoll = rand(1, 10000);
        return $scoreRoll / 100;
    }
    public function chanceToSave(float $strike, float $goalkeeping):float
    {
        $saveChance = 100 / ($strike / $goalkeeping);
        $saveChance >= 1 ?? $saveChance = 0.94;
        $scoreRoll = rand(1, 10000);
        return $scoreRoll / 100;
    }

    public function reportEvent($minute, $eventName, $teamName = '', $player, $position = ''): string
    {
        $eventId = array_rand($this->$eventName);
        $eventTemplate = $this->$eventName[$eventId];
        $eventString = str_replace(
            ['$minute', '$teamName', '$player', '$position'],
            [$minute, $teamName, $player->first_name . ' ' . $player->last_name, $position],
            $eventTemplate);
        return $eventString . " \n";
    }

    public function resultEvent($minute, $homeGoals, $awayGoals, MatchSchedule $match): string
    {
        $eventString = ' ' .$minute .' min. Rungtyniu rezultatas: ' . $match->homeTeam->club_name. ' '. $homeGoals . ' - ' . $awayGoals . ' ' . $match->awayTeam->club_name;
       
        return $eventString ." \n";
    }

    public function calculatePlayerSkills($playerData)
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

    
    public function homeTeamFetch($base):void
    {
        $homeGoalkeeping = 0;
        $homeDefending = 0;
        $homeMidfielding = 0;
        $homeStriking = 0;
        if (is_array($base->homeLineup)) {
            foreach ($base->homeLineup as $playerData) {
                $skill = $base->calculatePlayerSkills($playerData);
                if ($skill > 0) {
                    $homeLineupPlayers[] = Player::find($playerData->player_id);
                    if ($playerData->position === 'GK') {
                        $homeGoalkeeping += $skill;
                    }
                    // Assign other skills based on position
                    elseif ($playerData->position === 'DEF') {
                        $homeDefending += $skill;
                    } elseif ($playerData->position === 'MID') {
                        $homeMidfielding += $skill;
                    } elseif ($playerData->position === 'FOW') {
                        $homeStriking += $skill;
                    }
                }
            }
            
               $base->homeGoalkeeping = $homeGoalkeeping;
               $base->homeDefending = $homeDefending;
               $base->homeMidfielding = $homeMidfielding;
               $base->homeStriking = $homeStriking;
        }
    }

    public function awayTeamFetch($base):void
    {
        $awayGoalkeeping = 0;
        $awayDefending = 0;
        $awayMidfielding = 0;
        $awayStriking = 0;
       
        if (is_array($base->awayLineup)) {
            foreach ($base->awayLineup as $playerData) {
                $skill = $base->calculatePlayerSkills($playerData);
                if ($skill > 0) {
                    $awayLineupPlayers[] = Player::find($playerData->player_id);
                    if ($playerData->position === 'GK') {
                        $awayGoalkeeping += $skill;
                    }
                    // Assign other skills based on position
                    if ($playerData->position === 'DEF') {
                        $awayDefending += $skill;
                    } elseif ($playerData->position === 'MID') {
                        $awayMidfielding += $skill;
                    } elseif ($playerData->position === 'FOW') {
                        $awayStriking += $skill;
                    }
                }
            }
            $base->awayGoalkeeping = $awayGoalkeeping;
            $base->awayDefending = $awayDefending;
            $base->awayMidfielding = $awayMidfielding;
            $base->awayStriking = $awayStriking;
        }
        else{
            dd('error in fetch');
        }
    }
}

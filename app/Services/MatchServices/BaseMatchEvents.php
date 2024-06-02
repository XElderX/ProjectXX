<?php

namespace App\Services\MatchServices;

use App\Models\MatchSchedule;
use App\Models\Player;
use App\Services\MatchServices\EventsStringTemplates\EventsTemplates;
use App\Services\MatchServices\MatchMechanics\MatchMechanics;

class BaseMatchEvents extends EventsTemplates
{
    public const HOME_TEAM = 'home';
    public const AWAY_TEAM = 'away';

    public const TEAMS = [
        self::HOME_TEAM, self::AWAY_TEAM
    ];

    protected $matchMechanics;

    public function __construct() {
        $this->matchMechanics = new MatchMechanics;
    }
    // public $homeGoalkeeping = 0;
    // public $homeDefending = 0;
    // public $homeMidfielding = 0;
    // public $homeStriking = 0;

    
    public function startMatchHalf(string $half, string $activeTeam, MatchSchedule $match): string
    {
        if ($half === 'first') {
            $event = $activeTeam == BaseMatchEvents::HOME_TEAM
                ? 'Namu komanda ' . $match->homeTeam->club_name . ' pradeda rungtynes su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. '
                : 'Sveciu komanda ' . $match->awayTeam->club_name . ' pradeda rungtynes su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. ';
        }
        if ($half === 'second') {
            $event = $activeTeam == BaseMatchEvents::HOME_TEAM
                ? 'Namu komanda ' . $match->homeTeam->club_name . ' antra rungtyniu dali pradeda su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. '
                : 'Sveciu komanda ' . $match->awayTeam->club_name . ' antra rungtyniu dali pradeda su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. ';
        }
        return $event;
    }

    public function finalEvent(MatchSchedule $match, int $homePossCount)
    {
        $homePoss = round($homePossCount * 100 / 90);
        $awayPoss = 100 - $homePoss;

        $finalEvent = 'Rungtynes pasibaige rezultatu: ' . $match->homeTeam->club_name . ' ' . $match->home_goals . ' - ' . $match->away_goals . ' ' . $match->awayTeam->club_name . " \n";
        $finalEvent .= 'Kamuolio kontrole: ' . $match->homeTeam->club_name . ' ' . $homePoss . ' - ' . $awayPoss . ' ' . $match->awayTeam->club_name . " \n";
        $finalEvent .= 'Pavojingos progos rungtynese: ' . $match->homeTeam->club_name . ' ' . $match->home_shots . ' - ' . $match->away_shots . ' ' . $match->awayTeam->club_name . " \n";
        $finalEvent .= 'Smugiai i vartu plota rungtynese: ' . $match->homeTeam->club_name . ' ' . $match->home_on_target . ' - ' . $match->away_on_target . ' ' . $match->awayTeam->club_name . " \n";
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

    public function attackDefenceMarks(string $activeTeam, float $homeStr, float $awayStr, float $homeDef, float $awayDef): array
    {
        if ($activeTeam == BaseMatchEvents::HOME_TEAM) {
            return [$homeStr, $awayDef];
        }
        if ($activeTeam == BaseMatchEvents::AWAY_TEAM) {
            return [$awayStr, $homeDef];
        }
    }

    public function calculateGoalProbability(float $attackMarks, float $defenceMarks, float $defaultGoalProbability = 0.1, $defaultAttackMarks = 100, $defaultDefenceMarks = 100, $scalingFactor = 20)
    {
        $relativeAttackStrength = $attackMarks / $defenceMarks;
        $newGoalProbabilityPercentage = ($relativeAttackStrength * $defaultGoalProbability) * 100;

        return $newGoalProbabilityPercentage;
    }

    public function playerToScore(array $players): object
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

    public function getRandomDefender(array $players): object
    {
        if ($players) {
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

    public function calculateStrike(Player $selectedPlayer, float $teamStr)
    {
        $strike = (int)$selectedPlayer['str'] + ((int)$selectedPlayer['tech'] * 0.3) + ((int)$selectedPlayer['pace'] * 0.3);
        $strike *= ((int)$selectedPlayer['exp'] / 100) + 1;
        $strike += (-5 + (int)$selectedPlayer['form']);
        $strike += $teamStr / 11;

        return $strike;
    }

    public function calculateDefence(Player $selectedPlayer, float $teamDef)
    {
        $defence = (int)$selectedPlayer['def'] + ((int)$selectedPlayer['pace'] * 0.3) + ((int)$selectedPlayer['tech'] * 0.3 + (int)$selectedPlayer['pace'] * 0.1);
        $defence *= ((int)$selectedPlayer['exp'] / 100) + 1;
        $defence += (-5 + (int)$selectedPlayer['form']);
        $defence += $teamDef / 11;

        return $defence;
    }

    public function chanceToScore(): float
    {
        $scoreRoll = mt_rand(1, 10000);
        return $scoreRoll / 100;
    }
    public function chanceToSave(float $strike, float $goalkeeping): float
    {
        $saveChance = 100 / ($strike / $goalkeeping);
        $saveChance >= 1 ?? $saveChance = 0.94;
        $scoreRoll = mt_rand(1, 10000);
        return $scoreRoll / 100;
    }

    public function reportEvent(int $minute, string $eventName, string $teamName = '', object $player, string $position = '', object $opponent = null, object $subPlayer = null): string
    {
        $eventId = array_rand($this->$eventName);
        $eventTemplate = $this->$eventName[$eventId];
        $eventString = str_replace(
            ['$minute', '$teamName', '$player', '$position', '$opponent', '$subPlayer'],
            [
                $minute,
                $teamName,
                $player->first_name . ' ' . $player->last_name,
                $position,
                isset($opponent) ? $opponent->first_name . ' ' . $opponent->last_name : '',
                isset($subPlayer) ? $subPlayer->first_name . ' ' . $subPlayer->last_name : ''
            ],
            $eventTemplate
        );

        return $eventString . " \n";
    }

    public function resultEvent(int $minute, int $homeGoals, int $awayGoals, MatchSchedule $match): string
    {
        $eventString = ' ' . $minute . ' min. Rungtyniu rezultatas: ' . $match->homeTeam->club_name . ' ' . $homeGoals . ' - ' . $awayGoals . ' ' . $match->awayTeam->club_name;

        return $eventString . " \n";
    }

    public function calculatePlayerSkills(object $playerData)
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


    public function homeTeamFetch(object $base): void
    {
        $homeGoalkeeping = 0;
        $homeDefending = 0;
        $homeMidfielding = 0;
        $homeStriking = 0;
        if (is_array($base->homeLineup)) {
            foreach ($base->homeLineup as $playerData) {
                $skill = $this->calculatePlayerSkills($playerData);
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

    public function awayTeamFetch(object $base): void
    {
        $awayGoalkeeping = 0;
        $awayDefending = 0;
        $awayMidfielding = 0;
        $awayStriking = 0;

        if (is_array($base->awayLineup)) {
            foreach ($base->awayLineup as $playerData) {
                $skill = $this->calculatePlayerSkills($playerData);
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
        } else {
            dd('error in fetch');
        }
    }

    public function advanceStage(int $advanceEvent, string $activeTeam, array $players, array $oppPlayers, int $minute, bool $lastPhase, MatchService $classA)
    {

        switch ($classA->stage) {
            case 0:
                // dd($this->firstStage($players, $oppPlayers, $advanceEvent, $minute, $isHome, $lastPhase));
                return $this->firstStage($players, $oppPlayers, $advanceEvent, $minute, $activeTeam, $lastPhase, $classA);
                break;
            case 1:
                return $this->secondStage($players, $oppPlayers, $advanceEvent, $minute, $activeTeam, $lastPhase, $classA);
                break;
            case 2:
                return $this->thirdStage($players, $oppPlayers, $advanceEvent, $minute, $activeTeam, $lastPhase, $classA);
                break;

            default:
                return;
                break;
        }
    }

    private function firstStage(array $players, array $oppPlayers, int $advanceEvent, int $minute, string $activeTeam, bool $lastPhase, MatchService $classA)
    {
        $stage = 1;
        list($midfielders, $oppMidfielders) = $this->categorizePlayersByPosition($players, $oppPlayers, 'MID');
        // list($defenders, $oppDefenders) = $this->categorizePlayersByPosition($players, $oppPlayers, 'DEF');
        // list($forwards, $oppForwards) = $this->categorizePlayersByPosition($players, $oppPlayers, 'FOW');

        //attack team
        $randPlayerIndex = array_rand($midfielders);
        $randomMidfielder = $midfielders[$randPlayerIndex];
        $player = Player::find($randomMidfielder->player_id);
        //def team
        $randOppPlayerIndex = array_rand($oppMidfielders);
        $randomOppMidfielder = $oppMidfielders[$randOppPlayerIndex];
        $oppPlayer = Player::find($randomOppMidfielder->player_id);

        $luck1 = mt_rand(0, 50) / 10;
        $luck2 = mt_rand(0, 50) / 10;

        $totalStrength = $luck1 + (($player->pm * 0.3) + ($player->tech * 0.2)  + ($player->pace * 0.1) + ($player->pass * 0.3) + ($player->exp * 0.1)) * (1.5 + 0.5 * ($player->form - 5));
        $totalOppStrength = $luck2 + (($oppPlayer->def * 0.4) + ($oppPlayer->tech * 0.1)  + ($oppPlayer->pace * 0.3) + ($oppPlayer->heading * 0.1) + ($oppPlayer->exp * 0.1)) * (1.5 + 0.5 * ($oppPlayer->form - 5));
        //   dd($advanceEvent);
      
        if ($this->matchMechanics->isAdvance($totalStrength, $totalOppStrength, stage:$stage)) {
            $classA->stage++;
            return;
            // return $this->reportEvent(
            //     $minute,
            //     EventsTemplates::TYPE_ADVANCE1,
            //     teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
            //         ? $classA->awayTeamName
            //         : $classA->homeTeamName,
            //     player: $player,
            //     position: $player->position,
            //     opponent: $oppPlayer
            // );
        } else {
            $classA->i++;
            if ($lastPhase) {
                return $this->reportEvent(
                    $minute,
                    EventsTemplates::TYPE_NOADVANCE1,
                    teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                        ? $classA->awayTeamName
                        : $classA->homeTeamName,
                    player: $player,
                    position: $player->position,
                    opponent: $oppPlayer
                );
            }
            return;
        }
    }

    private function secondStage(array $players, array $oppPlayers, int $advanceEvent, int $minute, string $activeTeam, bool $lastPhase, $classA)
    {
        $stage = 2;
        list($midfielders, $oppMidfielders) = $this->categorizePlayersByPosition($players, $oppPlayers, 'MID');
        list($defenders, $oppDefenders) = $this->categorizePlayersByPosition($players, $oppPlayers, 'DEF');
        list($forwards, $oppForwards) = $this->categorizePlayersByPosition($players, $oppPlayers, 'FOW');

        //attack team mid
        $randPlayerIndex = array_rand($midfielders);
        $randomMidfielder = $midfielders[$randPlayerIndex];
        $midfield = Player::find($randomMidfielder->player_id);
        //def team mid 
        $randOppPlayerIndex = array_rand($oppMidfielders);
        $randomOppMidfielder = $oppMidfielders[$randOppPlayerIndex];
        $oppMidfield = Player::find($randomOppMidfielder->player_id);


        $randOppDefPlayerIndex = array_rand($oppDefenders);
        $randomOppDefenders = $oppDefenders[$randOppDefPlayerIndex];
        $oppDefender = Player::find($randomOppDefenders->player_id);

        //attack team fow
        $randAttPlayerIndex = array_rand($forwards);
        $randomForward = $forwards[$randAttPlayerIndex];
        $forward = Player::find($randomForward->player_id);

        $luck1 = mt_rand(0, 50) / 10;
        $luck2 = mt_rand(0, 50) / 10;

        $midfielderStrength = $luck1 + (($midfield->pm * 0.1) + ($midfield->tech * 0.25)  + ($midfield->pace * 0.2) + ($midfield->pass * 0.25) + ($midfield->exp * 0.1)) + ($forward->str * 0.1) * (1.5 + 0.5 * ($midfield->form - 5));
        $oppMidfielderStrength = $luck2 + (($oppMidfield->def * 0.4) + ($oppMidfield->tech * 0.1)  + ($oppMidfield->pace * 0.2) + ($oppMidfield->heading * 0.2) + ($oppMidfield->exp * 0.1)) * (1.5 + 0.5 * ($oppMidfield->form - 5));

        $luck3 = mt_rand(0, 50) / 10;
        $luck4 = mt_rand(0, 50) / 10;

        $forwardStrength = $luck3 + (($forward->str * 0.2) + ($forward->tech * 0.2)  + ($forward->pace * 0.2) + ($forward->pass * 0.2) + ($forward->heading * 0.1)) + ($forward->exp * 0.1) * (1.5 + 0.5 * ($forward->form - 5));
        $oppDefenderStrength = $luck4 + (($oppDefender->def * 0.4) + ($oppDefender->tech * 0.1)  + ($oppDefender->pace * 0.3) + ($oppDefender->heading * 0.1) + ($oppDefender->exp * 0.1)) * (1.5 + 0.5 * ($oppDefender->form - 5));


        $totalStrength = ($midfielderStrength * 0.7) + ($forwardStrength * 0.3);
        $totalOppStrength = ($oppMidfielderStrength * 0.3) + ($oppDefenderStrength * 0.7);

        if ($this->matchMechanics->isAdvance($totalStrength, $totalOppStrength, stage:$stage)) {
            $classA->stage++;
            return $this->reportEvent(
                $minute,
                EventsTemplates::TYPE_ADVANCE2,
                teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? $classA->awayTeamName
                    : $classA->homeTeamName,
                player: $midfield,
                position: $midfield->position,
                opponent: $oppDefender,
                subPlayer: $forward
            );
        } else {
            $classA->i++;
            if ($lastPhase) {
                return $this->reportEvent(
                    $minute,
                    EventsTemplates::TYPE_NOADVANCE2,
                    teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                        ? $classA->awayTeamName
                        : $classA->homeTeamName,
                    player: $midfield,
                    position: $midfield->position,
                    opponent: $oppDefender,
                    subPlayer: $forward
                );
            }
        }
    }

    private function thirdStage(array $players, array $oppPlayers, int $advanceEvent, int $minute, string $activeTeam, bool $lastPhase, MatchService $classA)
    {
        $stage = 3;

        list($midfielders, $oppMidfielders) = $this->categorizePlayersByPosition($players, $oppPlayers, 'MID');
        list($defenders, $oppDefenders) = $this->categorizePlayersByPosition($players, $oppPlayers, 'DEF');
        list($forwards, $oppForwards) = $this->categorizePlayersByPosition($players, $oppPlayers, 'FOW');
        list($goalkeeper, $oppGoalkeeper) = $this->categorizePlayersByPosition($players, $oppPlayers, 'GK');

        //attack team mid
        $randPlayerIndex = array_rand($midfielders);
        $randomMidfielder = $midfielders[$randPlayerIndex];
        $midfield = Player::find($randomMidfielder->player_id);
        // //def team mid 

        //def team def 
        $randOppDefPlayerIndex = array_rand($oppDefenders);
        $randomOppDefenders = $oppDefenders[$randOppDefPlayerIndex];
        $oppDefender = Player::find($randomOppDefenders->player_id);

        //attack team fow
        $randAttPlayerIndex = array_rand($forwards);
        $randomForward = $forwards[$randAttPlayerIndex];
        $forward = Player::find($randomForward->player_id);
        //def team fow 
     

        //def team GK 
        $randOppGkPlayerIndex = array_rand($oppGoalkeeper);
        $randomOppGoalkeeper = $oppGoalkeeper[$randOppGkPlayerIndex];
        $oppGoalkeeper = Player::find($randomOppGoalkeeper->player_id);

        $luck1 = mt_rand(0, 50) / 10;
        $luck2 = mt_rand(0, 50) / 10;

        // echo  'is ' . $midfield->club_id; 
        // dd($isHome);
        $midfielderStrength = $luck1 + (($midfield->pm * 0.05) + ($midfield->tech * 0.25)  + ($midfield->pace * 0.15) + ($midfield->pass * 0.3) + ($midfield->exp * 0.1)) + ($forward->str * 0.15) * (1.5 + 0.5 * ($midfield->form - 5));
        // $oppMidfielderStrength = $luck2 + (($oppMidfield->def * 0.4) + ($oppMidfield->tech * 0.1)  + ($oppMidfield->pace * 0.2) + ($oppMidfield->heading * 0.2) + ($oppMidfield->exp * 0.1)) * (1.5 + 0.5 * ($oppMidfield->form - 5));

        $oppDefenceBonusStrength = $activeTeam == BaseMatchEvents::HOME_TEAM ? $classA->homeDefending : $classA->awayDefending; //finish
        $luck3 = mt_rand(0, 50) / 10;
        $luck4 = mt_rand(0, 50) / 10;

        $forwardStrength = $luck3 + (($forward->str * 0.35) + ($forward->tech * 0.25)  + ($forward->pace * 0.2) + ($forward->pass * 0.1) + ($forward->heading * 0.1)) + ($forward->exp * 0.1) * (1.5 + 0.5 * ($forward->form - 5));
        $oppDefenderStrength = $luck4 + (($oppDefender->def * 0.4) + ($oppDefender->tech * 0.05)  + ($oppDefender->pace * 0.25) + ($oppDefender->heading * 0.2) + ($oppDefender->exp * 0.1)) * (1.5 + 0.5 * ($oppDefender->form - 5));

        $totalStrength = ($midfielderStrength * 0.3) + ($forwardStrength * 0.7);
        $totalOppStrength = ($luck2 + ($oppDefenceBonusStrength / count($oppDefenders)) * 0.3) + ($oppDefenderStrength * 0.7);

        // dd($totalStrength . ' vs ' . $totalOppStrength);
        //   dd($advanceEvent);
    
        if ($this->matchMechanics->isAdvance($totalStrength, $totalOppStrength, stage:$stage)) {
            $classA->stage++;
            $result =  $this->reportEvent(
                $minute,
                EventsTemplates::TYPE_ADVANCE3,
                teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                    ? $classA->awayTeamName
                    : $classA->homeTeamName,
                player: $midfield,
                position: $midfield->position,
                opponent: $oppDefender,
                subPlayer: $forward
            );
        } else {
            $classA->i++;
            $result = $this->matchMechanics->foulScenario($activeTeam, $forwardStrength, $randomOppDefenders, $minute, $classA, 10);
            echo 'cp1';
            if (!$result) {
                if ($lastPhase) {
                    return $this->reportEvent(
                        $minute,
                        EventsTemplates::TYPE_NOADVANCE3,
                        teamName: $activeTeam == BaseMatchEvents::AWAY_TEAM
                            ? $classA->awayTeamName
                            : $classA->homeTeamName,
                        player: $midfield,
                        position: $midfield->position,
                        opponent: $oppDefender,
                        subPlayer: $forward
                    );
                }
                return;
            }
            $result .= $this->matchMechanics->freeKick($classA, $activeTeam, $result, $minute);

            return $result;
        }
        $result2 = $this->matchMechanics->foulScenario($activeTeam, $forwardStrength, $randomOppDefenders, $minute, $classA, 15);
        if ($result2) {
            //TODO perhaps penalty
            $result .= $result2;
            $result .= $this->matchMechanics->penalty($classA, $activeTeam, $result, $minute);
            $classA->i += 999;
            echo 'cp22';

            return $result;
        }

        $shooterRand = mt_rand(1, 100);
        $outcome = $this->determineOutcome($shooterRand);
        if ($outcome === "FOW") {
            $randomIndex = array_rand($forwards);
            $shooter = $forwards[$randomIndex];
        } else if ($outcome === "MID") {
            $randomIndex = array_rand($midfielders);
            $shooter = $midfielders[$randomIndex];
        } else {
            $randomIndex = array_rand($defenders);
            $shooter = $defenders[$randomIndex];
        }

        $shooter = Player::find($shooter->player_id);
        $assister = $shooter->player_id === $midfield->player_id ? $midfield : $forward;
        //TODO make defenders assister too and make with no assisters as individual goals or etc.
        // dd($assister);
        $randShoot = mt_rand(1, 10); //default 5/5 simple/header type
        $shootType =  $randShoot <= 5 ? 'simple' : 'header';
        //TODO modify ShootType based on match tactic selection 
        $classA->i += 999;
        return $this->matchMechanics->shootingStage($shooter, $oppGoalkeeper, $assister, $shootType, $outcome, $activeTeam, $minute, $classA);

        //TODO SHOOTING STAGE
    }

    private function categorizePlayersByPosition(array $players, array $oppPlayers, string $position): array
    {
        $teamPlayers = [];
        $oppTeamPlayers = [];

        foreach ($players as $player) {
            if ($player->position === $position) {
                $teamPlayers[] = $player;
            }
        }

        foreach ($oppPlayers as $player) {
            if ($player->position === $position) {
                $oppTeamPlayers[] = $player;
            }
        }

        return [$teamPlayers, $oppTeamPlayers];
    }

    private function determineOutcome(int $rand): string
    {
        return match (true) {
            $rand >= 1 && $rand <= 60 => 'FOW',
            $rand >= 61 && $rand <= 90 => 'MID',
            $rand >= 91 && $rand <= 100 => 'DEF',
            default => 'Invalid',
        };
    }
}

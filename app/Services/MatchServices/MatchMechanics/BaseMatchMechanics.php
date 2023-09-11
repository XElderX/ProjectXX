<?php

namespace App\Services\MatchServices\MatchMechanics;

use App\Models\MatchSchedule;
use App\Services\MatchServices\EventsStringTemplates\EventsTemplates;

class BaseMatchMechanics
{
    protected function lastManFoul($base, bool $isHome, $eventDesc, $minute)
    {
        $squad = $this->selectOppositeTeamPlayer($isHome, $base);
        $player = $this->selectPlayers($squad);
        $model = $this->getPlayerModel($base->match, !$isHome, $player);
        dd($model);//TODO FROM HERE

        $eventDesc .= $base->reportEvent(
            $minute,
            eventName:EventsTemplates::TYPE_LASTFOUL, 
            teamName:$isHome 
            ? $base->match->awayTeam->club_name 
            : $base->match->homeTeam->club_name, 
            player:$model,
            position:$player->position
        );

        dd($eventDesc);

    }
    public function getPlayerModel(MatchSchedule $match, bool $isHome, object $playerModel)
    {echo $isHome . 'z' . $playerModel->player_id . 'x';
        if ($isHome) {
            return  $match->homeTeam->player->firstWhere('id', $playerModel->player_id);
        } else {
            return $match->awayTeam->player->firstWhere('id', $playerModel->player_id);
        }
    }

    private function selectOppositeTeamPlayer(bool $isHome, $base)
    {
        return $isHome ? json_decode($base->match->away_lineup) : json_decode($base->match->home_lineup);
    }

    private function selectPlayers($players): object
    {
        $scorerRand = rand(1, 20);

        $positions = [
            9 => "DEF",
            14 => "GK",
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
}

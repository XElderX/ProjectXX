<?php

namespace App\Services\MatchServices;

use App\Models\MatchSchedule;

class BaseMatchEvents
{
    public function startMatchHalf(string $half, string $team, MatchSchedule $match): string
    {
        if ($half === 'first') {
            $event = $team === 'home'
                ? 'Namu komanda ' . $match->homeTeam->club_name . ' pradeda rungtynes su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. '
                : 'Sveciu komanda ' . $match->awayTeam->club_name . ' pradeda rungtynes su kamuoliu, issispirdami kamuoli nuo vidurio aikstes linijos. ';
        }
        if ($half === 'second') {
            $event = $team === 'home'
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
}

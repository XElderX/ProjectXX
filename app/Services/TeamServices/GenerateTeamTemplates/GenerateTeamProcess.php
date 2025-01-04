<?php

namespace App\Services\TeamServices\GenerateTeamTemplates;

use App\Models\Club;
use App\Services\TeamServices\BaseTeamProcessService;
use Exception;

class GenerateTeamProcess extends BaseTeamProcessService
{

    public function process($type, $data)
    {
        try {
            $this->team->country_id = $data->country_id;
        
        ($data->user_id === null)
            ? $this->team->user_id = null
            : $this->team->user_id = $data->user_id;

            $this->team->town_id = $data->town_id;
            $this->team->club_name = $data->title;
            $this->team->club_rating_points = 0;
            $this->team->club_rank = 0;
            $this->team->supporters = 150;
            $this->team->supporters_mood = Club::MOOD_HAPPY;
            $this->team->budget = 350000;
        } catch (Exception $e) {
            throw new \Exception("error generatin a team");
        }
        $this->team->save();

        $this->generatePlayers();
        return $this->team;
    }
}

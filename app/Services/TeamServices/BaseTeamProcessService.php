<?php

namespace App\Services\TeamServices;

use App\Models\Club;
use App\Models\Player;
use App\Services\PlayerServices\GeneratePlayerTemplates\GeneratePlayerProcess;

class BaseTeamProcessService
{
    /**
     * @var Club
     */
    protected $team;
    protected $player;
    protected $playersCount = 18;

    protected $goalkeepers = 2;
    protected $defenders = 6;
    protected $midfields = 6;
    protected $forwards = 4;

    public function __construct()
    {
        $this->team = new Club();
    }

    protected function generatePlayers(): void
    {
        // dd($this->team);
        for ($i = 0; $i < 18; $i++) {
            $this->generatePlayer($i);
        }

        dd($this->playersCount);
    }

    private function generatePlayer(int $iteration): void
    {
        $position = '';
        if ($iteration < 2) {
            $position = Player::POSITION_GK;
        } elseif ($iteration < 8) {
            $defender = [Player::POSITION_DEF, Player::POSITION_DEF_WING];
            $position = $defender[rand(0, 1)];
        } elseif ($iteration < 14) {
            $midfield = [
                Player::POSITION_MID_WING, Player::POSITION_DM,
                Player::POSITION_MID, Player::POSITION_AM
            ];
            $position = $midfield[rand(0, 3)];
        } else {
            $position = Player::POSITION_STR;
        }
        $type = '1';
        $position =
            $data = [
                "country_id" => $this->team->country_id,
                "club_id"    => $this->team->id,
                'position'   => $position,
                'age'        => null,
            ];
        $newPlayer = new GeneratePlayerProcess;

        $newPlayer->process($type, (object) $data);
        $newPlayer->savePlayer();
    }
}

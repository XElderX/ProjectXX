<?php

namespace App\Services\PlayerServices\GeneratePlayerTemplates;

use App\Models\Country;
use App\Models\Player;
use App\Services\PlayerServices\BasePlayerProcessService;
use Exception;

class GeneratePlayerProcess extends BasePlayerProcessService
{
    /**
     * @var Player
     */
    protected $player;

    protected $skills = [
        'gk', 'def', 'pm', 'pace',
        'tech', 'pass', 'heading',
        'str', 'stamina'
    ];
    protected $quality;
    protected $youthModifieder;
   
    public function __construct()
    {
        $this->player = new Player();
        $this->repeat = false;
    }

    public function process(string $type, $data)
    {
        try {
            $this->player->club_id = $data->club_id;
        
        ($data->country_id === null)
            ? $this->player->country_id = Country::inRandomOrder()->first()->id
            : $this->player->country_id = $data->country_id;

        if ($type === '1'){
            $this->player->type = Player::TYPE_PLAYER;
            ($data->age === null)
                ? $this->player->age = rand(14, 40)
                : $this->player->age = $data->age;
        } elseif ($type === '2') {
            $this->player->type = Player::TYPE_YOUTH;
            $this->quality = $data->quality;
            ($data->age === null)
                ? $this->player->age = rand(14, 20)
                : $this->player->age = $data->age;
        } elseif ($type === '3'){
            $this->player->type = Player::TYPE_TRAINER;
            ($data->age === null)
                ? $this->player->age = rand(28, 70)
                : $this->player->age = $data->age;
        }

        ($data->position === null)
            ? $this->player->position = Player::PLAYER_POSITIONS[(rand(1, count(Player::PLAYER_POSITIONS)))-1]
            : $this->player->position = $data->position;


        $this->player->first_name = $this->setFirstName($this->player->country_id);
        $this->player->last_name = $this->setLastName($this->player->country_id);
        $this->player->height = $this->randomizer('height', rand(0, 6));
        $this->player->weight = $this->randomizer('weight', rand(0, 6), $this->player->height);
        $this->player->potential = $this->setPotential($this->player->age); 
        $this->player->bookings = 0;
        $this->player->injury_days = 0;
        $this->player->fatique = 100;
        $this->player->form = 5;
        $this->player->exp = round($this->setExperience($this->player->age), 3);
        $this->player->lead = $this->setLeadership() + (mt_rand(0, 999) / 1000);
        if ($type == 1) {
            $this->playerSkills ();
        } elseif ($type == 2) {
            $this->youthSkills ();
        } else {
            $this->playerSkills (); //TODO implement coaching skills logic
        }
        
        $this->player->salary = $this->salaryResolver($this->player) / 2.2;
        $this->player->value = $this->valueResolver($this->player) / 4.1;
        } catch (Exception $e) {
            dd($e);
            throw new \Exception("Error generatin a player" . $e);
        }
        return $this->player;
    }

    private function playerSkills (): void
    {
        foreach ($this->skills as $key => $value) {
            $this->player->$value = round($this->resolveSkill($this->player->position, $this->player->age, $value), 3);
        }
    }

    private function youthSkills (): void
    {
        foreach ($this->skills as $key => $value) {
            $qualityBoost = 1 + mt_rand(1, $this->quality) / 200; // youth quality determiner
            $this->youthModifieder = $qualityBoost;
            $this->player->$value = round($this->resolveSkill($this->player->position, $this->player->age, $value), 3) * $qualityBoost;
        }
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function savePlayer()
    {
        return $this->player->save();
    }
}

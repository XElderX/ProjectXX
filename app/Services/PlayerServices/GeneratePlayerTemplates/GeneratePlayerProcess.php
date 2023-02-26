<?php

namespace App\Services\PlayerServices\GeneratePlayerTemplates;

use App\Models\Country;
use App\Models\Name;
use App\Models\Player;
use App\Models\Surname;
use App\Services\PlayerServices\BasePlayerProcessService;

class GeneratePlayerProcess extends BasePlayerProcessService
{
    /**
     * @var Player
     */
    protected $player;

    public function __construct()
    {
        $this->player = new Player();
        $this->repeat = false;
    }

    public function process($data)
    {
        $this->player->club_id = $data->club_id;
        
        ($data->country_id === null)
            ? $this->player->country_id = Country::inRandomOrder()->first()->id
            : $this->player->country_id = $data->country_id;

        ($data->age === null)
            ? $this->player->age = rand(14,40)
            : $this->player->age = $data->age;

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
        $this->player->fatigue = 100;
        $this->player->form = 5;
        $this->player->exp = round($this->setExperience($this->player->age), 3);
        $this->player->lead = $this->setLeadership() + (mt_rand(0, 999) / 1000);
        
        $this->player->gk = round($this->resolveSkill($this->player->position, $this->player->age, 'gk'), 3);
        $this->player->def = round($this->resolveSkill($this->player->position, $this->player->age, 'def'), 3);
        $this->player->pm = round($this->resolveSkill($this->player->position, $this->player->age, 'pm'), 3);
        $this->player->pace = round($this->resolveSkill($this->player->position, $this->player->age, 'pace'), 3);
        $this->player->tech = round($this->resolveSkill($this->player->position, $this->player->age, 'tech'), 3);
        $this->player->pass = round($this->resolveSkill($this->player->position, $this->player->age, 'pass'), 3);
        $this->player->heading = round($this->resolveSkill($this->player->position, $this->player->age, 'heading'), 3);
        $this->player->str = round($this->resolveSkill($this->player->position, $this->player->age, 'str'), 3);
        $this->player->stamina = round($this->resolveSkill($this->player->position, $this->player->age, 'stamina'), 3);

        $this->player->salary = $this->salaryResolver($this->player);
        // 'first_name',+
        // 'last_name',+

        // 'value',
        // 'salary',

        // 'height',+
        // 'weight',+
        // 'age',+
        // 'potential',+
        // 'bookings',+
        // 'injury_days',+
        // 'fatigue',+
        // 'position',+

        // 'gk',//0
        // 'def',//1
        // 'pm',//2
        // 'pace',//3
        // 'tech',//4
        // 'pass',
        // 'heading',
        // 'str',

        // 'stamina',
        // 'exp',+
        // 'lead',+
        // 'form',+
        // 'club_id',+
        // 'country_id',+


        dd($this);
        
    }
}
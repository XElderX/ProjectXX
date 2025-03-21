<?php
namespace App\Services\MatchServices;

class Team {
    public $name;
    public $attack;
    public $defense;
    public $stamina;
    public $score = 0;

    public function __construct($name, $attack, $defense, $stamina) {
        $this->name = $name;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->stamina = $stamina;
    }

    public function loseStamina() {
        $this->stamina -= rand(1, 5); // Lose 1-5 stamina per event
        if ($this->stamina < 0) {
            $this->stamina = 0;
        }
    }
}
?>

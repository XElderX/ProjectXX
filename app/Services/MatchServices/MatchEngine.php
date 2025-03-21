<?php

namespace App\Services\MatchServices;


class MatchEngine {
    private $team1;
    private $team2;
    private $events = [
        "pass", "tackle", "shot", "goal_attempt", "foul"
    ];

    public function __construct($team1, $team2) {
        $this->team1 = $team1;
        $this->team2 = $team2;
    }

    public function simulateMatch() {
        echo "⚽ Match Started: {$this->team1->name} vs {$this->team2->name} ⚽\n\n";
        
        for ($minute = 1; $minute <= 90; $minute += rand(2, 5)) { // Simulate time intervals
            $attackingTeam = (rand(0, 1) == 0) ? $this->team1 : $this->team2;
            $defendingTeam = ($attackingTeam === $this->team1) ? $this->team2 : $this->team1;
            
            $event = $this->events[array_rand($this->events)];
            $this->handleEvent($event, $attackingTeam, $defendingTeam, $minute);

            // Players lose stamina each event
            $attackingTeam->loseStamina();
            $defendingTeam->loseStamina();
        }

        // Match End
        echo "\n⏳ Full Time! Final Score: {$this->team1->name} {$this->team1->score} - {$this->team2->score} {$this->team2->name}\n";
    }

    private function handleEvent($event, $attackingTeam, $defendingTeam, $minute) {
        switch ($event) {
            case "pass":
                echo "[$minute'] {$attackingTeam->name} is passing the ball...\n";
                break;
            case "tackle":
                if (rand(0, 100) < $defendingTeam->defense) {
                    echo "[$minute'] {$defendingTeam->name} successfully tackles and wins possession!\n";
                } else {
                    echo "[$minute'] {$attackingTeam->name} dribbles past the defender!\n";
                }
                break;
            case "goal_attempt":
                if (rand(0, 100) < $attackingTeam->attack - ($defendingTeam->defense / 2)) {
                    echo "[$minute'] {$attackingTeam->name} takes a powerful shot... GOAL! 🎉\n";
                    $attackingTeam->score++;
                } else {
                    echo "[$minute'] {$attackingTeam->name} shoots... but the goalkeeper saves it!\n";
                }
                break;
            case "foul":
                echo "[$minute'] Foul by {$attackingTeam->name}! Free kick to {$defendingTeam->name}.\n";
                break;
        }
    }
}
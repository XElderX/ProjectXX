<?php

namespace App\Services\MatchServices;

use App\Models\Player;

class MatchEngine {
    private $team1;
    private $team2;
    private $events = ["pass", "tackle", "shot", "goal_attempt", "foul"];
    private $goalScorers = [];
    private $assistMakers = [];

    public function __construct($team1, $team2) {
        $this->team1 = $team1;
        $this->team2 = $team2;
    }

    public function simulateMatch() {
        echo "⚽ Match Started: {$this->team1->teamName} vs {$this->team2->teamName} ⚽\n\n";

        for ($minute = 1; $minute <= 90; $minute += rand(2, 5)) {
            $attackingTeam = (rand(0, 1) == 0) ? $this->team1 : $this->team2;
            $defendingTeam = ($attackingTeam === $this->team1) ? $this->team2 : $this->team1;

            $event = $this->events[array_rand($this->events)];
            $this->handleEvent($event, $attackingTeam, $defendingTeam, $minute);

            $attackingTeam->loseStamina();
            $defendingTeam->loseStamina();
        }

        // Print Final Score and Scorers/Assistants
        echo "\n⏳ Full Time! Final Score: {$this->team1->teamName} {$this->team1->score} - {$this->team2->score} {$this->team2->teamName}\n";
        $this->printGoalDetails();
    }

    private function handleEvent($event, $attackingTeam, $defendingTeam, $minute) {
        switch ($event) {
            case "pass":
                echo "[$minute'] {$attackingTeam->teamName} is passing the ball...\n";
                break;

            case "tackle":
                if (rand(0, 100) < $defendingTeam->defense) {
                    echo "[$minute'] {$defendingTeam->teamName} successfully tackles and wins possession!\n";
                } else {
                    echo "[$minute'] {$attackingTeam->teamName} dribbles past the defender!\n";
                }
                break;

            case "goal_attempt":
                $goalChance = $this->calculateGoalChance($attackingTeam, $defendingTeam);
                
                // Generate goal scorer and assist
                if (rand(0, 100) < $goalChance) {
                    echo "[$minute'] {$attackingTeam->teamName} takes a powerful shot... GOAL! 🎉\n";
                    $attackingTeam->score++;
                    
                    // Assume the first player is the scorer (simplified, you could randomize this)
                    $scorer = $attackingTeam->teamLineup[0];
                    
                    // Randomly pick an assist (for simplicity, we use the second player as the assister)
                    $assister = $attackingTeam->teamLineup[1];
                    
                    $this->goalScorers[] = $scorer;
                    $this->assistMakers[] = $assister;
                } else {
                    echo "[$minute'] {$attackingTeam->teamName} shoots... but the goalkeeper saves it!\n";
                }
                break;

            case "foul":
                echo "[$minute'] Foul by {$attackingTeam->teamName}! Free kick to {$defendingTeam->teamName}.\n";
                break;
        }
    }

    private function calculateGoalChance($attackingTeam, $defendingTeam) {
        $attackStrength = $attackingTeam->attack;
        $defenseStrength = $defendingTeam->defense;

        // Fetch goalkeeper skill from the defending team
        $goalkeeperSkill = $defendingTeam->goalkeeperSkill();

        // Increase the weight of attack, and reduce the penalty for goalkeeper's skill
        $goalChance = $attackStrength - ($defenseStrength / 2) - ($goalkeeperSkill * 0.3);  // Less heavy penalty for gk

        // Add randomness to make scoring more likely
        $goalChance += rand(5, 15);  // Add a little random variance to make scoring more frequent

        // Ensure the goal chance stays within reasonable bounds
        $goalChance = max(10, min(90, $goalChance));  // Prevent the goal chance from going below 10% or above 90%

        return $goalChance;
    }

    private function printGoalDetails() {
        echo "\n⚽ Goal Scorers and Assistants: \n";
    
        $scorersCount = count($this->goalScorers);
        for ($i = 0; $i < $scorersCount; $i++) {
            $scorer = $this->goalScorers[$i];
            $assister = $this->assistMakers[$i];
    
            // Get scorer name (retrieve from Player model if needed)
            if (is_array($scorer)) {
                // If $scorer is an array, retrieve player name using player_id
                $player = Player::find($scorer['player_id']);
      
                $scorerName = $player ? $player->getFullNameAttribute() : "Unknown Scorer";  // Default if not found
            } 
    
            // Get assister name (retrieve from Player model if needed)
            if (is_array($assister)) {
                // If $assister is an array, retrieve player name using player_id
                $player = Player::find($assister['player_id']);
                $assisterName = $player ? $player->getFullNameAttribute() : "Unknown Assister";  // Default if not found
            } 
    
            // Output the goal scorer and assister
            echo "Goal " . ($i + 1) . ": {$scorerName} (Scorer), Assisted by {$assisterName}\n";
        }
    }    
    
}

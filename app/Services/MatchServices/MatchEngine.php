<?php

namespace App\Services\MatchServices;

use App\Models\Player;

class MatchEngine
{
    private $team1;
    private $team2;
    private $events = ["pass", "tackle", "shot", "goal_attempt", "foul"];
    private $goalScorers = [];
    private $assistMakers = [];
    private $yellowCards = [];
    private $redCards = [];
    public $matchReport = [];
    private $possessionTeam1 = 50; // Initial possession for team1
    private $possessionTeam2 = 50; // Initial possession for team2

    public function __construct($team1, $team2)
    {
        $this->team1 = $team1;
        $this->team2 = $team2;
    }

    // public function getHomeGoals()
    // {
    //     return $this->team1->score;
    // }


    public function simulateMatch()
    {
        $event = "⚽ Match Started: {$this->team1->teamName} vs {$this->team2->teamName} ⚽\n\n";
        echo $event;
        $this->matchReport[] = $event;

        for ($minute = 1; $minute <= 90; $minute += rand(3, 5)) {
            $attackingTeam = (rand(0, 1) == 0) ? $this->team1 : $this->team2;
            $defendingTeam = ($attackingTeam === $this->team1) ? $this->team2 : $this->team1;

            $event = $this->events[array_rand($this->events)];
            $this->handleEvent($event, $attackingTeam, $defendingTeam, $minute);

            // Update stamina after each event
            $attackingTeam->loseStamina();
            $defendingTeam->loseStamina();
        }

        $event = "\n⏳ Full Time! Final Score: {$this->team1->teamName} {$this->team1->score} - {$this->team2->score} {$this->team2->teamName}\n";
        $this->matchReport[] = $event;
        $this->printGoalDetails();
        $this->printCardDetails();
        $this->printPossessionDetails(); // Print the possession details
    }

    private function handleEvent($event, $attackingTeam, $defendingTeam, $minute)
    {
        switch ($event) {
            case "pass":
                $event = "[$minute'] {$attackingTeam->teamName} is passing the ball...\n";
                echo $event;
                $this->matchReport[] = $event;
                $this->updatePossession($attackingTeam);
                break;

            case "tackle":
                if (rand(0, 100) < $defendingTeam->defense) {
                    $event = "[$minute'] {$defendingTeam->teamName} successfully tackles and wins possession!\n";
                    echo $event;
                    $this->matchReport[] = $event;
                    $this->updatePossession($defendingTeam);
                } else {
                    $event = "[$minute'] {$attackingTeam->teamName} dribbles past the defender!\n";
                    echo $event;
                    $this->matchReport[] = $event;
                    $this->updatePossession($attackingTeam);
                }
                break;

            case "goal_attempt":
                $goalChance = $this->calculateGoalChance($attackingTeam, $defendingTeam);
                if (rand(0, 100) < $goalChance) {
                    $this->handleGoalEvent($attackingTeam, $minute);
                } else {
                    $event = "[$minute'] {$attackingTeam->teamName} shoots... but the goalkeeper saves it!\n";
                    echo $event;
                    $this->matchReport[] = $event;
                }
                $this->updatePossession($attackingTeam); // After each shot attempt
                $attackingTeam->attempts++;
                break;

            case "foul":
                $event = "[$minute'] Foul by {$attackingTeam->teamName}! Free kick to {$defendingTeam->teamName}.\n";
                echo $event;
                $this->matchReport[] = $event;
                $this->handleCardEvent($defendingTeam, $minute);
                $this->updatePossession($defendingTeam); // After a foul, the possession usually changes
                break;
        }
    }
    private function handleCardEvent($team, $minute)
    {
        $cardChance = rand(1, 100);
        if ($cardChance <= 30) { // Lower probability for cards
            $cardType = (rand(1, 100) <= 10) ? "red" : "yellow"; // Only 10% chance for a red card

            $cardWeights = ["DEF" => 0.45, "MID" => 0.40, "FOW" => 0.15];
            $player = $this->getRandomPlayerByPosition($team, $cardWeights);

            if (!$player) return;
            $playerId = $player['player_id'];
            $playerName = Player::find($playerId)->getFullNameAttribute();

            if ($cardType === "yellow") {
                $this->yellowCards[$playerId] = ($this->yellowCards[$playerId] ?? 0) + 1;
                $event =  "🟨 [$minute'] Yellow card for {$playerName} ({$team->teamName})\n";
                echo $event;
                $this->matchReport[] = $event;
            } else {
                $this->giveRedCard($team, $playerId, $playerName, $minute);
            }
        }
    }

    private function giveRedCard($team, $playerId, $playerName, $minute)
    {
        $this->redCards[] = $playerId;
        $event =  "🟥 [$minute'] RED CARD! {$playerName} ({$team->teamName}) is sent off!\n";
        echo $event;
        $this->matchReport[] = $event;

        foreach ($team->teamLineup as $key => $player) {
            if ($player['player_id'] == $playerId) {
                unset($team->teamLineup[$key]);
                break;
            }
        }
        $team->attack *= 0.9;
        $team->midfield *= 0.9;
        $team->defense *= 0.9;
    }


    private function getRandomPlayerByPosition($team, $weights, $excludePlayer = null)
    {
        $players = $team->teamLineup;
        $weightedPlayers = [];

        foreach ($players as $player) {
            $position = strtoupper($player['position']);

            // Skip if the player is the same as the excluded player (e.g., for selecting an assister)
            if ($excludePlayer && $player['player_id'] == $excludePlayer['player_id']) {
                continue;
            }

            if (isset($weights[$position])) {
                // Add the player to the list multiple times based on the weight for their position
                for ($i = 0; $i < $weights[$position] * 10; $i++) {
                    $weightedPlayers[] = $player;
                }
            }
        }

        // If there are weighted players, pick one at random
        return count($weightedPlayers) > 0 ? $weightedPlayers[array_rand($weightedPlayers)] : null;
    }

    private function updatePossession($team)
    {
        if ($team === $this->team1) {
            $diff = rand(1, 3);
            $this->possessionTeam1 += $diff; // Increase possession for team1 by 1-3%
            $this->possessionTeam2 -= $diff; // Decrease possession for team2 by 1-3%
        } else {
            $diff = rand(1, 3);
            $this->possessionTeam2 += $diff; // Increase possession for team2 by 1-3%
            $this->possessionTeam1 -= $diff; // Decrease possession for team1 by 1-3%
        }

        // Ensure possession stays between 0% and 100%
        $this->possessionTeam1 = max(0, min(100, $this->possessionTeam1));
        $this->possessionTeam2 = max(0, min(100, $this->possessionTeam2));
    }

    private function printPossessionDetails()
    {
        echo "\n🏆 Ball Possession:\n";
        echo "{$this->team1->teamName}: " . round($this->possessionTeam1, 2) . "%\n";
        echo "{$this->team2->teamName}: " . round($this->possessionTeam2, 2) . "%\n";
    }

    private function calculateGoalChance($attackingTeam, $defendingTeam)
    {
        $attackStrength = $attackingTeam->attack * rand(80, 120) / 100;
        $defenseStrength = $defendingTeam->defense * rand(80, 120) / 100;
        return max(5, min(80, ($attackStrength / ($attackStrength + $defenseStrength)) * 100));
    }

    private function handleGoalEvent($attackingTeam, $minute)
    {
        $event = "[$minute'] {$attackingTeam->teamName} takes a powerful shot... GOAL! 🎉\n";
        echo $event;
        $this->matchReport[] = $event;
        $attackingTeam->score++;

        // Define the scorer and assister weights
        $scorerWeights = ["FOW" => 0.65, "MID" => 0.25, "DEF" => 0.10];
        $assistWeights = ["MID" => 0.45, "DEF" => 0.25, "FOW" => 0.25, "GK" => 0.05];

        // Select the scorer using weighted positions
        $scorer = $this->getRandomPlayerByPosition($attackingTeam, $scorerWeights);

        // Select the assister, ensuring they aren't the same player as the scorer
        $assister = $this->getRandomPlayerByPosition($attackingTeam, $assistWeights, $scorer);

        // If no assister was selected (in case of no available player from that position), choose another random assister
        if (!$assister) {
            $assister = $this->getRandomPlayerByPosition($attackingTeam, $assistWeights);
        }

        // Fetch the actual player objects from the database
        $scorer = Player::find($scorer['player_id']);
        $assister = Player::find($assister['player_id']);

        // Store the goal and assist in a single array
        $this->goalScorers[] = [
            'scorer' => $scorer->id,
            'assister' => $assister->id,
            'time' => $minute,  // Store the time of the goal
        ];

        // Update the teamLineup to include the goal and assist
        foreach ($attackingTeam->teamLineup as $key => $player) {
            if ($player['player_id'] == $scorer->id) {
                $attackingTeam->teamLineup[$key]['goals']++;
            }
            if ($player['player_id'] == $assister->id) {
                $attackingTeam->teamLineup[$key]['assists']++;
            }
        }

        // Output the details
        $event = "⚽ Goal Scorer: {$scorer->getFullNameAttribute()} | 🅰 Assisted by: {$assister->getFullNameAttribute()}\n";
        echo $event;
        $this->matchReport[] = $event;
    }

    private function printCardDetails()
    {
        echo "\n🟨🟥 Disciplinary Report:\n";

        foreach ($this->yellowCards as $playerId => $count) {
            $player = Player::find($playerId);
            echo "🟨 {$player->getFullNameAttribute()} received {$count} yellow card(s).\n";
        }

        foreach ($this->redCards as $playerId) {
            $player = Player::find($playerId);
            echo "🟥 {$player->getFullNameAttribute()} received a RED card!\n";
        }
    }

    private function printGoalDetails()
    {
        echo "\n⚽ Goal Scorers and Assistants: \n";

        // Loop through the goalScorers array
        foreach ($this->goalScorers as $index => $goalDetails) {
            // Retrieve the scorer and assister using the stored IDs
            $scorer = Player::find($goalDetails['scorer']);
            $assister = Player::find($goalDetails['assister']);

            $scorerTeam = ($scorer->club_id == $this->team1->teamId) ? $this->team1->teamName : $this->team2->teamName;
            $assisterTeam = ($assister->club_id == $this->team1->teamId) ? $this->team1->teamName : $this->team2->teamName;

            // Display the goal and assist details with team names and the time of the goal
            echo "⚽ Goal " . ($index + 1) . " at {$goalDetails['time']}': {$scorer->getFullNameAttribute()} ({$scorerTeam}) (Scorer), 🅰 Assisted by: {$assister->getFullNameAttribute()} ({$assisterTeam})\n";
        }
    }
}

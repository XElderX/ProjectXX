<?php

namespace App\Services\MatchServices;

use App\Models\Club;
use App\Models\Player;

class Team
{
    public $teamId;
    public $teamName;
    public $teamLineup;
    public $tactic;

    public $attack = 0;
    public $midfield = 0;
    public $defense = 0;
    public $stamina = 0;
    public $score = 0;

    private const SKILL_PROPORTIONS = [
        'gk' => ['gk' => 0.7, 'pace' => 0.2, 'pass' => 0.1],
        'def' => ['def' => 0.45, 'pm' => 0.1, 'tech' => 0.05, 'heading' => 0.2, 'pass' => 0.1, 'pace' => 0.1],
        'mid' => ['def' => 0.1, 'pace' => 0.1, 'pass' => 0.25, 'tech' => 0.2, 'heading' => 0.05, 'pm' => 0.3],
        'fow' => ['pace' => 0.25, 'pass' => 0.05, 'tech' => 0.15, 'heading' => 0.2, 'str' => 0.35],
    ];

    public function __construct($teamId, $teamLineup, $tactic)
    {
        $this->teamId = $teamId;
        $this->teamLineup = json_decode($teamLineup, true); // Decode JSON lineup
        $this->tactic = $tactic;

        // Get team name
        $club = Club::find($teamId);
        $this->teamName = $club ? $club->club_name : "Unknown Team";

        // Load players & calculate team stats
        $this->calculateTeamStrength();
    }

    private function calculateTeamStrength()
    {
        $totalAttack = 0;
        $totalMidfield = 0;
        $totalDefense = 0;
        $totalStamina = 0;
        $playerCount = count($this->teamLineup);

        foreach ($this->teamLineup as $playerData) {
            $player = Player::find($playerData['player_id']);

            if (!$player) {
                continue;
            }

            // Use position from playerData, not player model
            $position = strtolower($playerData['position']);

            // Determine position-based contribution
            switch ($position) {
                case 'gk':
                    $skillWeights = self::SKILL_PROPORTIONS['gk'];
                    break;
                case 'def':
                    $skillWeights = self::SKILL_PROPORTIONS['def'];
                    break;
                case 'mid':
                    $skillWeights = self::SKILL_PROPORTIONS['mid'];
                    break;
                case 'fow':
                    $skillWeights = self::SKILL_PROPORTIONS['fow'];
                    break;
                default:
                    $skillWeights = [];
            }

            $attack = 0;
            $midfield = 0;
            $defense = 0;

            foreach ($skillWeights as $skill => $weight) {
                // Goalkeepers: Defense & Midfield contributions  
                if ($position == 'gk') {
                    if ($skill == 'gk') {
                        $defense += $player->$skill * $weight; // Main shot-stopping skill
                    } elseif (in_array($skill, ['pace', 'pass'])) {
                        $midfield += $player->$skill * $weight; // Helps with distribution
                    }
                }
                // Strikers: Attack contributions  
                elseif ($position == 'fow') {
                    if (in_array($skill, ['str', 'heading', 'pace', 'tech'])) {
                        $attack += $player->$skill * $weight; // Goal-scoring attributes
                    } elseif ($skill == 'pass') {
                        $midfield += $player->$skill * $weight; // Playmaking ability
                    }
                }
                // Midfielders: Midfield & Attack  
                elseif ($position == 'mid') {
                    if (in_array($skill, ['pm', 'pass', 'tech'])) {
                        $midfield += $player->$skill * $weight;
                    } elseif ($skill == 'pace') {
                        $attack += $player->$skill * $weight; // Dribbling threat
                    }
                }
                // Defenders: Defense & Midfield  
                elseif ($position == 'def') {
                    if ($skill == 'def') {
                        $defense += $player->$skill * $weight;
                    } elseif (in_array($skill, ['pm', 'pass', 'tech', 'heading', 'pace'])) {
                        $midfield += $player->$skill * $weight;
                    }
                }
            }

            // Sum player contributions
            $totalAttack += $attack;
            $totalMidfield += $midfield;
            $totalDefense += $defense;
            $totalStamina += $player->stamina;
         
        }

        // Assign final team stats
        $this->attack = $playerCount > 0 ? round($totalAttack / $playerCount, 2) : 0;
        $this->midfield = $playerCount > 0 ? round($totalMidfield / $playerCount, 2) : 0;
        $this->defense = $playerCount > 0 ? round($totalDefense / $playerCount, 2) : 0;
        $this->stamina = $playerCount > 0 ? round($totalStamina / $playerCount, 2) : 0;
    }

    public function loseStamina() {
        $this->stamina -= rand(1, 5); // Lose 1-5 stamina per event
        if ($this->stamina < 0) {
            $this->stamina = 0;
        }
    }

    public function goalkeeperSkill() {
        // Assuming the goalkeeper is the first player in the lineup
        $goalkeeperData = $this->teamLineup[0];  // This contains the player data (player_id, position, etc.)
    
        // Fetch the full player object from the database using the player_id
        $goalkeeper = Player::find($goalkeeperData['player_id']);
    
        // Ensure the goalkeeper exists and has the 'gk' skill
        if ($goalkeeper) {
            return $goalkeeper->gk; // This assumes the 'gk' skill is a property on the Player model
        } else {
            return 0; // Default to 0 if the goalkeeper is not found or lacks the skill
        }
    }
    
}

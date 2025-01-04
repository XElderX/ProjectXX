<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $country = (count(Country::all()) < 1) 
        ? $country = Country::factory()->create()
        : $country = Country::all()
        ->random();

        $age = rand(14, 38);
        $position = Player::PLAYER_POSITIONS[(rand(1, count(Player::PLAYER_POSITIONS)))-1]; // generate favourite player' position
        $skillPoints = rand(($age-5), ($age+10));
        echo 'position: ' . $position . ' with: ' . $skillPoints . " -";
        $skillArr = [];

        switch ($position) {
            case Player::POSITION_GK:
                $skillPoints = $skillPoints;
                $skillPriority = [0.7, 0, 0, 0.2, 0, 0.1, 0, 0];
               for ($i=0; $i < 8; $i++) { 
                ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                $skillPoints = $skillPoints - $skillValue;
                echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
                array_push($skillArr, $skillValue);
            }
                break;
            case Player::POSITION_DEF:
                $skillPoints = $skillPoints;
                $skillPriority = [0, 0.45, 0.1, 0.1, 0.05, 0.1, 0.2, 0];
               for ($i=0; $i < 8; $i++) {
                ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                $skillPoints = $skillPoints - $skillValue;
                echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
                array_push($skillArr, $skillValue);
            }
                break;
            case Player::POSITION_DEF_WING:
                $skillPoints = $skillPoints;
                $skillPriority = [0, 0.35, 0.05, 0.25, 0.2, 0.15, 0.05, 0];
                for ($i=0; $i < 8; $i++) {
                    ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                 $skillPoints = $skillPoints - $skillValue;
                 echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
                 array_push($skillArr, $skillValue);
                }
                break;
            case Player::POSITION_MID_WING:
                $skillPoints = $skillPoints;
                $skillPriority = [0, 0.1, 0.1, 0.3, 0.2, 0.25, 0, 0.05];
                for ($i=0; $i < 8; $i++) { 
                    ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                 $skillPoints =- $skillValue;
                 echo '>>>' . $skillPoints;
                 array_push($skillArr, $skillValue);
                }
                break;
            case Player::POSITION_DM:
                $skillPoints = $skillPoints;
                $skillPriority = [0, 0.2, 0.25, 0.15, 0.2, 0.15, 0.05, 0];
                for ($i=0; $i < 8; $i++) { 
                 ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                 $skillPoints = $skillPoints - $skillValue;
                 echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
                 array_push($skillArr, $skillValue);
                }
                break;
            case Player::POSITION_MID:
                $skillPoints = $skillPoints;
                $skillPriority = [0, 0.1, 0.3, 0.1, 0.2, 0.25, 0.05, 0];
                for ($i=0; $i < 8; $i++) { 
                 ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                 $skillPoints = $skillPoints - $skillValue;
                 echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
                 array_push($skillArr, $skillValue);
                }
                break;
            case Player::POSITION_AM:
                $skillPoints = $skillPoints;
                $skillPriority = [0, 0.05, 0.20, 0.15, 0.2, 0.25, 0.05, 0.05];
                for ($i=0; $i < 8; $i++) { 
                 ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                 $skillPoints = $skillPoints - $skillValue;
                 echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
                 array_push($skillArr, $skillValue);
                }
                break;
            case Player::POSITION_STR:
                $skillPoints = $skillPoints;
                $skillPriority = [0, 0, 0, 0.25, 0.15, 0.05, 0.2, 0.35];
                for ($i=0; $i < 8; $i++) { 
                ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
                 $skillPoints = $skillPoints - $skillValue;
                 echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
                 array_push($skillArr, $skillValue);
                }
                break;

            default:
            $skillPriority = [0, 0, 0, 0, 0, 0, 0, 0];
            for ($i=0; $i < 8; $i++) { 
             ($skillPoints > 25) ? $skillValue = rand(0 * 10, (25 * $skillPriority[$i])  * 10)/10  : $skillValue = rand(0, ($skillPoints*$skillPriority[$i]) * 10) / 10;
             $skillPoints = $skillPoints - $skillValue;
             echo ' || skillvalue is: ' . $skillValue . '>>>' . $i . '<<<' . '---->' . $skillPoints . '|||';
             array_push($skillArr, $skillValue);
            }
                break;
        }
        echo 'remaining points = ' . $skillPoints . 'all skills: ';
        foreach ($skillArr as $key => $value) {
            echo $key . ' #' . $value . '???';
            # code...
        }

        return [
         
            'first_name'  => $this->faker->name(),
            'last_name'   => $this->faker->lastName(),
            'value'       => 0,
            'salary'      => 0,
            'height'      => rand(150, 220),
            'weight'      => rand(60, 100),
            'age'         => $age,
            'potential'   => rand(0, 100),
            'bookings'    => 0,
            'injury_days' => 0,
            'fatique'     => 100,
            'position'    => $position,

            'club_id'     => null,
            'country_id'  => $country->id,
        

            //stats
            'gk'      => ($skillArr[0] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[0],//goalkeeping skill
            'def'     => ($skillArr[1] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[1],//defending
            'pm'      => ($skillArr[2] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[2],//playmaking
            'pace'    => ($skillArr[3] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[3],//pace- how quickly moves
            'tech'    => ($skillArr[4] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[4],// technique
            'pass'    => ($skillArr[5] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[5],//passing
            'heading' => ($skillArr[6] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[6],//header
            'str'     => ($skillArr[7] == 0) ? rand(0, ($skillPoints * 0.33) * 10) / 10 : $skillArr[7],//striking
            'stamina' => rand(0, $skillPoints),

            'exp'     => rand(1, 10),
            'lead'    => rand(1, 10),//leadership

            'form'    => rand(1, 10),// current form. how good in shape
 
    
        ];
    }
}

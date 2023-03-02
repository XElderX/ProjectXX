<?php

namespace App\Services\PlayerServices;

use App\Models\Name;
use App\Models\Player;
use App\Models\Surname;

class BasePlayerProcessService
{
    /**
     * @var Player
     */
    protected $player;

    protected $repeat;
    protected $expp;

    public function __construct()
    {
        $this->player = new Player();
        $this->repeat = false;
        $this->expp = null;
    }

    protected function setFirstName($country_id)
    {
        $names = Name::where('country_id', $country_id)->get();
        $arrayNames = [];

        foreach ($names as $name) {
            $arrayNames[$name->name] = $name->popularity;
        }
        $totalOdds = array_sum($arrayNames);
        $randomNumberValue = rand(1, $totalOdds);

        foreach ($names as $name) {
            $randomNumberValue -= $name->popularity;
            if ($randomNumberValue <= 0) {
                return $name->name;
            }
        }
    }

    protected function setLastName($country_id)
    {
        $surnames = Surname::where('country_id', $country_id)->get();
        $arraySurnames = [];

        foreach ($surnames as $surname) {
            $arraySurnames[$surname->surname] = $surname->popularity;
        }
        $totalOdds = array_sum($arraySurnames);
        $randomNumberValue = rand(1, $totalOdds);

        foreach ($surnames as $surname) {
            $randomNumberValue -= $surname->popularity;
            if ($randomNumberValue <= 0) {
                return $surname->surname;
            }
        }
    }

    protected function randomizer(string $type, int $randomValue, int $height = null, bool $repeated = false): int
    {
        if ($type === 'height') {
            if ($randomValue == 1) {
                return rand(150, 170);
            }
            if ($randomValue == 2 || $randomValue == 4) {
                return rand(171, 181);
            }
            if ($randomValue == 3 || $randomValue == 6) {
                return rand(182, 195);
            }
            if ($randomValue == 5) {
                return rand(196, 205);
            }
            if ($randomValue == 0) {
                if ($repeated == false) {
                    $this->repeat = true; // test
                    $this->randomizer($type, $randomValue, $height, true);
                }
                return rand(205, 215);
            }
        }

        if ($type === 'weight') {
            if ($randomValue == 1) {
                if ($height < 181) {
                    return rand(60, 70);
                }
                return rand(65, 74);
            }
            if ($randomValue == 2 || $randomValue == 4) {
                if ($height < 181) {
                    return rand(70, 78);
                }
                return rand(75, 80);
            }
            if ($randomValue == 3 || $randomValue == 6) {
                if ($height < 181) {
                    return rand(79, 85);
                }
                return rand(81, 94);
            }
            if ($randomValue == 5) {
                if ($height < 181) {
                    return rand(86, 95);
                }
                return rand(95, 105);
            }
            if ($randomValue == 0) {
                if ($repeated == false) {
                    $this->repeat = true; //test
                    $this->randomizer($type, $randomValue, $height, true);
                }
                return rand(96, 120);
            }
        }
    }

    protected function setPotential(int $age, bool $repeated = false): int
    {
        if ($age > 30) {
            return 0;
        }

        $rand = rand(1, 5);

        if ($age <= 22) {
            if ($rand == 1) {
                return rand(40, 60);
            }
            if ($rand == 2 || $rand == 5) {
                return rand(61, 81);
            }
            if ($rand == 3) {
                return rand(82, 94);
            }
            if ($rand == 4) {
                return rand(95, 100);
            }
        } elseif ($age > 22 && $age <= 25) {
            if ($rand == 1) {
                return rand(30, 45);
            }
            if ($rand == 2 || $rand == 5) {
                return rand(46, 71);
            }
            if ($rand == 3) {
                return rand(72, 80);
            }
            if ($rand == 4) {
                return rand(81, 100);
            }
        } elseif ($age >= 26 && $age <= 30) {
            if ($rand == 1) {
                return rand(10, 35);
            }
            if ($rand == 2 || $rand == 5) {
                return rand(36, 60);
            }
            if ($rand == 3) {
                return rand(61, 80);
            }
            if ($rand == 4) {
                if ($repeated == false) {
                    $this->repeat = true; //test
                    $this->setPotential($age, true);
                }
                return rand(81, 85);
            }
        }
    }

    protected function setExperience(int $age, bool $repeated = false)
    {
        $rand = rand(1, 5);

        if ($age <= 15) {
            $this->expp = 0;
            return (rand(0, 5000) / 10000);
        } elseif ($age <= 20) {
            if ($rand == 1) {
                $this->expp = 3;
                return (rand(10000, 15000) / 10000);
            }
            if ($rand == 2 && $rand == 4) {
                $this->expp = 4;
                return (rand(0, 10000) / 10000);
            }
            if ($rand == 3) {
                $this->expp = 5;
                return (rand(15000, 20000) / 10000);
            }
            if ($rand == 5) {
                $this->expp = 6;
                return (rand(20000, 30000) / 10000);
            }
        } elseif ($age < 28) {
            if ($rand == 1) {
                $this->expp = 7;
                return (rand(15000, 20000) / 10000);
            }
            if ($rand == 2 && $rand == 4) {
                $this->expp = 8;
                return (rand(20000, 40000) / 10000);
            }
            if ($rand == 3) {
                $this->expp = 9;
                return (rand(40000, 70000) / 10000);
            }
            if ($rand == 5) {
                if ($repeated == false) {
                    $this->expp = 10;
                    $this->repeat = true; //test
                    $this->setExperience($age, true);
                }
                $this->expp = 11;
                return (rand(70000, 80000) / 10000);
            }
        } elseif ($age >= 28) {
            $this->expp = 1;
            return (rand(20000, 90000) / 10000);
        }
        $this->expp = $age;
    }

    protected function setLeadership(): int
    {
        $prob = [
            '0'  => 5,  '1'  => 10,
            '2'  => 10, '3'  => 15,
            '4'  => 15, '5'  => 20,
            '6'  => 10, '7'  => 5,
            '8'  => 5,  '9'  => 3,
            '10' => 2,
        ];

        $rand = mt_rand(0, 100);

        foreach ($prob as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }

    protected function resolveSkill(string $position, int $age, string $skill)
    {
        if ($skill === 'stamina') {
            return mt_rand(10000, 200000) / 10000;
        }

        $rand = $this->skillRandomizer($position, $skill);

        if ($age <= 16) {
            return $rand / 3;
        } elseif ($age <= 19) {
            return $rand / 2;
        } elseif ($age <= 22) {
            return $rand / 1.5;
        } else {
            return $rand;
        }
    }

    protected function favPosition(string $position): array
    {
        switch ($position) {
            case Player::POSITION_AM:
                return $skillPack = [
                    'gk' => 0, 'def' => 0.05, 'pm' => 0.20,
                    'pace' => 0.15, 'tech' => 0.2, 'pass' => 0.25,
                    'heading' => 0.05, 'str' => 0.05
                ];
                break;

            case Player::POSITION_DEF:
                return $skillPack = [
                    'gk' => 0, 'def' => 0.45, 'pm' => 0.1,
                    'pace' => 0.1, 'tech' => 0.05, 'pass' => 0.1,
                    'heading' => 0.2, 'str' => 0
                ];
                break;

            case Player::POSITION_DEF_WING:
                return $skillPack = [
                    'gk' => 0, 'def' => 0.35, 'pm' => 0.05,
                    'pace' => 0.25, 'tech' => 0.2, 'pass' => 0.15,
                    'heading' => 0.05, 'str' => 0
                ];
                break;

            case Player::POSITION_DM:
                return $skillPack = [
                    'gk' => 0, 'def' => 0.2, 'pm' => 0.25,
                    'pace' => 0.15, 'tech' => 0.2, 'pass' => 0.15,
                    'heading' => 0.05, 'str' => 0
                ];
                break;

            case Player::POSITION_GK:
                return $skillPack = [
                    'gk' => 0.7, 'def' => 0, 'pm' => 0,
                    'pace' => 0.2, 'tech' => 0, 'pass' => 0.1,
                    'heading' => 0, 'str' => 0
                ];
                break;

            case Player::POSITION_MID:
                return $skillPack = [
                    'gk' => 0, 'def' => 0.1, 'pm' => 0.3,
                    'pace' => 0.1, 'tech' => 0.2, 'pass' => 0.25,
                    'heading' => 0.05, 'str' => 0
                ];
                break;

            case Player::POSITION_MID_WING:
                return $skillPack = [
                    'gk' => 0, 'def' => 0.1, 'pm' => 0.1,
                    'pace' => 0.3, 'tech' => 0.2, 'pass' => 0.25,
                    'heading' => 0, 'str' => 0, 05
                ];
                break;

            case Player::POSITION_STR:
                return $skillPack = [
                    'gk' => 0, 'def' => 0, 'pm' => 0,
                    'pace' => 0.25, 'tech' => 0.15, 'pass' => 0.05,
                    'heading' => 0.2, 'str' => 0.35
                ];
                break;

            default:
                # code...
                break;
        }
    }

    protected function skillRandomizer(string $position, string $skill)
    {
        $favouritePosition = $this->favPosition($position);

        if ($favouritePosition[$skill] == 0) {
            return mt_rand(1, 50000) / 10000;
        } elseif ($favouritePosition[$skill] <= 0.1) {
            return mt_rand(20000, 100000) / 10000;
        } elseif ($favouritePosition[$skill] <= 0.2) {
            return mt_rand(30000, 130000) / 10000;
        } elseif ($favouritePosition[$skill] <= 0.3) {
            return mt_rand(40000, 150000) / 10000;
        } elseif ($favouritePosition[$skill] <= 0.4) {
            return mt_rand(50000, 170000) / 10000;
        } elseif ($favouritePosition[$skill] <= 0.5) {
            return mt_rand(60000, 190000) / 10000;
        } elseif ($favouritePosition[$skill] <= 0.6) {
            return mt_rand(70000, 210000) / 10000;
        } elseif ($favouritePosition[$skill] <= 0.7) {
            return mt_rand(80000, 230000) / 10000;
        } else {
            return mt_rand(1, 50000) / 10000;
        }
    }

    protected function salaryResolver ($player): int 
    {
        $skillValue = [
            'gk' => 500, 'def' => 350, 'pm' => 300,
            'pace' => 200, 'tech' => 200, 'pass' => 200,
            'heading' => 200, 'str' => 350, 'stamina' => 100,
            'lead' => 150, 'exp' => 200
        ];
        $salary = 0;

        foreach ($skillValue as $key => $value) {
            $salary += ($player->$key * $value);
        }
        if ($player->age < 16) {
            return round($salary * 0.4);
        } elseif ($player->age < 18) {
            return round($salary * 0.6);
        } elseif ($player->age < 21) {
            return round($salary * 0.8);
        } else return round($salary);
    }

    protected function valueResolver ($player): int 
    {
        $skillValue = [
            'gk' => 37500, 'def' => 30000, 'pm' => 26250,
            'pace' => 20500, 'tech' => 20500, 'pass' => 20500,
            'heading' => 20500, 'str' => 30000, 'stamina' => 10000,
            'lead' => 8000, 'exp' => 10000, 'form' => 8000
        ];

        $playerValue = 0;

        foreach ($skillValue as $key => $value) {
            $playerLvl = floor($player->$key * 100) / 100; 
            for ($i=0; $i <= $playerLvl; $i++) { 
                $playerValue += ( $value * $i);
            }
        }

        if ($player->age < 16) {
            return round($playerValue * 1.5);
        } elseif ($player->age < 18) {
            return round($playerValue * 1.3);
        } elseif ($player->age < 21) {
            return round($playerValue * 1.15);
        } elseif ($player->age > 30) {
            return round($playerValue * 0.8);
        } else return round($playerValue);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public const POSITION_GK = 'goalkeeper'; //gk 70%; pace 20%; pass 10%;
    public const POSITION_DEF = 'defender'; // Def 45%; pm 10% tech 5% head 20% pass 10% pace 10%; pm 10%;stri 0
    public const POSITION_DEF_WING = 'winger_defender'; // Def 35%; pace 25%; pass 15% tech 15%; head 5%; pm 5%; stri 0
    public const POSITION_MID_WING = 'winger_midfielder';//Def 10%; pace 30%; pass 25%; tech 20%  head 0%  pm 10% str 5% ;
    public const POSITION_DM = 'def_midfield'; // def 20%; pace 15%; pass 15%; tech 20%; head 5%; pm 25%; stri 0;
    public const POSITION_MID = 'midfielder'; // def 10%; pace 10%; pass 25% tech 20% head 5%; pm 30% stri;
    public const POSITION_AM = 'att_midfield';// def 5%; pace 15% pass 30% tech 20% head 5% pm 20% stri 5%
    public const POSITION_STR = 'striker'; //def 0; pace 25%; pass 5%; tech 15%; head 20%; pm 0; stri 35% 

    public const TYPE_PLAYER = 'player';
    public const TYPE_YOUTH = 'youth';
    public const TYPE_TRAINER = 'coach';

    public const PLAYER_POSITIONS = [
        self::POSITION_GK, self::POSITION_DEF,
        self::POSITION_DEF_WING, self::POSITION_MID_WING, 
        self::POSITION_DM, self::POSITION_MID, 
        self::POSITION_AM, self::POSITION_STR, 
    ];

    public const NPC_TYPES = [
        self::TYPE_PLAYER, self::TYPE_YOUTH,
        self::TYPE_TRAINER
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'value',
        'salary',
        'height',
        'weight',
        'age',
        'potential',
        'bookings',
        'injury_days',
        'fatigue',
        'position',

        'gk',//0
        'def',//1
        'pm',//2
        'pace',//3
        'tech',//4
        'pass',//5
        'heading',//6
        'str',//7

        'stamina',//8
        'exp',
        'lead',
        'form',
        'club_id',
        'country_id',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}

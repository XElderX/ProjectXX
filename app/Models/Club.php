<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    public const MOOD_FURIOUS = 'furious';
    public const MOOD_HOPELESS = 'hopeless';
    public const MOOD_DISAPPOINTED = 'disappointed';
    public const MOOD_CALM = 'calm';
    public const MOOD_HAPPY = 'happy';
    public const MOOD_VERY_HAPPY = 'very_happy';
    public const MOOD_DREAMIOUS = 'dream';
    
    public const SUPPORTERS_MOOD = [
        self::MOOD_FURIOUS, self::MOOD_HOPELESS,
        self::MOOD_DISAPPOINTED, self::MOOD_CALM, 
        self::MOOD_HAPPY, self::MOOD_VERY_HAPPY, 
        self::MOOD_DREAMIOUS
    ];

    public const TABLE_NAME = 'clubs';

    protected $fillable = [
        'club_name',
        'club_rating_points',
        'club_rank',

        'supporters',
        'supporters_mood',
        'budget',
        
        'town_id',
        'country_id',
        'user_id',
    ];

    public function town(){
        return $this->belongsTo(Town::class);
    }
    
    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function player(){
        return $this->hasMany(Player::class);
    }
}

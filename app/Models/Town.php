<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    public const WEATHER_SUNNY = 'sunny';
    public const WEATHER_SUNNY_HOT = 'sunny_hot';

    public const WEATHER_WARM_CLOUD = 'warm_cloud';
    public const WEATHER_COLD_CLOUD = 'cold_cloud';
    public const WEATHER_CLOUDY = 'cloudy';

    public const WEATHER_MILD_RAIN = 'slightly_rain';
    public const WEATHER_RAIN = 'moderate_rain';
    public const WEATHER_HEAVY_RAIN = 'heavy_raining';

    public const WEATHER_SNOWY = 'snowy';
    public const WEATHER_SNOW_FALL = 'snow_fall';

    public const WEATHER = [
        self::WEATHER_SUNNY, self::WEATHER_SUNNY_HOT,
        self::WEATHER_WARM_CLOUD, self::WEATHER_COLD_CLOUD, 
        self::WEATHER_CLOUDY, self::WEATHER_MILD_RAIN, 
        self::WEATHER_RAIN, self::WEATHER_HEAVY_RAIN,
        self::WEATHER_SNOWY, self::WEATHER_SNOW_FALL
    ];

    protected $fillable = [
        'town_name',
        'population',
        'weather',
        'country'
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function club(){
        return $this->hasMany(Club::class);
    }


}

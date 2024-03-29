<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'population',
        'flag',
    ];

    public function town(){
        return $this->hasMany(Town::class);
    }

     public function townClub()
    {
        return $this->hasManyThrough(Town::class, Club::class);
    }

      /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->country;
    }



}

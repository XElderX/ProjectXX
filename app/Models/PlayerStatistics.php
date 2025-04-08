<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerStatistics extends Model
{
    use HasFactory;

    // Define the table name (in case it's different from the plural of the model name)
    protected $table = 'player_statistics';

    // Define the fillable columns (optional, depending on your use case)
    protected $fillable = [
        'player_id',
        'friendly_goals',
        'friendly_assists',
        'league_goals',
        'league_assists',
        'season_friendly_goals',
        'season_friendly_assists',
        'season_league_goals',
        'season_league_assists',
        'season_league_yellow_cards',
        'season_league_red_cards',
        'last_season_friendly_goals',
        'last_season_friendly_assists',
        'last_season_league_goals',
        'last_season_league_assists',
    ];

    // The timestamps (created_at, updated_at) are handled automatically by Eloquent, so you can skip them unless you need custom behavior
    public $timestamps = true;

    // Define the inverse of the relationship with Player (One to One)
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

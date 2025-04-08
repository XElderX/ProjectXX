<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerStatisticsTable extends Migration
{
    public function up()
    {
        Schema::create('player_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            
            // Total stats
            $table->integer('friendly_goals')->default(0);
            $table->integer('friendly_assists')->default(0);
            $table->integer('league_goals')->default(0);
            $table->integer('league_assists')->default(0);
            
            // This season's stats
            $table->integer('season_friendly_goals')->default(0);
            $table->integer('season_friendly_assists')->default(0);
            $table->integer('season_league_goals')->default(0);
            $table->integer('season_league_assists')->default(0);
            $table->integer('season_league_yellow_cards')->default(0);
            $table->integer('season_league_red_cards')->default(0);
            //last season stats
            $table->integer('last_season_friendly_goals')->default(0);
            $table->integer('last_season_friendly_assists')->default(0);
            $table->integer('last_season_league_goals')->default(0);
            $table->integer('last_season_league_assists')->default(0);

            
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('player_statistics');
    }
}

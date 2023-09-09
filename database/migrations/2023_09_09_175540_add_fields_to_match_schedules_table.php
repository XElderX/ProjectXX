<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('match_schedules', function (Blueprint $table) {
            $table->integer('home_goals')->nullable();
            $table->integer('away_goals')->nullable();
            $table->integer('home_shots')->nullable();
            $table->integer('away_shots')->nullable();
            $table->integer('home_on_target')->nullable();
            $table->integer('away_on_target')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('match_schedules', function (Blueprint $table) {
            $table->dropColumn(['home_goals', 'away_goals', 'home_shots', 'away_shots', 'home_on_target', 'away_on_target']);
        });
    }
};

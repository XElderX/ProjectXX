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
        Schema::create('match_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->bigInteger('home_team_id')->unsigned()->nullable();
            $table->bigInteger('away_team_id')->unsigned()->nullable();
            $table->integer('attendance')->nullable();
            $table->string('weather')->nullable();
            $table->foreign('home_team_id')->references('id')->on('clubs')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('away_team_id')->references('id')->on('clubs')->onDelete('set null')->onUpdate('cascade');
            $table->text('report')->nullable();
            $table->string('home_tactic')->nullable();
            $table->string('away_tactic')->nullable();
            $table->string('home_lineup')->nullable();
            $table->string('away_lineup')->nullable();
            $table->string('status');
            $table->boolean('complete');
            $table->date("match_date")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_schedules');
    }
};

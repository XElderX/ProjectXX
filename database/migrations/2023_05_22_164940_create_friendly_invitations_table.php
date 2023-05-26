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
        Schema::create('friendly_invitations', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->boolean('public');
            $table->boolean('host_vanue');
            $table->string('status');
            $table->bigInteger('host_id')->unsigned();
            $table->bigInteger('host_team_id')->unsigned();
            $table->bigInteger('opponent_team_id')->unsigned()->nullable();
            $table->date("match_date")->nullable();

            $table->foreign('host_id')->references('id')->on('users');
            $table->foreign('host_team_id')->references('id')->on('clubs');
            $table->foreign('opponent_team_id')->references('id')->on('clubs');

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
        Schema::dropIfExists('friendly_invitations');
    }
};

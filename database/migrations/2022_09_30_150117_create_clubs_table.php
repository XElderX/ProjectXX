<?php

use App\Models\Club;
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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('club_name')->unique();
            $table->integer('club_rating_points')->default(0);
            $table->integer('club_rank')->nullable();
            $table->integer('supporters')->default(100);
            $table->string('supporters_mood')->default(Club::MOOD_CALM);
            $table->integer('budget')->default(300000);
            
            $table->biginteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('restrict');

            $table->biginteger('town_id')->unsigned();
            $table->foreign('town_id')->references('id')->on('towns')->onDelete('cascade')->onUpdate('restrict');

            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');

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
        Schema::dropIfExists('clubs');
    }
};

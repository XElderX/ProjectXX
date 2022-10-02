<?php

use App\Models\Town;
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
        Schema::create('towns', function (Blueprint $table) {
            $table->id();
            $table->string('town_name')->unique();
            $table->bigInteger('country_id')->unsigned();
            $table->integer('population')->default(5000);
            $table->string('weather')->default(Town::WEATHER_WARM_CLOUD);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('towns');
    }
};

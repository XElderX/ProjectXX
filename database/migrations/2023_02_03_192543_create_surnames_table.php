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
        Schema::create('surnames', function (Blueprint $table) {
            $table->id();
            $table->string('surname')->index();
            $table->bigInteger('country_id')->unsigned();
            $table->integer('popularity')->default(5);
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
        Schema::dropIfExists('surnames');
    }
};

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
            $table->json('report')->change();
            $table->json('home_lineup')->change();
            $table->json('away_lineup')->change();
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
            $table->text('report')->change();
            $table->text('home_lineup')->change();
            $table->text('away_lineup')->change();
        });
    }
};

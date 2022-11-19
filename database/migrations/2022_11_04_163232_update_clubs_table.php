<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->biginteger('town_id')->nullable()->unsigned()->change();
            $table->biginteger('user_id')->nullable()->unsigned()->change();

            $table->dropForeign(['town_id']);
            $table->dropForeign(['user_id']);

            $table->foreign('town_id')->references('id')->on('towns')->onDelete('set null')->onUpdate('set null')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->biginteger('town_id')->unsigned()->change();
            $table->biginteger('user_id')->unsigned()->change();

            $table->dropForeign(['town_id']);
            $table->dropForeign(['user_id']);

            $table->foreign('town_id')->references('id')->on('towns')->onDelete('cascade')->onUpdate('restrict')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict')->change();

        });
    }
};

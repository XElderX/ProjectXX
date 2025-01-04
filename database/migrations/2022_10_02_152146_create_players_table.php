<?php

use App\Models\Player;
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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('value')->default(0);
            $table->integer('salary')->default(0);
            $table->integer('height')->default(175);
            $table->integer('weight')->default(65);
            $table->integer('age')->default(18);
            $table->integer('potential')->default(80);
            $table->tinyInteger('bookings')->default(0);
            $table->integer('injury_days')->nullable();
            $table->integer('fatique')->default(100);
            $table->string('position')->default(Player::POSITION_GK);

            //stats
            $table->decimal('gk',5,3)->default(0);//goalkeeping skill
            $table->decimal('def',5,3)->default(0);//defending
            $table->decimal('pm',5,3)->default(0);//playmaking
            $table->decimal('pace',5,3)->default(0);//pace- how quickly moves
            $table->decimal('tech',5,3)->default(0);// technique
            $table->decimal('pass',5,3)->default(0);//passing
            $table->decimal('heading',5,3)->default(0);//header
            $table->decimal('str',5,3)->default(0);//striking
            $table->decimal('stamina',5,3)->default(0);//stamina, fatigue
            $table->decimal('exp',5,3)->default(0);//experience
            $table->decimal('lead',5,3)->default(0);//leadership

            $table->float('form')->default(5.0);// current form. how good in shape
            
            $table->biginteger('club_id')->nullable()->unsigned();
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('restrict')->onUpdate('restrict');

            $table->biginteger('country_id')->unsigned();
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
        Schema::dropIfExists('players');
    }
};

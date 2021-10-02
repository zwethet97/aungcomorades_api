<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoccerTodayTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soccer_today_tips', function (Blueprint $table) {
            $table->id();
            $table->string('soccer_tips_id');
            $table->string('date');
            $table->string('bannerImageOne');
            $table->string('imageOneDescription');
            $table->string('bannerImageTwo');
            $table->string('imagTwoDescription');
            $table->string('bannerImageThree');
            $table->string('imageThreeDescription');
            $table->string('home_away');
            $table->string('score');
            $table->string('odds');
            $table->string('tips');
            $table->string('result');
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
        Schema::dropIfExists('soccer_today_tips');
    }
}

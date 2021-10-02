<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodayTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('today_tips', function (Blueprint $table) {
            $table->id();
            $table->string('tips_id');
            $table->string('date');
            $table->string('bannerImageOne');
            $table->string('imageOneDescription');
            $table->string('bannerImageTwo');
            $table->string('imagTwoDescription');
            $table->string('bannerImageThree');
            $table->string('imageThreeDescription');
            $table->string('tip_number');
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
        Schema::dropIfExists('today_tips');
    }
}

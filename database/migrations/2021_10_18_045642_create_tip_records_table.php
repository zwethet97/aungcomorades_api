<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tip_records', function (Blueprint $table) {
            $table->id();
            $table->string('tip_id');
            $table->string('date');
            $table->string('time');
            $table->string('twod');
            $table->string('banner_one');
            $table->string('description_one');
            $table->string('banner_two');
            $table->string('description_two');
            $table->string('banner_three');
            $table->string('description_three');
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
        Schema::dropIfExists('tip_records');
    }
}

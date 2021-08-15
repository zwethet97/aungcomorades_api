<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_slips', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('forDate');
            $table->string('forTime');
            $table->string('type');
            $table->string('bet-numbers');
            $table->decimal('total-bet-amount',9,0);
            $table->string('status');
            $table->decimal('selected-total-number');
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
        Schema::dropIfExists('bet_slips');
    }
}

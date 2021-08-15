<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBettorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bettors', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('phone-number');
            $table->string('password');
            $table->string('referral-code');
            $table->string('user-level');
            $table->string('profile-pic-source');
            $table->decimal('credits',9,0);
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
        Schema::dropIfExists('bettors');
    }
}

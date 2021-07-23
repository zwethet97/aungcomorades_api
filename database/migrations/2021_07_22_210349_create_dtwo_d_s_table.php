<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtwoDSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtwo_d_s', function (Blueprint $table) {
            $table->id();
            $table->decimal('2D', 2, 0);
            $table->decimal('modern', 2, 0);
            $table->decimal('internet', 2, 0);
            $table->string('time');
            $table->string('date');
            $table->string('day');
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
        Schema::dropIfExists('dtwo_d_s');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDthreeDSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dthree_d_s', function (Blueprint $table) {
            $table->id();
            $table->decimal('3D', 3, 0);
            $table->decimal('modern', 2, 0);
            $table->decimal('internet', 2, 0);
            $table->decimal('set', 4, 2);
            $table->decimal('value', 5, 2);
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
        Schema::dropIfExists('dthree_d_s');
    }
}

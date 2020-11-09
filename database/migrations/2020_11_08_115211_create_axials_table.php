<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('axials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->unique()->unsigned();
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamp('dt_nw')->nullable();
            $table->timestamp('dt_st')->nullable();
            $table->timestamp('dt_sp')->nullable();
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('axials');
    }
}

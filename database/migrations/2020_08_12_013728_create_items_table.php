<?php

use Brick\Math\BigInteger;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('donor_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('value');
            $table->integer('retail_value');
            $table->integer('initial_bid');
            $table->integer('increment');
            $table->BigInteger('current_bidder');
            $table->integer('current_bid');
            $table->boolean('sold');
            $table->boolean('paid');
            $table->boolean('letter_sent');
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}

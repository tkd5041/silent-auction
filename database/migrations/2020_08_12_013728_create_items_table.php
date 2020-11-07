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
            $table->text('image')->nullable();
            $table->BigInteger('current_bidder')->nullable();
            $table->integer('current_bid')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('sold');
            $table->boolean('texted');
            $table->boolean('paid');
            $table->text('notes_for_winner', 512);
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

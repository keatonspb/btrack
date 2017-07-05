<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('track_id', false, true);
            $table->foreign("track_id")->references('id')->on('tracks')->onDelete('cascade');
            $table->tinyInteger("rate", false, true);
            $table->char("rater", 255);
            $table->unique(['track_id', "rater"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating');
    }
}

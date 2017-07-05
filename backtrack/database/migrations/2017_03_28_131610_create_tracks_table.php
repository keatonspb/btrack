<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean("status");
            $table->decimal("rating", 3, 2);
            $table->integer('song_id', false, true);
            $table->foreign("song_id")->references('id')->on('songs')->onDelete('cascade');
            $table->integer('user_id', false, true)->nullable();
            $table->foreign("user_id")->references('id')->on('users')->onDelete('set null');
            $table->string("filename");
            $table->boolean("bass")->default(false);
            $table->boolean("drums")->default(false);
            $table->boolean("vocals")->default(false);
            $table->boolean("lead")->default(false);
            $table->boolean("rhythm")->default(false);
            $table->boolean("keys")->default(false);
            $table->json("properties")->nullable();
            $table->char("hash", 128);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}

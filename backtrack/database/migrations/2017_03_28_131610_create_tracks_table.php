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
            $table->integer('user_id', false, true)->nullable();
            $table->foreign("user_id")->references('id')->on('users')->onDelete('set null');
            $table->integer('author_id', false, true)->nullable();
            $table->foreign("author_id")->references('id')->on('authors')->onDelete('set null');
            $table->string("name");
            $table->boolean("bass")->default(false);
            $table->boolean("drums")->default(false);
            $table->boolean("vocals")->default(false);
            $table->boolean("lead")->default(false);
            $table->boolean("rhythm")->default(false);
            $table->boolean("keys")->default(false);
            $table->json("properties")->nullable();
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

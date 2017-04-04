<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('song_id', false, true);
            $table->foreign("song_id")->references('id')->on('songs')->onDelete('cascade');
            $table->enum("instrument", ['guitar', 'bass', 'drums', 'lyrics']);
            $table->integer("tuning_id", false, true)->nullable();
            $table->foreign("tuning_id")->references('id')->on('tunings')->onDelete('set null');
            $table->text("content");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabs');
    }
}

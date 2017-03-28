<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean("status");
            $table->integer('author_id', false, true)->nullable();
            $table->foreign("author_id")->references('id')->on('authors')->onDelete('set null');
            $table->string("name");
        });
    }

    /**
     * Создание песни
     * @param $name
     * @param $author
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $File
     * @internal param $Upload $
     */
    public static function createSong($name, $author, \Symfony\Component\HttpFoundation\File\UploadedFile $File) {

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}

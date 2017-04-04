<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTuningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tunings', function (Blueprint $table) {
            $table->increments('id');
            $table->enum("instrument", ['guitar', 'bass', 'drums', 'lyrics']);
            $table->char("name", 10);
            $table->char("strings", 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tunings');
    }
}

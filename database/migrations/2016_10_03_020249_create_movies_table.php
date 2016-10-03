<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('IMDBid')->unique();            
            $table->string('title');
            $table->string('year');
            $table->string('runtime');
            $table->string('urlPoster');
            $table->string('urlIMDB');
            $table->string('plot');
            $table->string('ratingIMDB');
            $table->string('ratingMC');
            $table->string('rated');
            $table->string('votes');
            $table->string('metascore');
            $table->string('byUser');

            $table->integer('crew_id')->unsigned();
            $table->foreign('crew_id')->references('id')->on('crews')->onDelete('cascade');

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
        Schema::drop('movies');
    }
}

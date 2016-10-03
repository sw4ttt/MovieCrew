<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrewMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_movie', function (Blueprint $table) {
            $table->integer('crew_id')->unsigned()->index();            
            $table->foreign('crew_id')->references('id')
                    ->on('crews')->onDelete('cascade');

            $table->integer('movie_id')->unsigned()->index();
            $table->foreign('movie_id')->references('id')
                    ->on('movies')->onDelete('cascade');            

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
        Schema::drop('crew_movie');
    }
}

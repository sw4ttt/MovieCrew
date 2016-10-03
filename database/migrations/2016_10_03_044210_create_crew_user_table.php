<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrewUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();            
            $table->foreign('user_id')->references('id')
                    ->on('users')->onDelete('cascade');

            $table->integer('crew_id')->unsigned()->index();
            $table->foreign('crew_id')->references('id')
                    ->on('crews')->onDelete('cascade');            

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
        Schema::drop('crew_user');
    }
}

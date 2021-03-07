<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyclingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cyclings', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger('cycle_id')->unsigned()->index()->nullable();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('comment')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();
            $table->foreign('cycle_id')->references('id')->on('cycles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *0
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cyclings');
    }
}

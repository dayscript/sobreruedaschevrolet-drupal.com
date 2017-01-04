<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('program_id')->nullable()->unsigned();
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('channel_user', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('channel_id')->nullable()->unsigned();
            $table->foreign('channel_id')->references('id')->on('program_channels')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('challenge_channel', function (Blueprint $table) {
            $table->integer('challenge_id')->nullable()->unsigned();
            $table->foreign('challenge_id')->references('id')->on('challenges')->onDelete('cascade');
            $table->integer('channel_id')->nullable()->unsigned();
            $table->foreign('channel_id')->references('id')->on('program_channels')->onDelete('cascade');
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
        Schema::drop('challenge_channel');
        Schema::drop('channel_user');
        Schema::drop('program_channels');
    }
}

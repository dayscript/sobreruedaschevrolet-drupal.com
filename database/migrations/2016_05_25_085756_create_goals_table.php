<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type')->default('compare');
            $table->integer('challenge_id')->nullable()->unsigned();
            $table->foreign('challenge_id')->references('id')->on('challenges')->onDelete('cascade');
            $table->integer('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('variable1_id')->nullable()->unsigned();
            $table->foreign('variable1_id')->references('id')->on('program_variables')->onDelete('set null');
            $table->integer('variable2_id')->nullable()->unsigned();
            $table->foreign('variable2_id')->references('id')->on('program_variables')->onDelete('set null');
            $table->string('operator')->nullable();
            $table->boolean('group')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('challenge_goal_goal', function (Blueprint $table) {
            $table->integer('goal1_id')->nullable()->unsigned();
            $table->foreign('goal1_id')->references('id')->on('challenge_goals')->onDelete('cascade');
            $table->integer('goal2_id')->nullable()->unsigned();
            $table->foreign('goal2_id')->references('id')->on('challenge_goals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('challenge_goal_goal');
        Schema::drop('challenge_goals');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->text('url')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('pointsname')->default('punto');
            $table->integer('pointsvalue')->default(1);
            $table->string('client')->nullable();
            $table->smallInteger('pointslimit')->defaults(5);
            $table->smallInteger('userslimit')->defaults(5);
            $table->text('terms')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('user_agrees', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('program_id')->nullable()->unsigned();
            $table->foreign('program_id')->references('id')->on('programs');
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
        Schema::drop('user_agrees');
        Schema::drop('programs');
    }
}

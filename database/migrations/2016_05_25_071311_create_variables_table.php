<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_variables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('type')->default('simple');
            $table->integer('program_id')->nullable()->unsigned();
            $table->foreign('program_id')->references('id')->on('programs');
            $table->string('constant_value')->nullable();
            $table->integer('variable1_id')->nullable()->unsigned();
            $table->foreign('variable1_id')->references('id')->on('program_variables')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('program_variables');
    }
}

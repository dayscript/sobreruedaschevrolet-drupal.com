<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('program_id')->nullable()->unsigned();
            $table->foreign('program_id')->references('id')->on('programs');
            $table->string('field');
            $table->string('value');
            $table->string('slug');
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
        Schema::drop('program_fields');
    }
}

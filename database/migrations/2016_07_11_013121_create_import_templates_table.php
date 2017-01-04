<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('import_template_role', function (Blueprint $table) {
            $table->integer('import_template_id')->unsigned();
            $table->foreign('import_template_id')->references('id')->on('import_templates')->onDelete('cascade');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::create('import_template_channel', function (Blueprint $table) {
            $table->integer('import_template_id')->unsigned();
            $table->foreign('import_template_id')->references('id')->on('import_templates')->onDelete('cascade');
            $table->integer('channel_id')->nullable()->unsigned();
            $table->foreign('channel_id')->references('id')->on('program_channels')->onDelete('cascade');
        });
        Schema::create('import_template_variable', function (Blueprint $table) {
            $table->integer('import_template_id')->unsigned();
            $table->foreign('import_template_id')->references('id')->on('import_templates')->onDelete('cascade');
            $table->integer('variable_id')->nullable()->unsigned();
            $table->foreign('variable_id')->references('id')->on('program_variables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('import_template_variable');
        Schema::drop('import_template_channel');
        Schema::drop('import_template_role');
        Schema::drop('import_templates');
    }
}

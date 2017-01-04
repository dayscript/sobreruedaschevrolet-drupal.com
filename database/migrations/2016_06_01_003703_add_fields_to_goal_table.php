<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToGoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenge_goals', function (Blueprint $table) {
            $table->double('points')->nullable()->after('type');
            $table->integer('percentage')->nullable()->after('points');
            $table->integer('totalpercentage')->nullable()->after('percentage');
        });
        Schema::table('program_variables', function (Blueprint $table) {
            $table->integer('variable2_id')->nullable()->unsigned()->after('variable1_id');
            $table->foreign('variable2_id')->references('id')->on('program_variables')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_variables', function (Blueprint $table) {
            $table->dropForeign('program_variables_variable2_id_foreign');
            $table->dropColumn('variable2_id');
        });
        Schema::table('challenge_goals', function (Blueprint $table) {
            $table->dropColumn('totalpercentage');
            $table->dropColumn('percentage');
            $table->dropColumn('points');
        });
    }
}

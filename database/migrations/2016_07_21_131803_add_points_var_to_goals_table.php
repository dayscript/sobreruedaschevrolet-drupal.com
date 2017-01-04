<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointsVarToGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenge_goals', function (Blueprint $table) {
            $table->integer('points_variable')->nullable()->unsigned()->after('points');
            $table->foreign('points_variable')->references('id')->on('program_variables')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challenge_goals', function (Blueprint $table) {
            $table->dropForeign('challenge_goals_points_variable_foreign');
            $table->dropColumn('points_variable');
        });
    }
}

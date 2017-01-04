<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComposednumberVarToGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenge_goals', function (Blueprint $table) {
            $table->integer('composednumber')->nullable()->after('points_variable');
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
            $table->dropColumn('composednumber');
        });
    }
}

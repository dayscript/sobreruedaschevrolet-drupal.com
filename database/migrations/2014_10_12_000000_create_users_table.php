<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identification')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('firstname')->defaults('');
            $table->string('lastname')->defaults('');
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('lang')->nullable();
            $table->date('birth')->nullable();
            $table->date('hire')->nullable();
            $table->date('retirement')->nullable();
            $table->enum('gender',['male','female','unknown'])->nullable();
            $table->string('avatar')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_details', function (Blueprint $table) {
            $table-> increments('id');
            $table-> integer('user_id')->unsigned();
            $table-> foreign('user_id')->references('id')->on('users');
            $table-> string('qualification');
            $table-> string('subject');
            $table-> string('phone');
            $table-> string('address');
            $table-> string('photo');
            $table-> integer('del_status');
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
        Schema::dropIfExists('faculty_details');
    }
}

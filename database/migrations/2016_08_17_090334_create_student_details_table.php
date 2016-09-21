<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_details', function (Blueprint $table) {
            $table->increments('id');
            $table-> integer('user_id')->unsigned();
            $table-> foreign('user_id')->references('id')->on('users');
            $table-> integer('batch_id')->unsigned();
            $table-> foreign('batch_id')->references('id')->on('batch_details');
            $table-> date('gender');
            $table-> string('dob');
            $table-> string('guardian');
            $table-> text('address');
            $table-> string('phone');
            $table-> string('school');
            $table-> string('cee_rank');
            $table-> integer('percentage');
            $table-> string('photo');
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
        Schema::dropIfExists('student_details');
    }
}

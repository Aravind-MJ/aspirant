<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee', function (Blueprint $table) {
            $table-> increments('id');
            $table-> integer('student_id')->unsigned()->index();
            $table-> foreign('student_id')->references('id')->on('student_details');
            $table-> integer('first');
            $table-> integer('second');  
            $table-> integer('third'); 
            $table-> integer('discount'); 
            $table-> string('balance');
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
        Schema::dropIfExists('fee');
    }
}

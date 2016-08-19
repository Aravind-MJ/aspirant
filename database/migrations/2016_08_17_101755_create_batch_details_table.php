<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_details', function (Blueprint $table) {
            $table-> increments('id');
            $table-> string('batch');
            $table-> string('time_shift');
            $table-> integer('year');
            $table-> integer('in_charge')->unsigned();
            $table-> foreign('in_charge')->references('id')->on('faculty_details');
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
         Schema::dropIfExists('batch_details');
    }
}

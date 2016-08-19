<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table-> increments('id');
            $table-> integer('batch_id')->unsigned();
            $table-> foreign('batch_id')->references('id')->on('batch_details');
            $table-> string('attendance');
            $table-> integer('absent_count');           
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
       Schema::dropIfExists('attendance');
    }
}

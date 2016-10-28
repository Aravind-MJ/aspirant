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
         $table->increments('id');
            $table-> integer('student_id')->unsigned();
            $table-> foreign('student_id')->references('id')->on('student_details');
            $table-> String('first');
                        $table-> String('second');
                         $table-> String('third');
                          $table-> String('discount');

            
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
       Schema::dropIfExists('fee');  //
    }
}

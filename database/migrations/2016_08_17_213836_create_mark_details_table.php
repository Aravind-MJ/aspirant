<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mark_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->forgein('user_id')->references('id')->on('users');
            $table->integer('exam_id');
            $table->forgein('exam_id')->references('id')->on('exam_details');
            $table->integer('mark');
            $table->integer('total_mark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}

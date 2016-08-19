<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeePaidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_paid', function (Blueprint $table) {
            $table-> increments('id');
            $table-> integer('type_id')->unsigned()->index();
            $table-> foreign('type_id')->references('id')->on('fee_types');
            $table-> integer('user_id')->unsigned()->index();
            $table-> foreign('user_id')->references('id')->on('users');
            $table-> integer('last_date');   
            $table-> string('status'); 
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
        Schema::dropIfExists('fee_paid');
    }
}

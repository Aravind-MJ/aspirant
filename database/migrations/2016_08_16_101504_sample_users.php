<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SampleUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::table('users')->insert(
                array(
                    'email' => 'Aravind M J',
                    'email' => 'aravind@imrokraft.com',
                    'password' => '$2y$10$dykfBf7baUmOEknZtkWTKOqrKvDzUYblm32bA/ZkdyNOYdbw2IxAu', //By default, uses bcrypt algo
                    'created_at' => date('Y-m-d H:m:s'),
                    'updated_at' => date('Y-m-d H:m:s')
                )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            
        });
    }

}

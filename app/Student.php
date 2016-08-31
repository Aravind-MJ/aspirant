<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
     protected $table = "student_details";
     
     public function batch() {
        return $this->hasMany('App\Batch');
    }
}

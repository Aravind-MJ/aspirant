<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
     protected $table = "student_details";
     use SoftDeletes;

    protected $dates = ['deleted_at'];
    
     public function batch() {
        return $this->hasMany('App\Batch');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SoftDeletes;

class Student extends Model {

    protected $table = "student_details";
    protected $dates = ['deleted_at'];

    public function batch() {
        return $this->hasMany('App\Batch');
    }

}

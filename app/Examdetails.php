<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Examdetails extends Model
{
    
    protected $table = "exam_details";
//    use SoftDeletes;
//
//    protected $dates = ['deleted_at'];
     public function Examtypes() {
        return $this->hasOne('App\Examdetails');
     }   
}
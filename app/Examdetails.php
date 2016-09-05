<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examdetails extends Model
{
     Examdetails $table="exam_details";
     public function Examtypes() {
        return $this->hasOne('App\Examdetails');
     }   
}
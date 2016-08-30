<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examdetails extends Model
{
     protected $table="exam_details";
      public function Exam_type() {
        return $this->hasOne('App\Examdetails');
}
}
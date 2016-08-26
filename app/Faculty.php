<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model {

    protected $table = "faculty_details";

    public function user() {
        return $this->hasOne('App\Faculty');
    }

}

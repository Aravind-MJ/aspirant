<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model {

    protected $table = "faculty_details";
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function user() {
        return $this->hasOne('App\Faculty');
    }

}

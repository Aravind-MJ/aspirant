<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model {

    protected $table = "notice";

    public function batch() {
        return $this->hasMany('App\Batch');
    }

}

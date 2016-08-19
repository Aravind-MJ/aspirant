<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function getHome()
    {
        return view('protected.faculty.home');
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function home(){
        return view('home');
    }
}

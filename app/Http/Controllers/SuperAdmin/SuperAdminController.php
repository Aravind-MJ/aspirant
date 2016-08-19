<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function getHome()
    {
        return view('protected.superadmin.admin_dashboard');
    }

}

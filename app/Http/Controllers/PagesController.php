<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Student;
use App\User;
use App\Batch;
use App\Encrypt;

class PagesController extends Controller {

    public function getLogin() {
        return view('pages.index');
    }

    public function getHome() {
        if (Sentinel::check()) {
            $id = Sentinel::getUser()->id;
            //Get results by targeting id
            $student = DB::table('student_details')
                    ->join('users', 'users.id', '=', 'student_details.user_id')
                    ->join('batch_details', 'batch_details.id', '=', 'student_details.batch_id')
                    ->select('users.*', 'student_details.*', 'batch_details.batch')
                    ->where('student_details.user_id', $id)
                    ->first();
            $student->enc_userid = Encrypt::encrypt($student->user_id);
            return View('student.student_details', compact('student'));
        }
    }

    public function getAbout() {
        return view('pages.about');
    }

    public function getContact() {
        return view('pages.contact');
    }

}

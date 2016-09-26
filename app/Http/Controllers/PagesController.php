<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use Illuminate\Support\Facades\Redirect;
use DB;
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
            return View('protected.standardUser.home', compact('student'));
        }
    }

    public function getNotice() {
        //Select all records from notice table
        $id = Sentinel::getUser()->id;
        $student = DB::table('student_details')
                ->select('batch_id')->where('user_id', $id)
                ->first();
        $allNotice = DB::table('notice')
            ->join('batch_details', 'batch_details.id', '=', 'notice.batch_id')
                ->where('batch_id',$student->batch_id)
            ->select('notice.*', 'batch_details.batch')
            ->get();
        return View('protected.standardUser.notice', compact('allNotice'));
//        return view('pages.about');
    }

    public function getContact() {
        return view('pages.contact');
    }

}

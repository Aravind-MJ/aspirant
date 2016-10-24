<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Batch;
use App\Student;
use App\User;
use App\Examtypes;
use App\Examdetails;
use Input;
use Validator;
use Sentinel;
Use Auth;
use DB;
use App\Encrypt;
use Illuminate\Support\Facades\Request;
use DateTime;

class StudentprogresscardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        //select list of student
        $allStudents = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('mark_details','mark_details.user_id', '=', 'student_details.user_id')
                ->join('exam_details','exam_details.id', '=', 'mark_details.exam_id')
                 ->join('Exam_type','Exam_type.id', '=','exam_details.type_id')

//                ->join('fee','fee.id','=','student_details.user_id')
//                ->join('batch_details', 'batch_details.id', '=', 'student_details.batch_id')
//                 ->join('fee_types','fee_types.id','=', 'student_details.batch_id')
                ->select('users.*', 'student_details.*','mark_details.*','exam_details.*','Exam_type.*')
                ->where('student_details.deleted_at', NULL)
                ->orderBy('student_details.created_at', 'DESC')
                ->get();
        foreach ($allStudents as $student) {
            $student->enc_id = Encrypt::encrypt($student->id);
            $student->enc_userid = Encrypt::encrypt($student->user_id);
        
        }
        //Fetch Batch Details
        $batch = DB::table('batch_details')
                ->select('id', 'batch')
                ->orderBy('batch_details.created_at', 'ASC')
                ->get();
//        $batch = Batch::lists('batch', 'id')->prepend('Select Batch', '');
        $data = array();
        foreach ($batch as $batch) {
           $data[$batch->id] = $batch->batch;
        }
        $batch = $data;
        return View('Progresscard.progresscard', compact('allStudents', 'batch', 'id'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

   public function search() {

        // Gets the query string and batch from our form submission 

        $search = Request::input('param2');
        $selectedBatch = $batch = Request::input('param1');

        // Returns an array of articles that have the query string located somewhere within 

        $query = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
               
                ->join('mark_details','mark_details.user_id', '=', 'student_details.user_id')
                ->join('exam_details','exam_details.id', '=', 'mark_details.exam_id')
                ->join('Exam_type','Exam_type.id', '=','exam_details.type_id')

//                 ->join('fee','fee.student_id','=','student_details.user_id')
//                ->join('fee_types','fee_types.batch_id','=', 'student_details.batch_id')
                ->select('users.*', 'student_details.*','mark_details.*','exam_details.*','Exam_type.*')
                ->where('student_details.deleted_at', NULL);
        

        if ($batch != 0) {
            $query->where('student_details.batch_id', $batch);
        }
        
      if (!empty($search)) {
          $query->where('users.first_name', 'LIKE', '%' . $search . '%');
       }
       
        $allStudents = $query->get();
        foreach ($allStudents as $student) {
            $student->enc_id = Encrypt::encrypt($student->id);
            $student->enc_userid = Encrypt::encrypt($student->user_id);
                
        }
        //Fetch Batch Details
        $batch = DB::table('batch_details')
                ->select('id', 'batch')              
                ->get();
        $data = array();
        foreach ($batch as $batch) {
           $data[$batch->id] = $batch->batch;
        }
        $batch = $data;
        
        // returns a view and passes the view the list of articles and the original query.
//        return route('Student.index');
        return View('Progresscard.progresscard', 
            ['allStudents' => $allStudents, 
            'batch' => $batch, 'selbatch' => $selectedBatch]
        );
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

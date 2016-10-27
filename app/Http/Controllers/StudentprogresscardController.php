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
        
        $user_id = Request::input('param2');
        $selectedBatch = $batch = Request::input('param1');
        
        $data = array();
        $year=2016;

        $student = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('batch_details','batch_details.id','=','student_details.batch_id')
                
                ->first();
       
       
        $subjects = DB::table('exam_details')
                ->select(DB::raw('DISTINCT subject'))
                ->get();
      
        $marks = DB::table('mark_details')
                ->join('exam_details','exam_details.id','=','mark_details.exam_id')
                ->where('mark_details.user_id',$user_id)
                ->get();

        foreach($marks as $each_mark){
            $data[$each_mark->type_id]['marks'][$each_mark->subject]=$each_mark;
        }
        
        foreach($data as $key=>$value){
            $exam_data = DB::table('Exam_type')
                    ->where('id',$key)
                    ->first();
            
            $data[$key]['name']=$exam_data->name;
        }
        $marks = $data;
        
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
            ['batch' => $batch, 
                'selbatch' => $selectedBatch,
                'student' => $student,
                'subjects' => $subjects,
                'marks' => $marks
                ]
        );
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

        $user_id = Request::input('param2');
        $selectedBatch = $batch = Request::input('param1');
        $data = array();

        $year=2016;

        $student = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('batch_details','batch_details.id','=','student_details.batch_id')
                ->where([
                    'users.id'=>$user_id,
                    'users.deleted_at'=>null
                        ])
                ->first();

        
        $subjects = DB::table('exam_details')
                ->select(DB::raw('DISTINCT subject'))
                ->get();
        
        foreach($subjects as $subject){
            if($subject->subject!=''){
                $data_subject []= ucwords($subject->subject);
            }
        }
            $subjects = $data_subject;
            
        
     
        $marks = DB::table('mark_details')
                ->join('exam_details','exam_details.id','=','mark_details.exam_id')
                ->where('mark_details.user_id',$user_id)
                ->get();
        
        
        foreach($marks as $each_mark){
            $data[$each_mark->type_id]['marks'][ucwords($each_mark->subject)]=$each_mark;
            $data[$each_mark->type_id]['date'] = $each_mark->exam_date;
        }
        
        foreach($data as $key=>$value){
            $exam_data = DB::table('Exam_type')
                    ->where('id',$key)
                    ->first();
            
            $data[$key]['name']=$exam_data->name;
            $total_mark = 0;
            foreach($data[$key]['marks'] as $mark){
                $total_mark += $mark->mark;
            }
            $data[$key]['total_mark'] = $total_mark;
        }
        $marks = $data;
        
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
            ['batch' => $batch, 
                'selbatch' => $selectedBatch,
                'student' => $student,
                'subjects' => $subjects,
                'marks' => $marks
                ]
        );
    }
   
    public function destroy($id)
    {
        //
    }
}

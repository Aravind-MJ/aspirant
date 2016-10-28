<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\ProgressFetchStudentsRequest;
use Illuminate\Support\Facades\Request;
use DB;
class StudentprogresscardController extends Controller
{
   public function search() {

        // Gets the query string and batch from our form submission 

        $user_id = Request::input('param2');
        $selectedBatch = $batch = Request::input('param1');

       //Fetch Batch Details
       $batch = DB::table('batch_details')
           ->select('id', 'batch')
           ->get();
       $data = array();
       $data[0]='Select a Batch';
       foreach ($batch as $batch) {
           $data[$batch->id] = $batch->batch;
       }
       $batch = $data;

        if($user_id==null||$selectedBatch==null){
            return View('Progresscard.progresscard',['initial'=>true,'batch'=>$batch]);
        }
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



        
        $subjects = DB::table('subjects')
                ->get();
        
        foreach($subjects as $subject){
                $data_subject [$subject->id]= ucwords($subject->subjects);
        }
            $subjects = $data_subject;
            $subjects[0] = 'Undefined';
            
        
     
        $marks = DB::table('mark_details')
                ->join('exam_details','exam_details.id','=','mark_details.exam_id')
                ->where('mark_details.user_id',$user_id)
                ->get();
        
        
        foreach($marks as $each_mark){
            $data[$each_mark->type_id]['marks'][ucwords($subjects[$each_mark->subject_id])]=$each_mark;
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

    public function fetchStudents(ProgressFetchStudentsRequest $request){
        $data = '';
        $batch_id = $request['batch_id'];
        $students = DB::table('student_details')
            ->join('users','users.id','=','student_details.user_id')
            ->select('users.*')
            ->where(['users.deleted_at'=>null,'student_details.batch_id'=>$batch_id])
            ->get();
        foreach($students as $student){
            $data .='<option value="'.$student->id.'">'.$student->first_name.' '.$student->last_name.'</option>';
        }
        return $data;
    }
}

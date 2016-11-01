<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Batch;
use App\Subject;
use Input;
use Validator;
use Sentinel;
use DB;
use App\RankList;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Encrypt;
use DateTime;

class RankListController extends Controller
{
   protected $batch;
	protected $subject;

   public function __construct(Batch $batch,Subject $subject) {
 
 
        $this->batch = $batch;
		 $this->subject = $subject;
   }
	//public function __construct(faculty $faculty) {
 
       // $this->faculty = $faculty;
    //}
    public function common()
    {
		$year = 2016;
		$students = array();
        $all = DB::table('mark_details')
		->select(DB::raw('user_id,SUM(mark) as total_mark'))
		->groupBy('user_id')
		->orderBy('total_mark','DESC')
		->get();
		
	
		
		
		
		foreach($all as $student){
			$details = DB::table('users')
			->join('student_details', 'users.id', '=', 'student_details.user_id')
			->join('batch_details','batch_details.id','=','student_details.batch_id')
			->select('users.first_name','users.last_name', 'users.id', 'batch_details.batch')
			->where(['users.deleted_at'=> NULL,'users.id'=>$student->user_id,'batch_details.year'=>$year])
			->first();
			
			if(count($details)==1){			
				$student->name = $details->first_name.' '.$details->last_name;
				$student->batch = $details->batch;
				array_push($students,$student);
			}
		}
		//dd($students);
    return View('ranklist.list_ranklist', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function byBatch($batch)
    {
		$flag=true;
		$selectedBatch = $batch;
		/*Display Results*/
		$batch = $this-> batch
                ->select('id', 'batch')
                ->get();
        $data = array();
        foreach ($batch as $batch) {
			if($selectedBatch==$batch->id){
				$flag=false;
			}
            $data[$batch->id] = $batch->batch;
        }
        $batch = $data;
		if($flag){
			foreach($batch as $key=>$value){				
				$selectedBatch = $key;
				break;
			}
		}
		
		//dd($selectedBatch);
		$year = 2016;
		$students = array();
        $all = DB::table('mark_details')
		->join('student_details','student_details.user_id','=','mark_details.user_id')
		->select(DB::raw('mark_details.user_id,SUM(mark) as total_mark'))
		->where('student_details.batch_id',$selectedBatch)
		->groupBy('mark_details.user_id')
		->orderBy('total_mark','DESC')
		->get();
				
		foreach($all as $student){
			$details = DB::table('users')
			->join('student_details', 'users.id', '=', 'student_details.user_id')
			->join('batch_details','batch_details.id','=','student_details.batch_id')
			->select('users.first_name','users.last_name','batch_details.batch')
			->where(['users.deleted_at'=> NULL,'users.id'=>$student->user_id,'batch_details.year'=>$year,'batch_details.id'=>$selectedBatch])
			->first();
			
			if(count($details)==1){			
				$student->name = $details->first_name.' '.$details->last_name;
				$student->batch = $details->batch;
				array_push($students,$student);
				
			}
		}
		//dd($students);
    return View('ranklist.ranklist_by_batch',['batch'=>$batch,'students'=>$students,'selectedBatch'=>$selectedBatch]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
	 
	 public function bySubject($subject)
    {
        $flag=true;
		$selectedSubject=$subject;
		$student = array();
		/*Display Results*/
		$subject = $this-> subject
                ->select('id', 'subject')
                ->get();
        $data = array();
        foreach ($subject as $subject) {
			if($selectedSubject==$subject->id){
				$flag=false;
			}
            $data[$subject->id] = $subject->subject;
        }
        $subject = $data;
		if($flag){
			foreach($subject as $key=>$value){				
				$selectedSubject = $key;
				break;
			}
		}
		//dd($subject);
		$year = 2016;
		$student = array();
  
//dd($selectedSubject);
  $all = DB::table('mark_details')
        
		->join('student_details','student_details.user_id','=','mark_details.user_id')
		->join('exam_details','exam_details.id', '=', 'student_details.id')
		->join('subjects','subject.id','=', 'exam_details.subject_id')
		->select(DB::raw('mark_details.user_id,SUM(mark) as total_mark,subjects.subjects'))
		->where('exam_details.subject_id',$selectedSubject)
		->groupBy('mark_details.user_id')
		->orderBy('total_mark','DESC')
		->get();
		//dd($all);
		foreach($all as $each_subject)
		{
			//dd($each_subject);
			 $detail = DB::table('student_details')
				->join('users','users.id','=','student_details.user_id')
                ->where(['student_details.user_id'=>$each_subject->user_id])
								->first();
			//dd($detail);
		if(count($detail)==1){
				$each_subject->name = $detail->first_name;
				array_push($student,$each_subject);
				
			}
		}	    
			 
		//dd($student);
		return View('ranklist.ranklist_by_subject',['subject'=>$subject,'student'=>$student,'selectedSubject'=>$selectedSubject]);
	}
    public function store()
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {
		/*$allmarklist = DB::table('mark_details')
        ->join('users', 'users.id', '=', 'mark_details.user_id')
        ->join('student_details', 'users.id', '=', 'student_details.user_id')
        ->select('users.*', 'mark_details.*','student_details.batch_id')
        ->where('users.deleted_at', NULL)
        ->orderBy('mark_details.mark', 'DESC')
                ->get();
                foreach ($allmarklist as $marklist) {
            $marklist->enc_id = Encrypt::encrypt($marklist->id);
            $batch = new Batch;
            $batch = $batch->where('id',$marklist->batch_id)->first()->batch;
            $marklist->batch = $batch;
			
        return View('ranklist.subject');
    }*/
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
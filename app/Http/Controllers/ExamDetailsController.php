<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\PublishExamdetailsEditRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Examdetails;
use App\Examtype;
use Input;
use DB;

class ExamDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
     
       $allExamdetails = DB::table('exam_details')
                ->join('Exam_type', 'Exam_type.id', '=', 'exam_details.type_id')
                ->select('Exam_type.*', 'exam_details.*')
                ->get();   //Eloquent ORM method to return all matching results
        //Redirecting to list_examdetails.blade.php with $allExamdetails      
             return View('protected.admin.list_Examdetails', compact('allExamdetails'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $Examtype=  \App\Examtype::lists('name');
       return view('protected.admin.add_Examdetails',compact('type_id','Examtype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishExamdetailsRequest $requestData)
    {
        
        
        $Examdetails = new \App\Examdetails;
        $Examdetails->type_id= $requestData['type_id'];
        $Examdetails->exam_date =date("Y/m/d", strtotime($requestData['exam_date']));
        $Examdetails->save();
           return redirect()->route('ExamDetails.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      
       $Examdetails = DB::table('exam_details')
                ->join('Exam_type', 'Exam_type.id', '=', 'exam_details.type_id')
                ->select('Exam_type.*', 'exam_details.*')
                ->get();
        //Redirecting to showBook.blade.php with $book variable
        return view('protected.admin.list_Examdetails')->with('ExamDetails', $Examdetails);  //    }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
       $Examdetails = DB::table('exam_details')
                ->join('Exam_type', 'Exam_type.id', '=', 'exam_details.type_id')
                ->where('exam_details.id', $id)
                ->select('Exam_type.name', 'exam_details.*')
                ->first();
  
        return view('protected.admin.edit_Examdetails')->with('Examdetails', $Examdetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
   public function update($id, Requests\PublishExamdetailsRequest $requestData)
    {
        $Examdetails = \App\Examdetails::find($id);
        $Examdetails->exam_type=$requestDate['name'];
        $Examdetails->exam_date =date("Y/m/d", strtotime($requestData['exam_date']));
        $Examdetails->save();

        //Send control to index() method
        return redirect()->route('ExamDetails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
   //find result by id and delete 
        \App\Examdetails::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('ExamDetails.index');
    }
}

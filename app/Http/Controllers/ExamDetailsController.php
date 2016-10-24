<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\PublishExamdetailsEditRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Examdetails;
use App\Examtypes;
use Input;
use DB;
use App\Encrypt;

class ExamDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response public function index()
     * {
     *
     * $allExamdetails = DB::table('exam_details')
     * ->join('Exam_type', 'Exam_type.id', '=', 'exam_details.type_id')
     */
    public function index()
    {

        $allExamdetails = DB::table('exam_details')
            ->join('Exam_type', 'Exam_type.id', '=', 'exam_details.type_id')
            ->select('Exam_type.*', 'exam_details.*')
            ->get();
     foreach($allExamdetails as $Examdetails) {
     $Examdetails->id = Encrypt::encrypt($Examdetails->id);
   }

        return View('Examdetails.list_Examdetails', compact('allExamdetails'));
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $Examtype = \App\Examtypes::lists('name', 'id');
        return view('Examdetails.add_Examdetails', compact('type_id', 'Examtype', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishExamdetailsRequest $requestData)
    {
//        $Examtypes = new \App\Examtypes;
//        $Examtypes->name = $requestData['name'];

        $Examdetails = new \App\Examdetails;
        $Examdetails->type_id = $requestData['type_id'];
        $Examdetails->exam_date = date("Y/m/d", strtotime($requestData['exam_date']));
        $Examdetails->subject = $requestData['subject'];
        $Examdetails->total_mark = $requestData['total_mark'];
        $Examdetails->save();
           return redirect()->route('ExamDetails.create')
                            ->withFlashMessage('Examdetails Added successfully!')
                            ->withType('success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $enc_id=$id;
        $id = Encrypt::decrypt($id);
        $Examdetails = DB::table('exam_details')
            ->join('Exam_type', 'Exam_type.id', '=', 'exam_details.type_id')
            ->select('Exam_type.*', 'exam_details.*')
            ->get();
        //Redirecting to showBook.blade.php with $book variable
        return view('Examdetails.list_Examdetails')->with('Examdetails', $Examdetails); //    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $enc_id=$id;
        $id = Encrypt::decrypt($id);
       $Examdetails = DB::table('exam_details')
                ->join('Exam_type', 'Exam_type.id', '=', 'exam_details.type_id')
                ->where('exam_details.id', $id)
                ->select('Exam_type.name', 'exam_details.*')
                ->first();
        $Examtype=  \App\Examtypes::lists('name','id');
       return view('Examdetails.edit_Examdetails',compact('Examdetails','type_id','Examtype','id'));
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Requests\PublishExamdetailsRequest $requestData)
    {
        $Examdetails = \App\Examdetails::find($id);
        $Examdetails->type_id = $requestData['type_id'];
        $Examdetails->exam_date = date("Y/m/d", strtotime($requestData['exam_date']));
         $Examdetails->subject = $requestData['subject'];
        $Examdetails->total_mark = $requestData['total_mark'];

        $Examdetails->save();
       return redirect()->route('ExamDetails.index')
                        ->withFlashMessage('Examdetails Updated successfully!')
                        ->withType('success');

    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $enc_id=$id;
        $id = Encrypt::decrypt($id);
        //find result by id and delete
        \App\Examdetails::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('ExamDetails.index');
    }
}

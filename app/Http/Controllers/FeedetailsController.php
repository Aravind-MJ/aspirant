<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Feedetails;
use App\Http\Student;
use App\User;
use App\Batchdetails;
use App\Encrypt;
use DB;


class FeedetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        $allFeedetails = DB::table('fee')
            ->join('users','users.id','=', 'fee.student_id')
            ->join('student_details','student_details.user_id', '=','users.id') 
            ->select('fee.*', 'users.*' ,'student_details.*')
            ->get();
     foreach($allFeedetails as $Feedetails) {
     $Feedetails->enc_id = Encrypt::encrypt($Feedetails->id);
    }
    return View('Feedetails.list_feedetails', compact('allFeedetails'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
         $users = DB::table('users')
                  ->join('student_details','student_details.user_id', '=','users.id')              
                  ->select('users.id','first_name','last_name')
                  ->get();
        $data=array();
     
        foreach($users as $each){
            $data[$each->id]=$each->first_name.' '.$each->last_name;
           
        }
        $users=$data;
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
       return view('Feedetails.add_feedetails', compact('student_id', 'Feedetails','batch', 'users','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishFeedetailsRequest $requestData)
    {
        $user = new \App\User;
        $user->first_name = $requestData['first_name'];
        $user->last_name  =$requestData['last_name'];
        
        $Feedetails = new \App\Feedetails;
        $Feedetails->student_id= $requestData['student_name'];
        $Feedetails->batch =    $requestData['batch'];
       $Feedetails->first =    $requestData['first'];
        $Feedetails->second = $requestData['second'];
        $Feedetails->third = $requestData['third'];
        $Feedetails->discount = $requestData['discount'];
         $Feedetails->save();
           return redirect()->route('Feedetails.create')
                            ->withFlashMessage('Feedetails Added successfully!')
                            ->withType('success');
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
       {
         $enc_id=$id;
         $id = Encrypt::decrypt($id);
        
       $Feedetails = DB::table('fee')
            ->join('users','users.id','=', 'fee.student_id')
            ->join('student_details','student_details.user_id', '=','users.id') 
            ->select('fee.*', 'users.*' ,'student_details.*')
            ->first();
         $users = DB::table('users')
                  ->join('student_details','student_details.user_id', '=','users.id')              
                  ->select('users.id','first_name','last_name')
                  ->get();
         $data=array();
     
        foreach($users as $each){
            $data[$each->id]=$each->first_name.' '.$each->last_name;
           
        }
        $users=$data;
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
        //Fetch Batch Details

        return View('Feedetails.edit_Feedetails', compact('Feedetails', 'users', 'batch','id')); //
    }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\PublishFeedetailsRequest $requestData)
    {
        $Feedetails = \App\Feedetails::find($id);
        $Feedetails->student_id= $requestData['student_name'];
        $Feedetails->batch =    $requestData['batch'];
        $Feedetails->first =    $requestData['first'];
        $Feedetails->second = $requestData['second'];
        $Feedetails->third = $requestData['third'];
        $Feedetails->discount = $requestData['discount'];
         $Feedetails->save();
        return redirect()->route('Feedetails.index')
                        ->withFlashMessage('FeeDetails Updated successfully!')
                        ->withType('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
//         $enc_id = $id;
//        $id = Encrypt::decrypt($id);
//        $Feedetails = DB::table('fee')
//                ->select('student_id')
//                ->where('fee.id', $id)
//                ->first();
//
//        $student_id = $Feedetails->student_id;
//        $now = new DateTime();
//        DB::table('users')->where('id', $user_id)->skip(1)->take(1)->update(['deleted_at' => $now]);
//        //find result by id and delete 
//        Feedetails::find($id)->delete();
//
//        //Redirecting to index() method
//        return redirect()->route('Feedetails.index');
    }
}

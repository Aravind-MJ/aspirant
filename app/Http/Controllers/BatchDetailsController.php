<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Batchdetails;
use App\Faculty;
use App\User;
use Input;
use DB;

class BatchDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allBatchdetails = DB::table('batch_details')
                ->join('users', 'users.id', '=', 'batch_details.in_charge')
                ->select('users.*', 'batch_details.*')
                ->get();
        //Redirecting to list_faculty.blade.php with $allFaculties       
        return View('Batchdetails.list_Batchdetails', compact('allBatchdetails'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       $users= \App\User::lists('first_name','id');
       return view('Batchdetails.add_Batchdetails',compact('in_charge','users','id'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishBatchdetailsRequest $requestData){
        $user = new \App\User;
        $user->first_name = $requestData['first_name'];
       

        

        // Assign the role to the users
        
    {
         $Batchdetails = new \App\Batchdetails;
         $Batchdetails->batch=$requestData['batch'];
         $Batchdetails->syllabus=$requestData['syllabus'];
         $Batchdetails->time_shift=$requestData['time_shift'];
         $Batchdetails->year =date("Y/m/d", strtotime($requestData['year']));
         $Batchdetails->in_charge= $requestData['in_charge'];
    }
        
         $Batchdetails->save();
           return redirect()->route('BatchDetails.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $Batchdetails = DB::table('batch_details')
                ->join('users', 'users.id', '=', 'batch_details.in_charge')
                ->select('users.*', 'batch_details.*')
                ->get();
        //Redirecting to showBook.blade.php with $book variable
        return view('Batchdetails.list_Batchdetails')->with('Batchdetails', $Batchdetails); //   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    
      {
       $Batchdetails = DB::table('batch_details')
                 ->join('users', 'users.id', '=', 'batch_details.in_charge')
                ->where('batch_details.id', $id)
                ->select('users.*', 'batch_details.*')
                ->first();
       $users= \App\User::lists('first_name','id');
       return view('Batchdetails.edit_Batchdetails',compact('Batchdetails','in_charge','users','id'));
    
    }  //
    

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Requests\PublishBatchdetailsRequest $requestData)
    {
        
         $Batchdetails = \App\Batchdetails::find($id);
         $Batchdetails->batch=$requestData['batch'];
         $Batchdetails->syllabus=$requestData['syllabus'];
         $Batchdetails->time_shift=$requestData['time_shift'];
         $Batchdetails->year =date("Y/m/d", strtotime($requestData['year']));
         $Batchdetails->in_charge= $requestData['in_charge'];
        
         $Batchdetails->save();
           return redirect()->route('BatchDetails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
       \App\Batchdetails::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('BatchDetails.index');
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Batchdetails;
use App\Faculty;
use App\User;
use App\RoleUsers;
use Input;
use DB;
use App\Encrypt;

class BatchDetailsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $time_shift = [1=>'Morning',2=>'Afternoon',3=>'Evening'];
        $allBatchdetails = DB::table('batch_details')
                ->join('users','users.id','=', 'batch_details.in_charge')
                 ->join('faculty_details','faculty_details.user_id', '=','users.id')     
                ->select('users.*', 'batch_details.*')
                ->get();
        foreach($allBatchdetails as $Batchdetails){
             $Batchdetails->enc_id = Encrypt::encrypt($Batchdetails->id);
             $Batchdetails->time_shift = $time_shift[$Batchdetails->time_shift];
        }
        //Redirecting to list_faculty.blade.php with $allFaculties       
        return View('Batchdetails.list_Batchdetails', compact('allBatchdetails'));
    }

        
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $users = DB::table('users')
                  ->join('faculty_details','faculty_details.user_id', '=','users.id')              
                  ->select('users.id','first_name','last_name')
                  ->get();
        $data=array();
        foreach($users as $each){
            $data[$each->id]=$each->first_name.' '.$each->last_name;
        }
        $users=$data;
//          
//                \App\User::lists('first_name','last_name', 'id');
//      dd($users);
        return view('Batchdetails.add_Batchdetails', compact('Batchdetails','in_charge','users','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishBatchdetailsRequest $requestData) {
        $user = new \App\User;
        $user->first_name = $requestData['first_name'];
        $user->last_name  =$requestData['last_name'];
        $time_shift = ['morning'=>1,'afternoon'=>2,'evening'=>3];



        // Assign the role to the users
        {
            $Batchdetails = new \App\Batchdetails;
            $Batchdetails->batch = $requestData['batch'];
            $Batchdetails->syllabus = $requestData['syllabus'];
            $Batchdetails->time_shift = $time_shift[strtolower($requestData['time_shift'])];
            $Batchdetails->year = $requestData['year'];
            $Batchdetails->in_charge = $requestData['in_charge'];
        
        $Batchdetails->save();
        }
 
      if ($Batchdetails->save()) {
            return redirect()->route('BatchDetails.create')
                             ->with('flash_message', 'New Batch added successfully.')
                             ->withType('success');
        } else {
            return redirect()->route('BatchDetails.create')
                             ->with('flash_message', 'New Batch could not be succeeded.')
                             ->withType('Danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
         $enc_id=$id;
        $time_shift = [1=>'morning',2=>'afternoon',3=>'evening'];
        $id = Encrypt::decrypt($id);
          $Batchdetails = DB::table('batch_details')
                ->join('users', 'users.id', '=', 'batch_details.in_charge')
                ->select('users.*', 'batch_details.*')
                ->where('batch_details.id', $id)
                ->first();
        //Redirecting to showBook.blade.php with $book variable
            $Batchdetails->time_shift = $time_shift[$Batchdetails->time_shift];
        

//         dd($Batchdetails);
        return View('Batchdetails.Batch_details', compact('Batchdetails'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
    $enc_id=$id;
     $id = Encrypt::decrypt($id);
        
    $Batchdetails = DB::table('batch_details')
                ->join('users', 'users.id', '=', 'batch_details.in_charge')  
                ->where('batch_details.id', $id)
                ->select('users.*', 'batch_details.*')
                ->first();
    
    
     $users = DB::table('users')
                  ->join('faculty_details','faculty_details.user_id', '=','users.id')              
                  ->select('users.id','first_name','last_name')
                  ->get();
        $data=array();
        foreach($users as $each){
            $data[$each->id]=$each->first_name.' '.$each->last_name;
        }
        $users=$data;
//        $users = \App\User::lists('first_name', 'id');
        return view('Batchdetails.edit_Batchdetails', compact('Batchdetails', 'in_charge', 'users', 'id'));
    }
//
////

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\PublishBatchdetailsRequest $requestData) {
        $time_shift = ['morning'=>1,'afternoon'=>2,'evening'=>3];
        $Batchdetails = \App\Batchdetails::find($id);
        $Batchdetails->batch = $requestData['batch'];
        $Batchdetails->syllabus = $requestData['syllabus'];
        $Batchdetails->time_shift = $time_shift[strtolower($requestData['time_shift'])];
        $Batchdetails->year = $requestData['year'];
        $Batchdetails->in_charge = $requestData['in_charge'];

        $Batchdetails->save();
        return redirect()->route('BatchDetails.index')
                        ->withFlashMessage('Batch Updated successfully!')
                        ->withType('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
         $enc_id=$id;
        $id = Encrypt::decrypt($id);
        \App\Batchdetails::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('BatchDetails.index');
    }  

}
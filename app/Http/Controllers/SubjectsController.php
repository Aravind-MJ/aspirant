<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subjects;
use DB;
use App\Encrypt;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
         $allSubjects = \App\Subjects::all();    //Eloquent ORM method to return all matching results
        //Redirecting to list_faculty.blade.php with $allFaculties  
         foreach( $allSubjects as $Subjects ){
             $Subjects->enc_id = Encrypt::encrypt($Subjects->id);
   
         }
        return View('Subjects.list_subjects', compact('allSubjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       return view('Subjects.subjects');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishSubjectsRequest $requestData)
    {
         $Subjects = new \App\Subjects;
        $Subjects->subjects= $requestData['subjects'];//
           $Subjects->save();
           return redirect()->route('Subjects.create')
                            ->withFlashMessage(' Subjects added successfully!')
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
          $enc_id=$id;
        $id = Encrypt::decrypt($id);
        $Subjects = \App\Subjects::find($id);


        return view('Subjects.edit_Subjects')->with('Subjects', $Subjects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Requests\PublishSubjectsRequest $requestData)
    {
         $Subjects = \App\Subjects::find($id);
        $Subjects->subjects = $requestData['subjects'];
        $Subjects->save();

        //Send control to index() method
        return redirect()->route('Subjects.index')
                         ->withFlashMessage('Subjects updated successfully!')
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
         $enc_id=$id;
        $id = Encrypt::decrypt($id);
        //find result by id and delete
        \App\Subjects::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('Subjects.index');
    }
}

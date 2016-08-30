<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Examtype;

class ExamTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
       $allExamtype = \App\Examtype::all();    //Eloquent ORM method to return all matching results
        //Redirecting to list_faculty.blade.php with $allFaculties       
        return View('protected.admin.list_Examtype', compact('allExamtype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
     return view('protected.admin.add_Examtype');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishExamtypeRequest $requestData)
    {
        $Examtype = new \App\Examtype;
        $Examtype->name= $requestData['name'];//
           $Examtype->save();
           return redirect()->route('ExamType.create');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $Examtype = Examtype::find($id);

        //Redirecting to showBook.blade.php with $book variable
        return view('protected.admin.list_Examtype')->with('Examtype', $Examtype);  //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
       $Examtype = \App\Examtype::find($id);

  
        return view('protected.admin.edit_Examtype')->with('Examtype', $Examtype); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\PublishExamtypeRequest $requestData)
    {
       $Examtype = \App\Examtype::find($id);
        $Examtype->name = $requestData['name']; 
        $Examtype->save();

        //Send control to index() method
        return redirect()->route('ExamType.index');
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
       //find result by id and delete 
        \App\Examtype::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('ExamType.index');
    } //
    
}

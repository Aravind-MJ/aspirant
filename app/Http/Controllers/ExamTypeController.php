<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Examtypes;

class ExamTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allExamtype = \App\Examtypes::all();    //Eloquent ORM method to return all matching results
        //Redirecting to list_faculty.blade.php with $allFaculties       
        return View('Examdetails.list_Examtype', compact('allExamtype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Examdetails.add_Examtype');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishExamtypeRequest $requestData)
    {
        $Examtype = new \App\Examtypes;
        $Examtype->name= $requestData['name'];//
           $Examtype->save();
           return redirect()->route('ExamType.create')
                            ->withFlashMessage(' Examtype added successfully!')
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
        $Examtype = Examtypes::find($id);

        //Redirecting to showBook.blade.php with $book variable
        return view('Examdetails.list_Examtype')->with('Examtype', $Examtype);  //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $Examtype = \App\Examtypes::find($id);


        return view('Examdetails.edit_Examtype')->with('Examtype', $Examtype); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Requests\PublishExamtypeRequest $requestData)
    {
        $Examtype = \App\Examtypes::find($id);
        $Examtype->name = $requestData['name'];
        $Examtype->save();

        //Send control to index() method
        return redirect()->route('ExamType.index')
                         ->withFlashMessage('Examtype updated successfully!')
                         ->withType('success');
    //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //find result by id and delete
        \App\Examtypes::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('ExamType.index');
    } //

}

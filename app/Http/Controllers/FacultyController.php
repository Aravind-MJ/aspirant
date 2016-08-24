<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Faculty;

class FacultyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        //Select all records from faculty_details table 
        $allFaculties = \App\Faculty::all();    //Eloquent ORM method to return all matching results
        //Redirecting to list_faculty.blade.php with $allFaculties       
        return View('protected.admin.list_faculty', compact('allFaculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Redirecting to add_faculty.blade.php 
        return view('protected.admin.add_faculty');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishFacultyRequest $requestData) {
        //Insert Query
        $faculty = new \App\Faculty;
        $faculty->qualification = $requestData['qualification'];
        $faculty->subject = $requestData['subject'];
        $faculty->phone = $requestData['phone'];
        $faculty->address = $requestData['address'];
        $faculty->photo = $requestData['photo'];
        $faculty->save();

        //Send control to index() method
        return redirect()->route('addFaculty');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        //Get results by targeting id
        $faculty = Faculty::find($id);

        //Redirecting to showBook.blade.php with $book variable
        return view('protected.admin.list_faculty')->with('faculty', $faculty);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        //Get Result by targeting id
        $faculty = \App\Faculty::find($id);

        //Redirecting to edit_faculty.blade.php 
        return view('protected.admin.edit_faculty')->with('faculty', $faculty);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\PublishFacultyRequest $requestData) {
        
        //Update Query
        $faculty = \App\Faculty::find($id);
        $faculty->qualification = $requestData['qualification'];
        $faculty->subject = $requestData['subject'];
        $faculty->phone = $requestData['phone'];
        $faculty->address = $requestData['address'];
        $faculty->photo = $requestData['photo'];
        $faculty->save();

        //Send control to index() method
        return redirect()->route('listFaculty');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        //find result by id and delete 
        \App\Faculty::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('listFaculty');
    }

}

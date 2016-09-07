<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Faculty;
use App\User;
use Input;
use Validator;
use Sentinel;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Encrypt;

class FacultyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        //Select all records from faculty_details table 
        // $allFaculties = \App\Faculty::all();    //Eloquent ORM method to return all matching results
        $allFaculties = DB::table('faculty_details')
                ->join('users', 'users.id', '=', 'faculty_details.user_id')
                ->select('users.*', 'faculty_details.*')
                ->get();
        //Redirecting to list_faculty.blade.php with $allFaculties       
        return View('faculty.list_faculty', compact('allFaculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Redirecting to add_faculty.blade.php 
        return view('faculty.add_faculty');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishFacultyRequest $requestData) {
        //Insert Query
        $user = new User;
        $user->first_name = $requestData['first_name'];
        $user->last_name = $requestData['last_name'];
        $user->email = $requestData['email'];
        $user->password = \Hash::make($requestData['password']);

        $input = $requestData->only('email', 'password', 'first_name', 'last_name');
        $user = Sentinel::registerAndActivate($input);

        // Find the role using the role name
        $usersRole = Sentinel::findRoleByName('Faculty');

        // Assign the role to the users
        $usersRole->users()->attach($user);

        $faculty = new Faculty;
        $faculty->user_id = $user['id'];
        $faculty->qualification = $requestData['qualification'];
        $faculty->subject = $requestData['subject'];
        $faculty->phone = $requestData['phone'];
        $faculty->address = $requestData['address'];


        $input = Input::all();

//        $this->validate($requestData['photo'], [
//
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

        if (Input::hasFile('photo')) {

            $file = Input::file('photo');

            $name = time() . '-' . $file->getClientOriginalName();

            $file = $file->move(public_path() . '\images', $name);

//        $image      = Imag::make($file->getRealPath())->resize('320','240')->save($file);

            $faculty->photo = $name;

            $faculty->save();
        }

        //redirect to addFaculty
        if ($faculty->save()) {
            return Redirect::back()->with('flash_message', 'New faculty added successfully.');
        } else {
            return Redirect::back()->with('flash_message', 'New faculty registration could not be succeeded.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        //Get results by targeting id
        $faculty = DB::table('faculty_details')
                ->join('users', 'users.id', '=', 'faculty_details.user_id')
                ->where('faculty_details.id', $id)
                ->select('users.*', 'faculty_details.*')
                ->first();

        //Redirecting to list page
        return view('faculty.faculty_details')->with('faculty', $faculty);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        //Get Result by targeting id
        $faculty = DB::table('faculty_details')
                ->join('users', 'users.id', '=', 'faculty_details.user_id')
                ->where('faculty_details.id', $id)
                ->select('users.*', 'faculty_details.*')
                ->first();
        
        //Fetch User Details
        $user = DB::table('users')
                ->select('id', 'first_name', 'last_name', 'email')
                ->where('id', $faculty->user_id)
                ->first();
        $user->enc_id = Encrypt::encrypt($user->id);

        //Redirecting to edit_faculty.blade.php 
//        return view('faculty.edit_faculty')->with('faculty', $faculty);
        return View('faculty.edit_faculty', compact('user', 'faculty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\PublishFacultyRequest $requestData) {

        //Update Query       
        $faculty = Faculty::find($id);
        $faculty->qualification = $requestData['qualification'];
        $faculty->subject = $requestData['subject'];
        $faculty->phone = $requestData['phone'];
        $faculty->address = $requestData['address'];
        $faculty->photo = $requestData['photo'];
        $input = Input::all();

//        $this->validate($requestData['photo'], [
//
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

        if (Input::hasFile('photo')) {

            $file = Input::file('photo');

            $name = time() . '-' . $file->getClientOriginalName();

            $file = $file->move(public_path() . '\images', $name);

//        $image      = Imag::make($file->getRealPath())->resize('320','240')->save($file);

            $faculty->photo = $name;

            $faculty->save();

//         if ($faculty->save()) 
//         {
//            return Redirect::back()->with(['global' => 'New faculty added successfully.', 'type' => 'success']);
//         }else
//         {
//            return Redirect::back()->with(['global'=> 'New faculty registration could not be succeeded.' , 'type' => 'danger']);
//         }
        }

        //Send control to index() method
        return redirect()->route('Faculty.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        //find result by id and delete 
        Faculty::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('Faculty.index');             
    }

}

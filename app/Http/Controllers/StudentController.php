<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Batch;
use App\Student;
use App\User;
use Input;
use Validator;
use Sentinel;
Use Auth;
use DB;

class StudentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
        $allStudents = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('batch_details', 'batch_details.id', '=', 'student_details.batch_id')
                ->select('users.*', 'student_details.*','batch_details.batch')
                ->get();

       return View('protected.admin.list_student', compact('allStudents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $batch = \App\Batch::lists('batch', 'id');

        return view('protected.admin.add_student', compact('id', 'batch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\RegisterStudentRequest $requestData) {

        //store student data to student_details table
        $user = new \App\User;
        $user->first_name = $requestData['first_name'];
        $user->last_name = $requestData['first_name'];
        $user->email = $requestData['email'];
        $user->password = \Hash::make($requestData['dob']);

        $input = array('email' => $user->email, 'password' => $user->password, 'first_name' => $user->first_name, 'last_name' => $user->last_name);

        $user = Sentinel::registerAndActivate($input);

        // Find the role using the role name
        $usersRole = Sentinel::findRoleByName('Users');

        // Assign the role to the users
        $usersRole->users()->attach($user);

        $student = new \App\Student;
        $student->batch_id = $requestData['batch_id'];
        $student->user_id = $user['id'];
        $student->gender = $requestData['gender'];
        $student->dob = date('Y-m-d', strtotime($requestData['dob']));
        $student->guardian = $requestData['guardian'];
        $student->address = $requestData['address'];
        $student->phone = $requestData['phone'];
        $student->school = $requestData['school'];
        $student->cee_rank = $requestData['cee_rank'];
        $student->percentage = $requestData['percentage'];

//        $this->validate($requestData['photo'], [
//
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

        if ($requestData->hasFile('photo')) {

            $file = $requestData->file('photo');

            $name = time() . '-' . $file->getClientOriginalName();

            $file = $file->move(public_path() . '\images\students', $name);

//        $image      = Imag::make($file->getRealPath())->resize('320','240')->save($file);

            $student->photo = $name;
        }

        $student->save();
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //Get results by targeting id
        $student = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('batch_details', 'id', '=', 'student_details.batch_id')
                ->select('users.*', 'faculty_details.*', 'batch_details.*')
                ->get();

        return view('protected.admin.list_student')->with('student', $student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $student = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('batch_details', 'batch_details.id', '=', 'student_details.batch_id')
                ->select('users.*', 'student_details.*','batch_details.batch')
                ->where('student_details.id', $id)
                ->first();
        $batch = \App\Batch::lists('batch', 'id');
//        print_r($batch);die;
       
        //Redirecting to edit_student.blade.php 
       return view('protected.admin.edit_student')->with('student', $student, compact('id', 'batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\RegisterStudentRequest $requestData) {
        //update student_details data
        $student = \App\Student::find($id);;
//        $student->batch_id = $requestData['batch_id'];
        $student->gender = $requestData['gender'];
        $student->dob = date('Y-m-d', strtotime($requestData['dob']));
        $student->guardian = $requestData['guardian'];
        $student->address = $requestData['address'];
        $student->phone = $requestData['phone'];
        $student->school = $requestData['school'];
        $student->cee_rank = $requestData['cee_rank'];
        $student->percentage = $requestData['percentage'];
      
//        $this->validate($requestData['photo'], [
//
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

        if ($requestData->hasFile('photo')) {

            $file = $requestData->file('photo');

            $name = time() . '-' . $file->getClientOriginalName();

            $file = $file->move(public_path() . '\images\students', $name);

//        $image      = Imag::make($file->getRealPath())->resize('320','240')->save($file);

            $student->photo = $name;
        }

        $student->save();
        return redirect()->route('Student.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //find result by id and delete 
        \App\Student::find($id)->delete();

        //Redirecting to index() method
        return Redirect::back();
    }

}

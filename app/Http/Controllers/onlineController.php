<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\online;    
use DB;
use App\Student;
use App\Encrypt;
use App\User;
use Sentinel;


class onlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
         $allFeedetails = \App\online::all();    //Eloquent ORM method to return all matching results
        //Redirecting to list_faculty.blade.php with $allFaculties  
         foreach( $allFeedetails as $Feedetails ){
             $Feedetails->enc_id = Encrypt::encrypt($Feedetails->id);
   
         }
        return View('student.online-registered_student', compact('allFeedetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
       $enc_id = $id;
        $id = Encrypt::decrypt($id);
        $register = DB::table('register')  
        ->where('id', $id)
        ->first();
       //dd($register);
        $user = new User;
        $user->first_name = $register->firstname;
        $user->last_name = $register->lastname;
        $user->email = $register->email;
        //dd($register->dob);
        $user->password = \Hash::make($register->dob);

        $input = array('email' => $user->email, 'password' => $register->dob, 'first_name' => $user->first_name, 'last_name' => $user->last_name);

        $user = Sentinel::registerAndActivate($input);

        // Find the role using the role name
        $usersRole = Sentinel::findRoleByName('Users');

        // Assign the role to the users
        $usersRole->users()->attach($user);
        $student = new Student;
        $student->batch_id = $register->batch_id;
        $student->user_id = $user->id;
        $student->gender = $register->gender;
        $student->dob = date('Y-m-d', strtotime($register->dob));
        $student->guardian = $register->parent;
        $student->address = $register->address;
        $student->phone = $register->contact;
        $student->school = $register->school;
        $student->cee_rank = $register->rank;
        $student->percentage = $register->percent;
        $student->photo = $register->photo; 

        $student->save();
        
        if ($student->save()) {
            online::find($id)->delete();
            return Redirect::back()
                            ->withFlashMessage('Student Activated successfully!')
                            ->withType('success');
        } else {
            return Redirect::back()
                            ->withFlashMessage('Failed to activate! Please try again!')
                            ->withType('danger');
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
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
        //
    }
}

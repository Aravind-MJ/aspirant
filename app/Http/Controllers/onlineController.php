<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\online;
use DB;
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
        $student->guardian = $register->guardian;
        $student->address = $register->address;
        $student->phone = $register->phone;
        $student->school = $register->school;
        $student->cee_rank = $register->cee_rank;
        $student->percentage = $register->percentage;
          
        

//        $this->validate($requestData['photo'], [
//
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

        if ($register->hasFile('photo')) {

            $file = $register->file('photo');

            $name = time() . '-' . $file->getClientOriginalName();

            $file = $file->move(public_path() . '/images/students', $name);

//        $image      = Imag::make($file->getRealPath())->resize('320','240')->save($file);

            $student->photo = $name;
        }

        $student->save();
        if ($student->save()) {
            return Redirect::back()
                            ->withFlashMessage('Student Added successfully!')
                            ->withType('success');
        } else {
            return Redirect::back()
                            ->withFlashMessage('Failed!')
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

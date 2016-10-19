<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Batch;
use App\Student;
use App\User;
use App\Feetypes;
use Input;
use Validator;
use Sentinel;
Use Auth;
use DB;
use App\Encrypt;
use Illuminate\Support\Facades\Request;
use DateTime;

class FeebybatchController extends Controller {

    
    public function index() {
        //select list of student
        $allStudents = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('fee','fee.id','=','student_details.user_id')
                ->join('batch_details', 'batch_details.id', '=', 'student_details.batch_id')
                 ->join('fee_types','fee_types.id','=', 'student_details.batch_id')
                ->select('users.*', 'student_details.*','batch_details.*','fee_types.*','fee.*')
                ->where('student_details.deleted_at', NULL)
                ->orderBy('student_details.created_at', 'DESC')
                ->get();
        foreach ($allStudents as $student) {
            $student->enc_id = Encrypt::encrypt($student->id);
            $student->enc_userid = Encrypt::encrypt($student->user_id);
        
        }
        //Fetch Batch Details
        $batch = DB::table('batch_details')
                ->select('id', 'batch')
                ->orderBy('batch_details.created_at', 'ASC')
                ->get();
//        $batch = Batch::lists('batch', 'id')->prepend('Select Batch', '');
        $data = array();
        foreach ($batch as $batch) {
           $data[$batch->id] = $batch->batch;
        }
        $batch = $data;
        return View('Feetypes.fee_by_batch', compact('allStudents', 'batch', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Fetch Batch Details
//        $batch = DB::table('batch_details')
//                ->select('id', 'batch')              
//                ->get();
//        $data = array();
//        foreach ($batch as $batch) {
//           $data[$batch->id] = $batch->batch;
//        }
//        $batch = $data;
//
//        return view('student.add_student', compact('id', 'batch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\RegisterStudentRequest $requestData) {

        //store student data to student_details table
        $user = new User;
        $user->first_name = $requestData['first_name'];
        $user->last_name = $requestData['last_name'];
        $user->email = $requestData['email'];
        $user->password = \Hash::make($requestData['dob']);

        $input = array('email' => $user->email, 'password' => $requestData['dob'], 'first_name' => $user->first_name, 'last_name' => $user->last_name);

        $user = Sentinel::registerAndActivate($input);

        // Find the role using the role name
        $usersRole = Sentinel::findRoleByName('Users');

        // Assign the role to the users
        $usersRole->users()->attach($user);

        $student = new Student;
        $student->batch_id = $requestData['batch_id'];
//        $student->user_id = $user['id'];
//        $student->gender = $requestData['gender'];
//        $student->dob = date('Y-m-d', strtotime($requestData['dob']));
//        
//          $feetypes->total_fee= $requestData['total_fee'];

//        $this->validate($requestData['photo'], [
//
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

    }

    public function selectStudentPost(SelectBatchRequest $request)
    {
        return $this->selectStudentCore(Encrypt::decrypt($request['batch']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
//        $enc_id = $id;
//        $id = Encrypt::decrypt($id);
//        //Get results by targeting id
//        $student = DB::table('student_details')
//                ->join('users', 'users.id', '=', 'student_details.user_id')
//                ->join('batch_details', 'batch_details.id', '=', 'student_details.batch_id')
//                ->select('users.*', 'student_details.*', 'batch_details.batch')
//                ->where('student_details.id', $id)
//                ->first();
//        $student->enc_id = Encrypt::encrypt($student->id);
//        $student->enc_userid = Encrypt::encrypt($student->user_id);
////        return view('protected.admin.student_details')->with('student', $student);
// //return View('Feetypes.fee_details', compact('student'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {

        $data   = array();
        $enc_id = $id;
        $id     = Encrypt::decrypt($id);
//echo $id;
        //Fetch Student Details
         $allStudents = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->join('fee','fee.id','=','student_details.user_id')
                ->join('batch_details', 'batch_details.id', '=', 'student_details.batch_id')
                 ->join('fee_types','fee_types.id','=', 'student_details.batch_id')
                ->select('users.*', 'student_details.*','batch_details.*','fee_types.*','fee.*')
                ->where('student_details.id', $id)
                ->first();
        
         //Fetch Batch Details
        $batch = DB::table('batch_details')
                ->select('id', 'batch')              
                ->get();
        
        foreach ($batch as $batch) {
           $data[$batch->id] = $batch->batch;
        }
        $batch = $data;
        
        //echo $student->user_id;die;
        //Fetch User Details
        $user = DB::table('users')
                ->select('id', 'first_name', 'last_name', 'email')
                ->where('id', $student->user_id)
                ->first();

                
        $user->enc_id = Encrypt::encrypt($user->id);
        

        //Redirecting to edit_student.blade.php 
        return View('Feetypes.edit_fee_by_batch', compact('user', 'batch', 'id', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Responser
     */
    public function update($id, Requests\RegisterStudentRequest $requestData) {
        //update student_details data
        $student = Student::find($id);
        $student->batch_id = $requestData['batch_id'];
//        $student->gender = $requestData['gender'];
//        $student->dob = date('Y-m-d', strtotime($requestData['dob']));
//        $feetypes->total_fee= $requestData['total_fee'];

        
        $student->save();

        if ($student->save()) {
            return redirect::back()
                            ->withFlashMessage('Student Details Updated successfully!')
                            ->withType('success');
        } else {
            return redirect::back()
                            ->withFlashMessage('Student Details Update Failed!')
                            ->withType('danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $enc_id = $id;
        $id = Encrypt::decrypt($id);
        //find result by id and delete 
       $student = DB::table('student_details')
                ->select('user_id')
                ->join('fee_types','fee_types.id','=', 'fee_types.id')
                ->where('student_details.id','fee_types.*', $id)
                ->first();

        $user_id = $student->user_id;
        $now = new DateTime();
        DB::table('users')->where('id', $user_id)->skip(1)->take(1)->update(['deleted_at' => $now]);
        Student::find($id)->delete();
//        User::find($user_id)->delete();
        //Redirecting to index() method
        return Redirect::back();
    }

    public function search() {

        // Gets the query string and batch from our form submission 

        $search = Request::input('param2');
        $selectedBatch = $batch = Request::input('param1');

        // Returns an array of articles that have the query string located somewhere within 

        $query = DB::table('student_details')
                ->join('users', 'users.id', '=', 'student_details.user_id')  
                 ->join('fee','fee.student_id','=','student_details.user_id')
                ->join('fee_types','fee_types.batch_id','=', 'student_details.batch_id')
                ->select('users.*', 'student_details.*','fee_types.*', 'fee.*')
                ->where('student_details.deleted_at', NULL);
        

        if ($batch != 0) {
            $query->where('student_details.batch_id', $batch);
        }
        
//        if (!empty($search)) {
//            $query->where('users.first_name', 'LIKE', '%' . $search . '%');
//        }
       
        $allStudents = $query->get();
        foreach ($allStudents as $student) {
            $student->enc_id = Encrypt::encrypt($student->id);
            $student->enc_userid = Encrypt::encrypt($student->user_id);
                
        }
        //Fetch Batch Details
        $batch = DB::table('batch_details')
                ->select('id', 'batch')              
                ->get();
        $data = array();
        foreach ($batch as $batch) {
           $data[$batch->id] = $batch->batch;
        }
        $batch = $data;
        
        // returns a view and passes the view the list of articles and the original query.
//        return route('Student.index');
        return View('Feetypes.fee_by_batch', 
            ['allStudents' => $allStudents, 
            'batch' => $batch, 'selbatch' => $selectedBatch]
        );
    }

}


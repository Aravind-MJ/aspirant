<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Attendance;
use App\Batch;
use App\StudentDetails;
use Illuminate\Database;
use App\Encrypt;
use App\Cons;
use App\Http\Requests\SelectBatchRequest;
use App\Http\Requests\AjaxAttendanceRequest;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;

class AttendanceController extends Controller
{

    protected $attendance, $batch, $users, $student_details;

    public function __construct(User $user, Attendance $attendance, Batch $batch, StudentDetails $student_details)
    {
        $this->middleware('redirectStandardUser', ['except' => ['ofStudent']]);
        $this->middleware('redirectFaculty', ['only' => ['edit', 'update', 'destroy']]);
        $this->users = $user;
        $this->attendance = $attendance;
        $this->batch = $batch;
        $this->student_details = $student_details;
    }

    /**
     * Show Page to Select Batch to Mark attendance
     *
     * @return Response
     */
    public function index()
    {
        if (Sentinel::check()) {

            $year = Cons::$year;
            $marked_batches = array();
            $user = Sentinel::getUser();
            $faculty = Sentinel::findRoleByName('Faculty');
            $time_shift = array('1', '2', '3');

            try {

                $marked = $this->attendance
                    ->select('batch_id')
                    ->where('created_at', 'like', date('Y-m-d') . '%')
                    ->distinct()
                    ->get();

                foreach ($marked as $each) {
                    $marked_batches [] = $each['batch_id'];
                }

                if ($user->inRole($faculty)) {
                    $id = $user->getUserId();
                    $batch = $this->batch
                        ->select('id', 'batch', 'time_shift')
                        ->where(array(
                            'year' => $year,
                            'in_charge' => $id
                        ))
                        ->orderBy('time_shift')
                        ->get();
                } else {

                    $batch = $this->batch
                        ->select('id', 'batch', 'time_shift')
                        ->where('year', $year)
                        ->get();
                }

            } catch (Exception $e) {
                return redirect()->back()->withFlashMessage('Error Selecting batch!!')->withType('error');
            }

            foreach ($batch as $each_batch) {
                $each_batch['enc_id'] = Encrypt::encrypt($each_batch['id']);
                $each_batch['status'] = (in_array($each_batch['id'], $marked_batches)) ? 'marked' : 'unmarked';
                switch ($each_batch['time_shift']) {
                    case 1:
                        $each_batch['time_shift'] = 'morning';
                        break;
                    case 2:
                        $each_batch['time_shift'] = 'afternoon';
                        break;
                    case 3:
                        $each_batch['time_shift'] = 'evening';
                        break;
                    default:
                        return redirect()->back()->withFlashMessage('Error Selecting batch With Time Shift!!')->withType('error');
                }
            }

            $batch = $batch->toArray();

            return view('attendance.attendance_in_charge', ['time_shift' => $time_shift, 'batch' => $batch]);
        }
    }

    /**
     * Show page for entering attendance.
     *
     * @param $id
     * @return Response
     */
    public function mark($id)
    {
        $enc_id = $id;
        $id = Encrypt::decrypt($id);
        if(!is_numeric($id)){
            return redirect()->back()->withFlashMessage('Invalid Token!')->withType('danger');
        }
        $data = array();

        try {
            $students = $this->student_details
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->select('users.id', 'users.first_name', 'users.last_name')
                ->where('student_details.batch_id', $id)
                ->get();

            foreach ($students as $each_student) {
                $data[Encrypt::encrypt($each_student['id'])]['name'] = $each_student['first_name'] . ' ' . $each_student['last_name'];
            }

        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting Students!')->withType('danger');
        }

        return view('attendance.attendance_create', ['id' => $enc_id, 'students' => $data]);

    }

    /**
     * Save attendance
     *
     * @param $request
     * @return Response
     */
    public function store(AjaxAttendanceRequest $request)
    {
        if ($request->ajax()) {
            $attendance = array();
            $id = Encrypt::decrypt($request['id']);
            $count = sizeof($request['present']);
            if(empty($request['present'])){
                $present = '';
            } else {
                foreach ($request['present'] as $each) {
                    $attendance [] = (int)Encrypt::decrypt($each);
                }
                $present = json_encode($attendance);
            }
            try {
                $this->attendance->insert(array(
                    'batch_id' => $id,
                    'absent_count' => $count,
                    'attendance' => $present
                ));
            } catch (Exception $e) {
                return 'error';
            }

            return 'success';
        } else {
            return '<h1>Invalid Request!! Access Denied</h1>';
        }
    }

    /**
     * Display Batch to select.
     *
     * @return Response
     */
    public function selectBatch()
    {
        $year = Cons::$year;
        $time_shifts = array('morning','afternoon','evening');

        try {

            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->orderBy('time_shift')
                ->get();

        } catch (Exception $e) {
            return redirect('attendance/batch')->withFlashMessage('Error Selecting batch')->withType('error');
        }

        foreach ($batch as $each_batch) {
            $each_batch['enc_id'] = Encrypt::encrypt($each_batch['id']);
            $each_batch['time_shift'] = $time_shifts[$each_batch['time_shift']-1];
        }

        $batch = $batch->toArray();

        return view('attendance.attendance_select_batch', ['time_shift' => $time_shifts, 'batch' => $batch]);
    }

    /**
     * Display Students to select :- First time.
     *
     * @return Response
     */
    public function selectStudentGet()
    {
        return $this->selectStudentCore('first');
    }

    /**
     * Display Students to select :- Filtered.
     *
     * @param $request
     * @return Response
     */
    public function selectStudentPost(SelectBatchRequest $request)
    {
        return $this->selectStudentCore(Encrypt::decrypt($request['batch']));
    }

    /**
     * Core to Display Students to select.
     *
     * @param $id
     * @return Response
     */
    private function selectStudentCore($id)
    {
        $flag = false;
        $year = Cons::$year;
        $time_shifts = array('morning','afternoon','evening');
        $data = array();
        $data['batch'] = array();
        $data['students'] = array();
        if ($id == 'first') {
            $flag = true;
        } else {
            $data['selected']['batch'] = Encrypt::encrypt($id);
        }


        try {
            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->get();

        } catch (Exception $e) {
            return redirect('attendance/batch')->withFlashMessage('Error Selecting batch')->withType('error');
        }

        foreach ($batch as $each_batch) {
            if ($flag) {
                $id = $each_batch['id'];
                $data['selected']['batch'] = Encrypt::encrypt($each_batch['id']);
                $flag = false;
            }
            $data['batch'][Encrypt::encrypt($each_batch['id'])] = $each_batch['batch'] . ' - ' . $time_shifts[$each_batch['time_shift']-1];
        }

        try {
            $students = $this->student_details
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->select('users.id', 'users.first_name', 'users.last_name')
                ->where('student_details.batch_id', $id)
                ->get();

            foreach ($students as $each_student) {
                $data['students'][Encrypt::encrypt($each_student['id'])]['name'] = $each_student['first_name'] . ' ' . $each_student['last_name'];
            }

        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting Students!')->withType('danger');
        }

        return view('attendance.attendance_select_student', [
            'batch' => $data['batch'],
            'selected' => $data['selected'],
            'students' => $data['students']
        ]);
    }

    /**
     * Batch wise attendance
     *
     * @param  int $id
     * @return Response
     */
    public function ofBatch($id)
    {
        $i = 0;
        $data = array();
        $id = Encrypt::decrypt($id);

        try{
            $last_month = date('F - Y');
            $working_days = array();
            $absent = array();

            $batch_id = $this->student_details
                ->select('batch_id')
                ->where('user_id', $id)
                ->first();

            $months = $this->attendance
                ->select('created_at')
                ->where('batch_id', $id)
                ->get()
                ->toArray();

            foreach($months as $month){
                $date = date_create($month['created_at']);
                if(!in_array(date_format($date,'F-Y'),$data)){
                    $data []= date_format($date,'F-Y');
                    $last_month = date_format($date,'F-Y');
                }
                $working_days[date_format($date,'F-Y')][]=date_format($date,'d');
            }

            $months = $data;

            $count_students = $this->student_details
                ->where('batch_id',$id)
                ->get();

            $strength = count($count_students);

            $attendance = $this->attendance
                ->select('absent_count','attendance','created_at')
                ->where('batch_id',$id)
                ->get()
                ->toArray();

            $data = '';
            foreach ($attendance as $each_attendance) {
                $date = date_create($each_attendance['created_at']);
                $data[date_format($date,'F-Y')][date_format($date,'d')] =$strength - $each_attendance['absent_count'].'/'.$strength;
            }

            $present = $data;

            dd($present);

        }catch(Exception $e){
            return view('attendance.attendance_batch', ['flash_message' => 'Error fetching Attendance!', 'type' => 'danger']);
        }

    }

    /**
     * Student wise Attendance
     *
     * @param  int $id
     * @return Response
     */
    public function ofStudent($id)
    {
        $id = Encrypt::decrypt($id);
        $data = array();

        if (!is_numeric($id)) {
            if (Sentinel::getUser()->inRole('users')) {
                return redirect()->back();
            }
            return view('attendance.attendance_student', ['flash_message' => 'Invalid Token!', 'type' => 'danger']);
        }

        try {
            $user = Sentinel::findById($id);
        } catch (Exception $e) {
            return view('attendance.attendance_student', ['flash_message' => 'No such user found!', 'type' => 'danger']);
        }

        if (!$user->inRole('users')) {
            return view('attendance.attendance_student', ['flash_message' => 'Invalid Reference Token!', 'type' => 'danger']);
        }

        try {

            $last_month = date('F - Y');
            $working_days = array();
            $absent = array();

            $batch_id = $this->student_details
                ->select('batch_id')
                ->where('user_id', $id)
                ->first();

            $months = $this->attendance
                ->select('created_at')
                ->where('batch_id', $batch_id['batch_id'])
                ->get()
                ->toArray();

            foreach($months as $month){
                $date = date_create($month['created_at']);
                if(!in_array(date_format($date,'F-Y'),$data)){
                    $data []= date_format($date,'F-Y');
                    $last_month = date_format($date,'F-Y');
                }
                $working_days[date_format($date,'F-Y')][]=date_format($date,'d');
            }

            $months = $data;

            $attendance = $this->attendance
                ->select('created_at')
                ->where('attendance', 'like', '%[' . $id . ',%')
                ->orWhere('attendance', 'like', '%,' . $id . ']%')
                ->orWhere('attendance', 'like', '%,' . $id . ',%')
                ->orWhere('attendance', 'like', '%[' . $id . ']%')
                ->get()
                ->toArray();

            $data = '';
            foreach ($attendance as $each_attendance) {
                $date = date_create($each_attendance['created_at']);
                $data[date_format($date,'F-Y')][] = date_format($date,'d');
            }

            $present = $data;

            foreach($months as $month){
                if(isset($present[$month])){
                    $absent[$month] = array_diff($working_days[$month],$present[$month]);
                } else {
                    $absent[$month] = $working_days[$month];
                }
            }

        } catch (Exception $e) {
            return view('attendance.attendance_student', ['flash_message' => 'Error fetching Attendance!', 'type' => 'danger']);
        }

        return view('attendance.attendance_student', [
            'months' => $months,
            'last_month' => $last_month,
            'present'=>$present,
            'absent'=>$absent,
            'working_days'=>$working_days
        ]);
    }

    /**
     * Page to edit Attendance
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update attendance.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove attendance.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

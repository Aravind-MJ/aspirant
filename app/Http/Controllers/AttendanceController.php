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
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;

class AttendanceController extends Controller
{

    protected $attendance, $batch, $users, $student_details;

    public function __construct(User $user, Attendance $attendance, Batch $batch, StudentDetails $student_details)
    {
        $this->middleware('redirectStandardUser', ['except' => ['show']]);
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
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $id = Encrypt::decrypt($request['id']);
            $count = sizeof($request['absent']);
            foreach ($request['absent'] as $each) {
                $attendance [] = (int)Encrypt::decrypt($each);
            }
            $absent = json_encode($attendance);

            try {
                $this->attendance->insert(array(
                    'batch_id' => $id,
                    'absent_count' => $count,
                    'attendance' => $absent
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

        try {
            $time_shift = array('morning', 'afternoon', 'evening');

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

        return view('attendance.attendance_select_batch', ['time_shift' => $time_shift, 'batch' => $batch]);
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
            $data['batch'][Encrypt::encrypt($each_batch['id'])] = $each_batch['batch'] . ' - ' . $each_batch['time_shift'];
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
            //dd($students);
            //dd($data['students']);
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting Students!')->withType('danger');
        }

        return view('attendance.attendance_select_student', ['batch' => $data['batch'], 'selected' => $data['selected'], 'students' => $data['students']]);
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

        if (!is_numeric($id)) {
            return view('attendance.attendance_batch', ['flash_message' => 'Invalid Token!', 'type' => 'danger']);
        }

        try {
            $batches = $this->batch
                ->where('id', $id)
                ->get();
        } catch (Exception $e) {
            return view('attendance.attendance_batch', ['flash_message' => 'Database Error!', 'type' => 'danger']);
        }


        foreach ($batches as $batch) {
            $data['batch']['batch'] = $batch['batch'];
            $data['batch']['time_shift'] = $batch['time_shift'];
            $data['batch']['year'] = $batch['year'];
            $data['batch']['in_charge'] = $batch['in_charge'];
        }

        try {
            $attendance = $this->attendance
                ->where('batch_id', $id)
                ->get();
        } catch (Exception $e) {
            return view('attendance.attendance_batch', ['flash_message' => 'Database Error!', 'type' => 'danger']);
        }


        foreach ($attendance as $attendance_data) {
            $data['attendance'][$i]['id'] = $attendance_data['id'];
            $data['attendance'][$i]['batch_id'] = $attendance_data['batch_id'];
            $data['attendance'][$i]['attendance'] = json_decode($attendance_data['attendance']);
            $data['attendance'][$i]['absent_count'] = $attendance_data['absent_count'];
            $data['attendance'][$i]['date'] = $attendance_data['created_at'];
            $i++;
        }

        return view('attendance.attendance_batch', ['data' => $data]);
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
            return view('attendance.attendance_student', ['flash_message' => 'Invalid Token!', 'type' => 'danger']);
        }

        try {
            $user = Sentinel::findById($id);
        } catch (Exception $e) {
            return view('attendance.attendance_student', ['flash_message' => 'Database Error!', 'type' => 'danger']);
        }

        if ($user->roles()->get() != 'users') {
            return view('attendance.attendance_student', ['flash_message' => 'Invalid Reference Token!', 'type' => 'danger']);
        }

        return view('attendance.attendance_student', ['data' => $data]);
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

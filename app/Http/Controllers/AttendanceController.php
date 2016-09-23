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
use App\Http\Requests\SelectBatchRequest;
use App\Http\Requests\AjaxAttendanceRequest;
use App\Http\Requests\DeleteAttendanceRequest;
use App\Http\Requests\RangeAttendanceRequest;
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

            $year = 2016;
            $marked_batches = array();
            $user = Sentinel::getUser();
            $faculty = Sentinel::findRoleByName('Faculty');
            $time_shift = array('morning', 'afternoon', 'evening');

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

                    if (count($batch) <= 0) {
                        return redirect()->back()->withFlashMessage('No batch found!!')->withType('danger');
                    }
                }

            } catch (Exception $e) {
                return redirect()->back()->withFlashMessage('Error Selecting batch!!')->withType('danger');
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
                        return redirect()->back()->withFlashMessage('Error Selecting batch With Time Shift!!')->withType('danger');
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
        if (!is_numeric($id)) {
            return redirect()->back()->withFlashMessage('Invalid Token!')->withType('danger');
        }
        $data = array();

        try {
            $students = $this->student_details
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->select('users.id', 'users.first_name', 'users.last_name')
                ->where('student_details.batch_id', $id)
                ->get();
            if (count($students) <= 0) {
                return redirect()->back()->withFlashMessage('No students found for this Batch!')->withType('danger');
            }

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
            if (empty($request['present'])) {
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
                    'present_count' => $count,
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
        $year = 2016;
        $time_shifts = array('morning', 'afternoon', 'evening');

        try {

            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->orderBy('time_shift')
                ->get();

        } catch (Exception $e) {
            return redirect('attendance/batch')->withFlashMessage('Error Selecting batch')->withType('danger');
        }

        foreach ($batch as $each_batch) {
            $each_batch['enc_id'] = Encrypt::encrypt($each_batch['id']);
            $each_batch['time_shift'] = $time_shifts[$each_batch['time_shift'] - 1];
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
        $year = 2016;
        $time_shifts = array('morning', 'afternoon', 'evening');
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

            if (count($batch) <= 0) {
                return redirect()->back()->withFlashMessage('No batches available to display!')->withType('danger');
            }

        } catch (Exception $e) {
            return redirect('attendance/batch')->withFlashMessage('Error Selecting batch')->withType('danger');
        }

        foreach ($batch as $each_batch) {
            if ($flag) {
                $id = $each_batch['id'];
                $data['selected']['batch'] = Encrypt::encrypt($each_batch['id']);
                $flag = false;
            }
            $data['batch'][Encrypt::encrypt($each_batch['id'])] = $each_batch['batch'] . ' - ' . $time_shifts[$each_batch['time_shift'] - 1];
        }

        try {
            $students = $this->student_details
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->select('users.id', 'users.first_name', 'users.last_name')
                ->where('student_details.batch_id', $id)
                ->get();

            if (count($students) <= 0) {
                return redirect()->back()->withFlashMessage('No students available to display!')->withType('danger');
            }

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
        $enc_id = $id;
        $id = Encrypt::decrypt($id);

        if (!$id) {
            return redirect()->back()->withFlashMessage('Invalid Token!')->withType('danger');
        }
        try {
            $data = $this->attendance
                ->where('batch_id', $id)
                ->get();

            if (count($data) <= 0) {
                return redirect()->back()->withFlashMessage('No attendance available for the batch!')->withType('danger');
            }

        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Fetching attendance!')->withType('danger');
        }

        return view('attendance.attendance_batch', ['id' => $enc_id]);
    }

    /**
     * Batch wise attendance
     *
     * @param  int $id
     * @param  date $date
     * @return Response
     */
    public function ofBatchDate($id, $date)
    {
        $enc_id = $id;
        $data = array();
        $id = Encrypt::decrypt($id);
        $date = Encrypt::decrypt($date);

        if (!$id) {
            return redirect()->back()->withFlashMessage('Invalid Batch Token!')->withType('danger');
        }

        if (!$date) {
            return redirect()->back()->withFlashMessage('Invalid Date Token!')->withType('danger');
        }
        try {
            $attendance = $this->attendance
                ->select('attendance')
                ->whereRaw("batch_id = " . $id . " AND created_at = '" . $date . "'")
                ->first();

            if (count($attendance) <= 0) {
                return redirect()->back()->withFlashMessage('No attendance available for this date!')->withType('danger');
            }

            $attendance = json_decode($attendance->attendance);

        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Fetching attendance!')->withType('danger');
        }

        try {
            $students = $this->student_details
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->select('users.id', 'users.first_name', 'users.last_name')
                ->where('student_details.batch_id', $id)
                ->get();

            if (count($students) <= 0) {
                return redirect()->back()->withFlashMessage('No students available to display!')->withType('danger');
            }

            foreach($students as $each_student){
                $enc_std_id = Encrypt::encrypt($each_student->id);
                $data[$enc_std_id] = new \stdClass();
                $data[$enc_std_id]->name = $each_student->first_name.' '.$each_student->last_name;
                $data[$enc_std_id]->status = (in_array($each_student->id,$attendance))?'present':'absent';
            }
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Fetching Students!')->withType('danger');
        }

        return view('attendance.attendance_batch_date', ['data' => $data]);
    }

    /**
     * Attendance in the range
     *
     * @param $request
     * @return Response
     */
    public function rangeAttendance(RangeAttendanceRequest $request)
    {
        if ($request->ajax()) {
            $enc_id = $request['id'];
            $id = Encrypt::decrypt($request['id']);
            if (!$id) {
                return 'Invalid Token!';
            }
            $start_date = $request['start_date'] . ' 00:00:00';
            $end_date = $request['end_date'] . ' 23:59:59';

            try {
                $data = $this->attendance
                    ->whereRaw('batch_id = ' . $id . ' AND created_at > "' . $start_date . '" AND created_at < "' . $end_date . '"')
                    ->orderBy('created_at', 'ASC')
                    ->get();

                if (count($data) <= 0) {
                    return 'No attendance Available!';
                }

            } catch (Exception $e) {
                return 'Error Fetching attendance!';
            }

            $chartObject = new \stdClass();
            $chartObject->element = 'attendance-chart';
            $chartObject->resize = true;
            $chartObject->data = array();
            $chartObject->xkey = 'date';
            $chartObject->ykeys = array('present');
            $chartObject->labels = array('Present');
            $chartObject->lineColors = array('#3c8dbc');
            $chartObject->hideHover = 'auto';
            $chartObject->parseTime = false;
            $chartObject->xLabelAngle = 60;
            $chartObject->stacked = true;

            $max = 0;
            foreach ($data as $each_data) {
                $date = date_create($each_data->created_at);
                $enc_date = Encrypt::encrypt($each_data->created_at);
                $temp = new \stdClass();
                $temp->date = '<a href="' . url('attendance/batch/' . $enc_id . '/' . $enc_date) . '">' . date_format($date, 'M d - D') . '</a>';
                //$temp->date = date_format($date, 'd/m/Y');
                $temp->present = $each_data->present_count;
                if ($max < $each_data->present_count + 3) {
                    $max = $each_data->present_count + 3;
                }
                $chartObject->data [] = $temp;
            }

            $chartObject->ymax = $max;

            return json_encode($chartObject);

        } else {
            return '<h1>Invalid Request!! Access Denied!</h1>';
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
            return redirect()->back()->withFlashMessage('Invalid Token!')->withType('danger');
        }

        try {
            $user = Sentinel::findById($id);
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Invalid Token!')->withType('danger');
        }

        if (!$user->inRole('users')) {
            return redirect()->back()->withFlashMessage('Invalid Reference Token!')->withType('danger');
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

            foreach ($months as $month) {
                $date = date_create($month['created_at']);
                if (!in_array(date_format($date, 'F-Y'), $data)) {
                    $data [] = date_format($date, 'F-Y');
                    $last_month = date_format($date, 'F-Y');
                }
                $working_days[date_format($date, 'F-Y')][] = date_format($date, 'd');
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
                $data[date_format($date, 'F-Y')][] = date_format($date, 'd');
            }

            $present = $data;

            foreach ($months as $month) {
                if (isset($present[$month])) {
                    $absent[$month] = array_diff($working_days[$month], $present[$month]);
                } else {
                    $absent[$month] = $working_days[$month];
                }
            }

        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Fetching attendance!')->withType('danger');
        }

        return view('attendance.attendance_student', [
            'months' => $months,
            'last_month' => $last_month,
            'present' => $present,
            'absent' => $absent,
            'working_days' => $working_days
        ]);
    }

    /**
     * Select batch to Edit.
     *
     * @return Response
     */
    public function edit()
    {
        $year = 2016;
        $marked_batches = array();
        $time_shift = array('morning', 'afternoon', 'evening');

        try {

            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->get();

        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting batch!!')->withType('danger');
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
                    return redirect()->back()->withFlashMessage('Error Selecting batch With Time Shift!!')->withType('danger');
            }
        }

        $batch = $batch->toArray();

        return view('attendance.attendance_edit_select_batch', ['time_shift' => $time_shift, 'batch' => $batch]);
    }

    /**
     * List dates of selected batch to Edit attendance.
     *
     * @param  int $id
     * @return Response
     */
    public function selectDate($id)
    {
        $enc_id = $id;
        $id = Encrypt::decrypt($id);
        $data = array();

        if (!is_numeric($id)) {
            return redirect()->back()->withFlashMessage('Invalid Token!')->withType('danger');
        }

        try {
            $dates = $this->attendance
                ->select('created_at')
                ->where('batch_id', $id)
                ->orderBy('created_at', 'DESC')
                ->get()->toArray();

            if (count($dates) <= 0) {
                return redirect()->back()->withFlashMessage('No attendance available for this batch!!')->withType('danger');
            }

            foreach ($dates as $each_date) {
                $date = date_create($each_date['created_at']);
                $enc_date = Encrypt::encrypt(date_format($date, 'Y-m-d'));
                $data [$enc_date] = date_format($date, 'd/m/Y - D');
            }

            $dates = $data;
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting date!!')->withType('danger');
        }

        return view('attendance.attendance_select_date', ['dates' => $dates, 'id' => $enc_id]);
    }

    /**
     * Page to edit Attendance
     *
     * @param  int $id
     * @param  int $date
     * @return Response
     */
    public function editBatch($id, $date)
    {
        $enc_id = $id;
        $enc_date = $date;
        $id = Encrypt::decrypt($id);
        $date = Encrypt::decrypt($date);
        if (!is_numeric($id)) {
            return redirect()->back()->withFlashMessage('Invalid Batch Token!')->withType('danger');
        }
        if ($date === false) {
            return redirect()->back()->withFlashMessage('Invalid Date Token!')->withType('danger');
        }
        $data = array();

        try {
            $students = $this->student_details
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->select('users.id', 'users.first_name', 'users.last_name')
                ->where('student_details.batch_id', $id)
                ->get();
            if (count($students) <= 0) {
                return redirect()->back()->withFlashMessage('No students found for this Batch!')->withType('danger');
            }

            foreach ($students as $each_student) {
                $data[Encrypt::encrypt($each_student['id'])]['name'] = $each_student['first_name'] . ' ' . $each_student['last_name'];
            }
            $students = $data;
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting Students!')->withType('danger');
        }

        try {
            $attendance = $this->attendance
                ->select('attendance')
                ->whereRaw("batch_id = " . $id . " AND created_at LIKE '" . $date . "%'")
                ->first()->toArray();

            $data = [];
            $attendance = json_decode($attendance['attendance']);
            if (!is_array($attendance)) {
                return redirect()->back()->withFlashMessage('Attendance Data Corrupted!')->withType('danger');
            }
            foreach ($attendance as $each_attendance) {
                $data [] = Encrypt::encrypt($each_attendance);
            }
            $attendance = $data;

        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Fetching Attendance!')->withType('danger');
        }

        return view('attendance.attendance_edit', ['id' => $enc_id, 'students' => $students, 'attendance' => $attendance, 'created_at' => $enc_date]);
    }

    /**
     * Update attendance.
     *
     * @param  AjaxAttendanceRequest $request
     * @return Response
     */
    public function update(AjaxAttendanceRequest $request)
    {
        if ($request->ajax()) {
            $attendance = array();
            $id = Encrypt::decrypt($request['id']);
            $date = Encrypt::decrypt($request['date']);
            $count = sizeof($request['present']);
            if (empty($request['present'])) {
                $present = '';
            } else {
                foreach ($request['present'] as $each) {
                    $attendance [] = (int)Encrypt::decrypt($each);
                }
                $present = json_encode($attendance);
            }
            try {
                $this->attendance
                    /*->where(array(
                        'batch_id' => $id,
                        'created_at' => $date
                    ))*/
                    ->whereRaw("batch_id = " . $id . " AND created_at like '" . $date . "%'")
                    ->update(array(
                        'present_count' => $count,
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
     * Remove attendance.
     *
     * @param  $request
     * @return Response
     */
    public function destroy(DeleteAttendanceRequest $request)
    {
        $enc_id = $request['id'];
        $id = Encrypt::decrypt($request['id']);
        $date = Encrypt::decrypt($request['date']);
        if (!$id) {
            return redirect('edit/attendance/' . $enc_id)->withFlashMessage('Invalid Batch token!')->withtype('danger');
        }
        if (!$date) {
            return redirect('edit/attendance/' . $enc_id)->withFlashMessage('Invalid Date token')->withtype('danger');
        }
        try {
            $this->attendance
                ->whereRaw("batch_id = " . $id . " AND created_at like '" . $date . "%'")
                ->update('del_status', 1);
        } catch (Exception $e) {
            return redirect('edit/attendance/')->withFlashMessage('Failed to delete Attendance!!')->withtype('danger');
        }
        return redirect('edit/attendance/')->withFlashMessage('Attendance Deleted Successfully!')->withtype('success');
    }
}

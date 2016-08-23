<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Attendance;
use App\Batch;
use Illuminate\Database;
use App\Encrypt;

class AttendanceController extends Controller
{

    protected $attendance, $batch;

    public function __construct(Attendance $attendance, Batch $batch)
    {
        $this->middleware('redirectStandardUser', ['except' => ['show']]);
        $this->middleware('redirectFaculty', ['only' => ['edit', 'update', 'destroy']]);
        $this->attendance = $attendance;
        $this->batch = $batch;
    }

    /**
     * Show Page to Mark attendance
     *
     * @return Response
     */
    public function index()
    {
        return view('attendance.attendance_create');
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
     * Display attendance.
     *
     * @return Response
     */
    public function show($id)
    {
        //
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

        $batches = $this->batch
            ->where('id', $id)
            ->get();

        foreach ($batches as $batch) {
            $data['batch']['batch'] = $batch['batch'];
            $data['batch']['time_shift'] = $batch['time_shift'];
            $data['batch']['year'] = $batch['year'];
            $data['batch']['in_charge'] = $batch['in_charge'];
        }


        $attendance = $this->attendance
            ->where('batch_id', $id)
            ->get();


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

        if (!is_numeric($id)) {
            return view('attendance.attendance_student', ['flash_message' => 'Invalid Token!', 'type' => 'danger']);
        }

        $user = Sentinel::findById($id);

        if ($user->roles()->get() != 'users') {
            return view('attendance.attendance_student', ['flash_message' => 'Invalid Reference Token!', 'type' => 'danger']);
        }
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

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
use App\Cons;
use Mockery\CountValidator\Exception;

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
     * Display Batch to select.
     *
     * @return Response
     */
    public function selectBatch()
    {
        $year = Cons::$year;

        try {
            $time_shift = array('morning','afternoon','evening');

            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->get();

        } catch(Exception $e){
            return redirect('attendance/batch')->withFlashMessage('Error Selecting batch')->withType('error');
        }

        foreach($batch as $each_batch){
            $each_batch['enc_id'] = Encrypt::encrypt($each_batch['id']);
        }

        $batch = $batch->toArray();

        return view('attendance.attendance_select_batch',['time_shift'=>$time_shift,'batch'=>$batch]);
    }

    /**
     * Display Students to select.
     *
     * @return Response
     */
    public function selectStudent()
    {
        $year = Cons::$year;

        try {
            $time_shift = array('morning','afternoon','evening');

            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->get();

        } catch(Exception $e){
            return redirect('attendance/batch')->withFlashMessage('Error Selecting batch')->withType('error');
        }

        foreach($batch as $each_batch){
            $each_batch['enc_id'] = Encrypt::encrypt($each_batch['id']);
        }

        $batch = $batch->toArray();

        return view('attendance.attendance_select_student',['time_shift'=>$time_shift,'batch'=>$batch]);
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

        try{
            $batches = $this->batch
                ->where('id', $id)
                ->get();
        }catch(Exception $e){
            return view('attendance.attendance_batch', ['flash_message' => 'Database Error!', 'type' => 'danger']);
        }


        foreach ($batches as $batch) {
            $data['batch']['batch'] = $batch['batch'];
            $data['batch']['time_shift'] = $batch['time_shift'];
            $data['batch']['year'] = $batch['year'];
            $data['batch']['in_charge'] = $batch['in_charge'];
        }

        try{
            $attendance = $this->attendance
                ->where('batch_id', $id)
                ->get();
        }catch(Exception $e){
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

        try{
            $user = Sentinel::findById($id);
        }catch(Exception $e){
            return view('attendance.attendance_student', ['flash_message' => 'Database Error!', 'type' => 'danger']);
        }

        if ($user->roles()->get() != 'users') {
            return view('attendance.attendance_student', ['flash_message' => 'Invalid Reference Token!', 'type' => 'danger']);
        }

        return view('attendance.attendance_student',['data'=>$data]);
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

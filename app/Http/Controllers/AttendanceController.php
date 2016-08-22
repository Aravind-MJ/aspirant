<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Attendance;
use App\Batch;
use Illuminate\Database;

class AttendanceController extends Controller
{

    protected $attendance,$batch;

    public function __construct(Attendance $attendance,Batch $batch)
    {
        $this->attendance = $attendance;
        $this->batch = $batch;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
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
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $mode = explode('-', $id);

        $data = array();
        $i = 0;

        switch ($mode[0]) {
            case 'batch':
                if(!is_numeric($mode[1])){
                    return view('attendance.attendance_batch',['flash_message'=>'Invalid Request!','type'=>'danger']);
                }

                $batch = $this->batch
                    ->where('id',$mode[1])
                    ->get();

                $data['batch'] = $batch;


                $attendance = $this->attendance
                    ->where('batch_id', $mode[1])
                    ->orderBy('created_at', 'desc')
                    ->get();


                foreach ($attendance as $adata) {
                    $data['attendance'][$i]['id'] = $adata['id'];
                    $data['attendance'][$i]['batch_id'] = $adata['batch_id'];
                    $data['attendance'][$i]['attendance'] = json_decode($adata['attendance']);
                    $data['attendance'][$i]['absent_count'] = $adata['absent_count'];
                    $data['attendance'][$i]['date'] = $adata['created_at'];
                    $i++;
                }

                return view('attendance.attendance_batch', ['data' => $data]);

            default:
                return view('attendance.attendance_batch',['flash_message'=>'Invalid Request!','type'=>'danger']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

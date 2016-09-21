<?php

namespace App\Http\Controllers;

use App\Examdetails;
use App\MarkDetails;
use App\StudentDetails;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Batch;
use App\Encrypt;
use App\Cons;
use Mockery\CountValidator\Exception;

use App\Http\Requests\FetchStudentsRequest;
use App\Http\Requests\StoreMarkRequest;

class MarkDetailsController extends Controller
{

    protected $users, $batch, $student_details, $exam_details, $mark_details;

    public function __construct(User $users, Batch $batch, StudentDetails $student_details, Examdetails $exam_details, MarkDetails $mark_details)
    {
        $this->batch = $batch;
        $this->student_details = $student_details;
        $this->users = $users;
        $this->exam_details = $exam_details;
        $this->mark_details = $mark_details;
    }

    /**
     * Fetch students of given Batch Id
     *
     * @param $request
     * @return Response
     */
    public function fetchStudents(FetchStudentsRequest $request)
    {
        if ($request->ajax()) {
            $batch_id = $request['id'];
            $exam_id = $request['exam_id'];
            if ($request['id'] == '0') {
                return '<h4>Select a Batch to View students</h4>';
            }
            $id = Encrypt::decrypt($request['id']);
            if (!is_numeric($id)) {
                return 'Invalid Token!';
            }

            $exam_id = Encrypt::decrypt($exam_id);
            if (!$exam_id) {
                return 'Invalid Token!';
            }
            $data = array();
            try {
                $students = $this->student_details
                    ->join('users', 'users.id', '=', 'student_details.user_id')
                    ->select('users.id', 'users.first_name', 'users.last_name')
                    ->where('student_details.batch_id', $id)
                    ->get();

                if (count($students) <= 0) {
                    return '<h4>No students Available to display</h4>';
                }

                foreach ($students as $each_student) {
                    $check = $this->mark_details
                        ->where(array(
                            'exam_id' => $exam_id,
                            'user_id' => $id
                        ))
                        ->get();
                    if (count($check) > 0) {
                        return '<h4>Marks Already Entered!</h4>';
                    }
                    $data[Encrypt::encrypt($each_student['id'])]['name'] = $each_student['first_name'] . ' ' . $each_student['last_name'];
                }

                $students = $data;

            } catch (Exception $e) {
                return 'Error Selecting Students!';
            }

            return view('mark.students_section', ['students' => $students, 'batch_id' => $batch_id]);

        } else {
            return '<h1>Invalid Request!! Access Denied</h1>';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array();
        $year = Cons::$year;
        $time_shifts = array('morning', 'afternoon', 'evening');
        try {
            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->get();

            $data['batch']['0'] = 'Select Batch';
            foreach ($batch as $each_batch) {
                $data['batch'][Encrypt::encrypt($each_batch['id'])] = $each_batch['batch'] . ' - ' . $time_shifts[$each_batch['time_shift'] - 1];
            }
            $batch = $data['batch'];

        } catch (Exception $e) {
            return back()->withFlashMessage('Error Selecting batch')->withType('error');
        }

        try {
            $exams = $this->exam_details
                ->get();
            foreach ($exams as $exam) {
                $date = date_create($exam['exam_date']);
                $data['exams'][Encrypt::encrypt($exam['id'])] = $exam['name'] . ' - ' . date_format($date, 'd/m/Y');
            }
            $exams = $data['exams'];
        } catch (Exception $e) {
            return back()->withFlashMessage('Error Selecting Exam Details')->withType('error');
        }

        return view('mark.register_mark', ['batch' => $batch, 'exam' => $exams]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @param $request
     * @return Response
     */
    public function store($id, StoreMarkRequest $request)
    {
        try {
            $exam_id = Encrypt::decrypt($request['exam_id']);
            //$id = Encrypt::decrypt($request['batch_id']);
            //$count = count($request['markof']);
            if (!array_filter($request['markof'], 'is_numeric')) {
                return redirect('mark/create')->withFlashMessage('
                    <h4>Error!</h4>
                    <ol>
                        <li>Enter only integers as Mark</li>
                        <li>Enter marks of all students</li>
                    </ol>
                ')->withType('danger');
            }
            foreach ($request['markof'] as $enc_id => $mark) {
                $id = Encrypt::decrypt($enc_id);

                $check = $this->mark_details
                    ->where(array(
                        'exam_id' => $exam_id,
                        'user_id' => $id
                    ))
                    ->get();

                if (count($check) > 0) {
                    return redirect('mark/create')->withFlashMessage('Mark already entered.')->withType('danger');
                }

                $this->mark_details
                    ->insert([
                        ['exam_id' => $exam_id, 'user_id' => $id, 'mark' => $mark]
                    ]);

            }
        } catch (Exception $e) {
            return redirect('mark/create')->withFlashMessage('Error Adding mark to database')->withType('danger');
        }

        return redirect('mark/create')->withFlashMessage('Mark successfully added')->withType('success');

    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = array();
        $year = Cons::$year;
        $time_shifts = array('morning', 'afternoon', 'evening');
        try {
            $batch = $this->batch
                ->select('id', 'batch', 'time_shift')
                ->where('year', $year)
                ->get();

            $data['batch']['0'] = 'Select Batch';
            foreach ($batch as $each_batch) {
                $data['batch'][Encrypt::encrypt($each_batch['id'])] = $each_batch['batch'] . ' - ' . $time_shifts[$each_batch['time_shift'] - 1];
            }
            $batch = $data['batch'];

        } catch (Exception $e) {
            return back()->withFlashMessage('Error Selecting batch')->withType('error');
        }

        try {
            $exams = $this->exam_details
                ->get();
            foreach ($exams as $exam) {
                $date = date_create($exam['exam_date']);
                $data['exams'][Encrypt::encrypt($exam['id'])] = $exam['name'] . ' - ' . date_format($date, 'd/m/Y');
            }
            $exams = $data['exams'];
        } catch (Exception $e) {
            return back()->withFlashMessage('Error Selecting Exam Details')->withType('error');
        }

        return view('mark.view_mark', ['batch' => $batch, 'exam' => $exams]);
    }

    /**
     * Fetch students of given Batch Id
     *
     * @param $request
     * @return Response
     */
    public function fetchMark(FetchStudentsRequest $request)
    {
        if ($request->ajax()) {
            $batch_id = $request['id'];
            $exam_id = $request['exam_id'];
            if ($request['id'] == '0') {
                return '<h4>Select a Batch to View students</h4>';
            }
            $id = Encrypt::decrypt($request['id']);
            if (!is_numeric($id)) {
                return 'Invalid Token!';
            }

            $exam_id = Encrypt::decrypt($exam_id);
            if (!$exam_id) {
                return 'Invalid Token!';
            }
            $data = array();
            try {
                $students = $this->student_details
                    ->join('users', 'users.id', '=', 'student_details.user_id')
                    ->select('users.id', 'users.first_name', 'users.last_name')
                    ->where('student_details.batch_id', $id)
                    ->get();

                if (count($students) <= 0) {
                    return '<h4>No students Available to display</h4>';
                }

                foreach ($students as $each_student) {
                    $check = $this->mark_details
                        ->where(array(
                            'exam_id' => $exam_id,
                            'user_id' => $id
                        ))
                        ->first()->toArray();
                    if (count($check) <= 0) {
                        return '<h4>No marks available!</h4>';
                    }
                    $data[Encrypt::encrypt($each_student['id'])]['name'] = $each_student['first_name'] . ' ' . $each_student['last_name'];
                    $data[Encrypt::encrypt($each_student['id'])]['mark'] = $check['mark'];
                }

                $students = $data;

            } catch (Exception $e) {
                return 'Error Selecting Students!';
            }

            return view('mark.mark_section', ['students' => $students, 'batch_id' => $batch_id]);

        } else {
            return '<h1>Invalid Request!! Access Denied</h1>';
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
     * @param  $request
     * @return Response
     */
    public function update(StoreMarkRequest $request)
    {
        try {
            $exam_id = Encrypt::decrypt($request['exam_id']);
            //$id = Encrypt::decrypt($request['batch_id']);
            //$count = count($request['markof']);
            if (!array_filter($request['markof'], 'is_numeric')) {
                return redirect('mark/create')->withFlashMessage('
                    <h4>Error!</h4>
                    <ol>
                        <li>Enter only integers as Mark</li>
                        <li>Enter marks of all students</li>
                    </ol>
                ')->withType('danger');
            }
            foreach ($request['markof'] as $enc_id => $mark) {
                $id = Encrypt::decrypt($enc_id);

                $check = $this->mark_details
                    ->where(array(
                        'exam_id' => $exam_id,
                        'user_id' => $id
                    ))
                    ->get();

                if (count($check) <= 0) {
                    return redirect('mark')->withFlashMessage('Mark doesn\'t Exist.')->withType('danger');
                }

                $this->mark_details
                    ->where(array(
                        'exam_id' => $exam_id,
                        'user_id' => $id
                    ))
                    ->update(['mark' => $mark]);

            }
        } catch (Exception $e) {
            return redirect('mark')->withFlashMessage('Error Updating mark to database')->withType('danger');
        }

        return redirect('mark')->withFlashMessage('Mark successfully Updated')->withType('success');
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

<?php

namespace App\Http\Controllers;

use App\Encrypt;
use App\Exceptions\SmsApiException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SmsApiRequest;
use App\Http\Controllers\Controller;
use App\Batch;
use App\Faculty;
use App\StudentDetails;
use App\SmsHistory;
use Mockery\CountValidator\Exception;

class SmsApiController extends Controller
{
    protected $students, $faculty, $batches;
    protected $user_name = 'aspirant';
    protected $password = 'aspirant@123';
    protected $sender = 'ASPRNT';
    protected $route = 'TA';
    protected $msg_type = 1;
    protected $receiver, $message;

    public function __construct(Faculty $faculty, Batch $batch, StudentDetails $students)
    {
        $this->batches = $batch;
        $this->students = $students;
        $this->faculty = $faculty;
    }

    public function students()
    {
        $data = array();
        $type = 'students';
        try {
            $students = $this->students
                ->join('users', 'users.id', '=', 'student_details.user_id')
                ->select('first_name', 'last_name', 'user_id', 'phone')
                ->get();
            if (count($students) <= 0) {
                return redirect()->back()->withFlashMessage('No Students Found!!')->withType('danger');
            }
            foreach ($students as $each_student) {
                $data[$each_student->phone] = $each_student->first_name . ' ' . $each_student->last_name . ' (' . $each_student->phone . ')';
            }
            $students = $data;
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting Students!!')->withType('danger');
        }

        return view('smsapi.send', ['numbers' => $students, 'type' => $type]);
    }

    public function batches()
    {
        $data = array();
        $time_shift = ['Morning','Afternoon','evening'];
        $type = 'batches';
        try {
            $batch = $this->batches
                ->get();
            if (count($batch) <= 0) {
                return redirect()->back()->withFlashMessage('No Batch Found!!')->withType('danger');
            }
            foreach ($batch as $each_batch) {
                $enc_id = Encrypt::encrypt($each_batch->id);
                $data[$enc_id] = $each_batch->batch . ' - ' . $time_shift[$each_batch->time_shift-1];
            }
            $batch = $data;
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting batch!!')->withType('danger');
        }

        return view('smsapi.send', ['numbers' => $batch, 'type' => $type]);
    }

    public function faculty()
    {
        $data = array();
        $type = 'faculty';
        try {
            $students = $this->faculty
                ->join('users', 'users.id', '=', 'faculty_details.user_id')
                ->select('first_name', 'last_name', 'user_id', 'phone')
                ->get();
            if (count($students) <= 0) {
                return redirect()->back()->withFlashMessage('No Faculty Found!!')->withType('danger');
            }
            foreach ($students as $each_student) {
                $data[$each_student->phone] = $each_student->first_name . ' ' . $each_student->last_name . ' (' . $each_student->phone . ')';
            }
            $students = $data;
        } catch (Exception $e) {
            return redirect()->back()->withFlashMessage('Error Selecting Faculty!!')->withType('danger');
        }

        return view('smsapi.send', ['numbers' => $students, 'type' => $type]);
    }

    /**
     * Sms Api
     *
     * @throws SmsApiException
     * @param $request
     * @return Response
     */
    public function sms(SmsApiRequest $request)
    {
        $numbers = array();
        $data = array();
        if ($request['type'] == 'batches') {
            foreach($request['numbers'] as $each){
                $batch_id = Encrypt::decrypt($each);
                $students = $this->students
                    ->join('users', 'users.id', '=', 'student_details.user_id')
                    ->select('phone')
                    ->where('batch_id',$batch_id)
                    ->get()->toArray();

                $data = array_merge($data,$students);
            }
            foreach($data as $each){
                $numbers []= $each['phone'];
            }
            $numbers = array_filter($numbers);
        } else {
            $numbers = array_filter($request['numbers']);
        }
        $sms_history = new SmsHistory;
        $sms_history->type = $request['type'];
        $sms_history->recipients = json_encode($numbers);
        $sms_history->message = $request['message'];
        $sms_history->user_id = json_encode(Sentinel::getUser()->id);

        $this->message = urlencode($request['message']);
        $this->receiver = implode(',', $numbers);
        $data = "uname=" . $this->user_name
            . "&password=" . $this->password
            . "&sender=" . $this->sender
            . "&receiver=" . $this->receiver
            . "&route=" . $this->route
            . "&msgtype=" . $this->msg_type
            . "&sms=" . $this->message;
        $result = $this->send($data);
        switch ($result) {
            case 101:
                $res = "Invalid username/password";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 102:
                $res = "Sender not exist!";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 103:
                $res = "Receiver not exist!";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 104:
                $res = "Invalid route (PA,TA,SA & I)!";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 105:
                $res = "Invalid message type!";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 106:
                $res = "SMS content not exist!";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 107:
                $res = "Transaction template mismatch";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 108:
                $res = "Low credits in the specified route";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 109:
                $res = "Account is not eligible for API";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;
            case 110:
                $res = "Promotional route will be working from 9am to 9pm only";
                return redirect()->back()->withFlashMessage($res)->withType('danger');
                break;

            default:
                $sms_history->msg_id = $result;
                //$sms_history->save();
                $res = "Your sms has successfully sent!";
                return redirect('smsHistory')->withFlashMessage($res)->withType('Success');
        }
    }

    private function send($data)
    {
        $ch = curl_init('http://msgbox.in/httpapi/smsapi');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);

    }
}

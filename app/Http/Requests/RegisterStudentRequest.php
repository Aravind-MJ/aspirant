<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterStudentRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        switch($this->method())
    {
        case 'GET':
        case 'DELETE':
        {
            return [];
        }
        case 'POST':
        {
            return [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'batch_id' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'guardian' => 'required',
            'address' => 'required|min:5',
            'phone' => 'required|regex:/[0-9]{10}/',
            'school' => 'required|regex:/^[A-Za-z. - ,]+$/',
            'cee_rank' => 'required|numeric',
            'percentage' => 'required|numeric',   
            'email' => 'required|email|unique:users,email',
            'photo' => 'mimes:jpeg,bmp,png'
        ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
            'batch_id' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'guardian' => 'required',
            'address' => 'required|min:5',
            'phone' => 'required|regex:/[0-9]{10}/',
            'school' => 'required|regex:/^[A-Za-z. - ,]+$/',
            'cee_rank' => 'required|numeric',
            'percentage' => 'required|numeric',
            'photo' => 'mimes:jpeg,bmp,png'
        ];
        }
        default:break;
    }
        
    }

}

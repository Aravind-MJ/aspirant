<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class PublishFacultyRequest extends Request {

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
            'qualification' => 'required',
            'subject' => 'required',
            'phone' => 'required|regex:/[0-9]{10}/',
            'address' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
            'photo' =>'required|mimes:jpeg,png,jpg|max:2000'
        ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
            'qualification' => 'required',
            'subject' => 'required',
            'phone' => 'required|regex:/[0-9]{10}/',
            'address' => 'required|min:5',
             'photo' =>'required|mimes:jpeg,png,jpg|max:2000'
        ];
        }
        default:break;
    }
        
    }

}

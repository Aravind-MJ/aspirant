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
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'qualification' => 'required',
            'subject' => 'required',
            'subject' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
            'photo' => 'required'
        ];
    }

}

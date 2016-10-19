<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PublishFeedetailsRequest extends Request {

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
            
//            'batch_id' => 'required|exists:batch_id,total_fee',
//            'first' => 'required|numeric',
//            'second' => 'required|numeric',
//            'third' => 'required|numeric',
//            'total_fee' => 'required|numeric',
//            'discount' => 'required|numeric',
      //     'balance' => 'required|numeric'
            
        ];
        }
        case 'PUT':
        case 'PATCH':
        {
             return [
//            'batch_id' => 'required',
//            'first' => 'required|numeric',
//            'second' => 'required|numeric',
//            'third' => 'required|numeric',
//            'total_fee' => 'required|numeric',
//            'discount' => 'required|numeric',
      //     'balance' => 'required|numeric',
            
        
        ];
        }
        default:break;
    }
        
    }

}

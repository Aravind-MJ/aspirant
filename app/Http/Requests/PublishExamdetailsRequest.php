<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PublishExamdetailsRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }


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
          'type_id' => 'required',
          'exam_date' => 'required',
         
         
        ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
             'type_id' => 'required',
             'exam_date' => 'required',
          
       ];
       }
       default:break;
   }
       
   }

}

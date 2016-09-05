<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreMarkRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam_id' => 'required|alpha_num',
            'markof' => 'required|array'
        ];
    }
}

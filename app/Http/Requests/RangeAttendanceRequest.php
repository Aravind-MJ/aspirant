<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Sentinel;

class RangeAttendanceRequest extends Request
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
            'id' => 'string|required',
            'start_date' => 'date|required',
            'end_date' => 'date|required'
        ];
    }
}

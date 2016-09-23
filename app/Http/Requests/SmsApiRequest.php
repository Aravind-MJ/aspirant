<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SmsApiRequest extends Request
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
            'type' => 'required|in:batches,students,faculty',
            'numbers' => 'required|array',
            'message' => 'required|regex:/([A-Za-z0-9]{1,}[ ]{1,}){1,}/'
        ];
    }
}

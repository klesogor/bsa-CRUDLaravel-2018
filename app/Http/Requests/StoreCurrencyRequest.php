<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurrencyRequest extends FormRequest
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
            'id' => 'required|integer|min:0',
            'name' => 'required|string',
            'short_name' => 'required|string',
            'actual_course' => 'required|float',
            'actual_course_date' =>'required|date_format:"Y-m-d H-i-s"',
            'active' => 'required|boolean',
        ];
    }
}

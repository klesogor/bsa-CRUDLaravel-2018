<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'short_name' => 'sometimes|string',
            'actual_course' => 'sometimes',
            'actual_course_date' =>'sometimes|date_format:Y-m-d H-i-s',
            'active' => 'sometimes|boolean',
        ];
    }
}

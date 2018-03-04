<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'date'     => 'required|date_format:Y-m-d',
            'time'     => 'required|date_format:H:i',
            'body'     => 'required',
            'priority' => ['required', 'regex:(low|mid|high)'],
        ];
    }
}

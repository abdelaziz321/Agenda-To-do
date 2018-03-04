<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteStoreRequest extends FormRequest
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
        // "unique:notes" - you must check it like : unique in notes where user_id == Auth::id(),
        // not in all table
        return [
            'title' => 'required|string|max:20',
            'body'  => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name'  =>  'required|regex:/(^[A-Za-z ]+$)+/|max:100|not_in:undefined',
            'age'   =>  'required|numeric|max:100|not_in:undefined',
            'address'   =>  'required|max:300|not_in:undefined',
        ];
    }

    public  function messages()
    {
        return [
            'name.required'=>'Please enter member name.',
            'name.regex'=>'The name only the word',
            'name.max'=>'The name max is 100 character.',
            'name.not_in'=>'The name is not undefined',
            'age.required'=>'Please enter member age.',
            'age.numeric'=>'The age is mush numberic.',
            'age.max'=>'The name too large',
            'address.required'=>'Please enter member address.',
            'address.max'=>'The address max is 300 character.',
            'address.not_in'=>'The address is not undefined.'
        ];
    }
}

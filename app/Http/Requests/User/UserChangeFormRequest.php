<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UserChangeFormRequest extends Request
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
            'password' => 'required',
            'confirm_password' => 'required|same:password|min:8'
        ];
    }

    public function messages()
    {
        return [
            'summary.required' => 'Please enter Profile Summary.',
        ];
    }

}

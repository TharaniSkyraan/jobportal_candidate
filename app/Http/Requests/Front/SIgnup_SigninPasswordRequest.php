<?php

namespace App\Http\Requests\Front;

use Auth;
use App\Http\Requests\Request;

class SIgnup_SigninPasswordRequest extends Request
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
        
        if($this->provider==''){

            switch ($this->is_login) {
                case 'yes':{
                    return [
                        'password' => 'required',
                    ];
                }
                case 'no': {
                            return [
                                'password' => 'required|min:8|max:150',
                            ];
                        }
                default:break;
            }
        }
        return [];
    }

    public function messages()
    {
        return [
            'password.required' => __('Password is required'),
            'password.min' => __('The password should be more than 8 characters long'),
        ];
    }

}

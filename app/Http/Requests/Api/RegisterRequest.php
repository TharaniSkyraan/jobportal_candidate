<?php

namespace App\Http\Requests\Api;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends Request
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


        $rules =  [
            'email' => 'required',
        ];
        if($this->provider==null)
        {            
            if(empty($this->id)){
                $rules['phone'] = 'required|unique:users,phone,'.($this->email??null).',email,deleted_at,NULL';
            }
            $rules['password'] = 'required|max:30';
        }

        return $rules;
    }
    public function failedValidation(Validator $validator)
    {
        $errors = array();
        $messages = $validator->errors()->messages();
        $message = '';
        foreach ($messages as $key => $value) {
            $errors[$key] = $value[0];
            if(empty($message)){
                $message = $value[0];
            }
        }
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $message,
            'data'=> []
        ]));
    }

    public function messages()
    {
        return [
            'password.required' => __('Password is required'),
            'phone.unique' => __('This phone number is already registered. Please choose a different one'),
            'email.required' => __('Email is required'),
            'name.required' => __('Name is required'),
        ];
    }

}
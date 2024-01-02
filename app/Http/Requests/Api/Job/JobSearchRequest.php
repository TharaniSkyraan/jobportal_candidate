<?php

namespace App\Http\Requests\Api\Job;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class JobSearchRequest extends Request
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
        $rules =  [];
        if(empty($this->location) && empty($this->designation) && !isset($this->is_fresher_api))
        {            
            $rules =  [
                'designation' => 'required',
                'location' => 'required',
            ];
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
            'data'=> $errors
        ]));
    }

    public function messages()
    {
        return [
            'id.required' => __('Id is required'),
        ];
    }

}
<?php

namespace App\Http\Requests\Api;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ResumeUploadRequest extends Request
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
            'device_token' => 'required',
            'device_type' => 'required',
            'file' => 'required|file|mimes:pdf,docx,doc,txt,rtf|max:2048',
        ];

        return $rules;
    }
    public function failedValidation(Validator $validator)
    {
        $errors = array();
        $messages = $validator->errors()->messages();
        foreach ($messages as $key => $value) {
            $errors[$key] = $value[0];
        }
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'=> $errors
        ]));
    }

    public function messages()
    {
        return [
            'file.required' => __('File is required'),
        ];
    }

}
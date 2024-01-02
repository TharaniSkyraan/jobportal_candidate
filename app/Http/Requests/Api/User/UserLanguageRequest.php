<?php

namespace App\Http\Requests\Api\User;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserLanguageRequest extends Request
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
       
        $rules = [
            'language_id' => 'required|unique:user_languages,language_id,'.($this->id??0).',id,deleted_at,NULL,user_id,'.\Auth::user()->id,
            "level_id" => "required",
        ];

        if(empty($this->read) && empty($this->write) && empty($this->speak)){
            $rules['read'] = "required";
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
            'lang_id.unique' => 'The language has already been taken',
            'lang_id.required' => 'Please select language',
            'level_id.required' => 'Please select the proficiency level',
            'read.required' => 'Please select any on of read|write|speak',
        ];
    }

}
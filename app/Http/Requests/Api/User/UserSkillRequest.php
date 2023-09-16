<?php

namespace App\Http\Requests\Api\User;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserSkillRequest extends Request
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
            'skill_id' => 'required|unique:user_skills,skill_id,'.($this->id??0).',id,deleted_at,NULL,user_id,'.\Auth::user()->id,
            "level_id" => "required",
        ];

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
            'skill_id.unique' => 'The skill has already been taken.',
            'skill_id.required' => 'Please select skill.',
            'level_id.required' => 'Please select experience.',
        ];
    }

}
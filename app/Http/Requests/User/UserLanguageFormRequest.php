<?php

namespace App\Http\Requests\User;

use Auth;
use App\Http\Requests\Request;

class UserLanguageFormRequest extends Request
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
        switch ($this->method()) {                
            case 'PUT': {
                return [
                    'language_id' => 'required|unique:user_languages,language_id,'.($this->id??null).',id,deleted_at,NULL,user_id,'.\Auth::user()->id,
                    "language_level_id" => "required",
                ];
            }
            case 'POST': {
                
                    return [
                        'language_id' => 'required|unique:user_languages,language_id,0,id,deleted_at,NULL,user_id,'.\Auth::user()->id,
                        "language_level_id" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'language_id.unique' => 'The language has already been taken',
            'language_id.required' => 'Please select language',
            'language_level_id.required' => 'Please select the proficiency level',
        ];
    }

}

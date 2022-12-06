<?php

namespace App\Http\Requests\User;

use Auth;
use App\Http\Requests\Request;

class UserSkillFormRequest extends Request
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
                    'skill_id' => 'required|unique:user_skills,skill_id,'.($this->id??null).',id,deleted_at,NULL,user_id,'.\Auth::user()->id,
                    "level_id" => "required",
                ];
            }
            case 'POST': {
                    return [
                        'skill_id' => 'required|unique:user_skills,skill_id,0,id,deleted_at,NULL,user_id,'.\Auth::user()->id,
                        "level_id" => "required",
                    ];
                }
            default:break;
        }
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

<?php

namespace App\Http\Requests\Api\User;

use Auth;
use App\Http\Requests\Request;

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
        
        'skill_id' => 'required|unique:user_skills,skill_id,'.($this->id??null).',id,deleted_at,NULL,user_id,'.\Auth::user()->id,
        "level_id" => "required",
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

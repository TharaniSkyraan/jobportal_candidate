<?php

namespace App\Http\Requests\Api\User;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateProfileRequest extends Request
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

        $email = Auth::user()->email;
        $rules =  [
            'name' => 'required|max:80',
            'phone' => 'required|unique:users,phone,'.(Auth::user()->id).',id,deleted_at,NULL',
            // 'skill_id' => 'required|unique:user_skills,skill_id,'.($this->id??null).',id,deleted_at,NULL,user_id,'.\Auth::user()->id,
            'image' => 'required',
            // 'alternative_phone' => 'required',
            'gender' => 'required',
            'marital_status_id' => 'required',
            'location' => 'required',
            'country_id' => 'required',
            'date_of_birth' => 'required',
        ];

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
            'image.required' => __('Image is required'),
        ];
    }

}
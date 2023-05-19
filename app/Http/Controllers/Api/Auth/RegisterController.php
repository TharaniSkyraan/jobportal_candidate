<?php

namespace App\Http\Controllers\Api\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use Validator;
   
class RegisterController extends BaseController
{
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if(empty($request->provider))
        {
            // normal Login
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
            } 
        }else{
            // social login
            $user = User::whereEmail($request->email)->first();
            if(isset($user)){
                $user = Auth::login($user, true);
            }
        }        

        if(isset($user))
        {
            $update = User::find($user->id);
            $update->device_token = $request->device_token;
            $update->device_type = $request->device_type;
            $update->save();
            $success['token'] =  $user->createToken($request->email)->accessToken; 
            $success['name'] =  $user;
            return $this->sendResponse($success, 'User login successfully.');
        }        
        
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
}
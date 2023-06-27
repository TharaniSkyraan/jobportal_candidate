<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

class UserController extends BaseController
{

    
    public function updateMyProfile(UserFrontRegisterFormRequest $request)
    { 
        $request['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $user = User::findOrFail(Auth::user()->id)->update($request->all());
    
        return \Redirect::route('home')->with('message',' Updated Succssfully!');
    }

    public function updateCareer(Request $request)
    { 
        $request['expected_salary'] = (int) str_replace(',',"",$request->input('expected_salary'));
        $request['location'] = $request->location;       
        $request['career_title'] = $request->career_title;
        $request['total_experience'] = $request->exp_in_year.'.'.$request->exp_in_month;
        $request['salary_currency'] = $request->salary_currency;
        $request['country_id'] = $request->country_id;
        $user = User::findOrFail(Auth::user()->id)->update($request->all());
    
        return \Redirect::back()->with('message',' Updated Succssfully!');
    }
    
}
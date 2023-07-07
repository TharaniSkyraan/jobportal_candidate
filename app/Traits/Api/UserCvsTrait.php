<?php

namespace App\Traits\Api;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\UserCv;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\User\UserCvRequest;
use Illuminate\Support\Facades\Storage;

trait UserCvsTrait
{

    public function cvs()
    {
        $user = Auth::user();  
        $response['resume1'] = $user->UserCvs[0]??[];
        $response['resume2'] = $user->UserCvs[1]??[];
        return $this->sendResponse($response);
    }

    public function cvsUpdate(UserCvRequest $request)
    {
        $id = $request->cv_id??NULL;
        if($id){
            $userCv = UserCv::find($id);
        }else{
            $user = Auth::user();    
            $userCv = new UserCv();
            $userCv->user_id = $user->id;
        }    
        $userCv->path = $request->path??"";
        $userCv->cv_file = $request->url??"";
        $userCv->save();  

        $message = "Updated successfully.";

        return $this->sendResponse(['cv_id'=>$userCv->id], $message); 
   
    }

    public function makeDefaultCv(Request $request)
    {
        $id = $request->input('id');
        try {
            $UserCv = UserCv::findOrFail($id);
            $UserCv->is_default = 1;
            $UserCv->update();
            $this->updateDefaultCv($id);
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    private function updateDefaultCv($cv_id)
    {
        UserCv::where('is_default', '=', 1)->where('id', '<>', $cv_id)->update(['is_default' => 0]);
    }

    public function downloadCv($cv_id)
    {
        $usercv = UserCv::find($cv_id);
        $extension = pathinfo($usercv->path, PATHINFO_EXTENSION);
        $file_name = $usercv->user->getName();
 
        $headers = [
            'Content-Type'        => 'application/'.$extension,
            'Content-Disposition' =>  'attachment; filename="'. $file_name.'.'.$extension.'"',
        ];
 
        return \Response::make(Storage::disk('s3')->get($usercv->path), 200, $headers);   
    }

    public function deleteUserCv(Request $request)
    {

        $id = $request->input('id');
        try {
            $UserCv = UserCv::findOrFail($id);            
            $resume_path = $UserCv->path;
            $UserCv->forceDelete();
            Storage::disk('s3')->delete($resume_path); 
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }

}

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
        if(count($user->UserCvs)!=0){
            $userCv1 = array(
                'id'         => $user->UserCvs[0]['id'],
                'cv_file'    => $user->UserCvs[0]['cv_file'],
                'path'       => $user->UserCvs[0]['path'],
                'is_default' => $user->UserCvs[0]['is_default'],
                'created_at' => (!empty($user->UserCvs[0]['created_at']))?Carbon::parse($user->UserCvs[0]['created_at'])->getTimestampMs():"",
                'updated_at' => (!empty($user->UserCvs[0]['updated_at']))?Carbon::parse($user->UserCvs[0]['updated_at'])->getTimestampMs():"",
           
            );
        }
        if(count($user->UserCvs)==2){
            $userCv2 = array(
                'id'         => $user->UserCvs[1]['id'],
                'cv_file'    => $user->UserCvs[1]['cv_file'],
                'path'       => $user->UserCvs[1]['path'],
                'is_default' => $user->UserCvs[1]['is_default'],
                'created_at' => (!empty($user->UserCvs[1]['created_at']))?Carbon::parse($user->UserCvs[1]['created_at'])->getTimestampMs():"",
                'updated_at' => (!empty($user->UserCvs[1]['updated_at']))?Carbon::parse($user->UserCvs[1]['updated_at'])->getTimestampMs():"",
           
            );
        }
        $response['resume1'] = $userCv1??[];
        $response['resume2'] = $userCv2??[];
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

    public function makeDefaultCv($id)
    {
        try {
            $UserCv = UserCv::findOrFail($id);
            $UserCv->is_default = 1;
            $UserCv->update();
            $this->updateDefaultCv($id);
            return $this->sendResponse('', 'Success');       
        } catch (ModelNotFoundException $e) {
            return $this->sendResponse('', 'Something Went Wrong.'); 
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
            return $this->sendResponse('', 'Success');       
        } catch (ModelNotFoundException $e) {
            return $this->sendResponse('', 'Something Went Wrong.'); 
        }

    }

}

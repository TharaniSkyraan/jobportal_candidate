<?php

namespace App\Traits\Api;

use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\UserCv;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\UserCvFormRequest;
use App\Http\Requests\UserCvFileFormRequest;
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

    public function storeUserCv(Request $request,$cv_id=null)
    {

        $user = Auth::user();        
        if ($request->hasFile('file')) {
            
            $request->validate([
                'file' => 'required|file|mimes:pdf,docx,doc,txt,rtf|max:2048',
            ]);                 
            $path = Storage::disk('s3')->put('candidate/'.$user->token.'/file', $request->file);
            $url = Storage::disk('s3')->url($path);
            if($cv_id){
                $UserCv = UserCv::find($cv_id);
                $previous_file_path = $UserCv->path;
                $message = "Added successfully.";
            }else{
                $UserCv = new UserCv();
                $message = "Updated successfully.";
            }
            $UserCv->path = $path??"";
            $UserCv->cv_file = $url??"";
            $UserCv->user_id = $user->id;
            $UserCv->save();
            
            if($cv_id){
                Storage::disk('s3')->delete($previous_file_path); 
            }
        }
                
        return $this->sendResponse('', $message??''); 
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

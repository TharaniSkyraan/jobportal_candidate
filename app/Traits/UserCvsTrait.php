<?php

namespace App\Traits;

use File;
use ImgUploader;
use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Model\User;
use App\Model\UserCv;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\UserCvFormRequest;
use App\Http\Requests\UserCvFileFormRequest;
use Illuminate\Support\Facades\Storage;

trait UserCvsTrait
{

    public function showUserCvs()
    {
        $user = Auth::user();  
        $resume1 = $user->UserCvs[0]??null;
        $resume2 = $user->UserCvs[1]??null;
        return view('user.resume.resume', compact('resume1','resume2'));
    }

    public function storeUserCv(Request $request)
    {

        $user = Auth::user();        
        if ($request->hasFile('file')) {
            
            $request->validate([
                'file' => 'required|file|mimes:pdf,docx,doc,txt,rtf|max:2048',
            ]);                 
            // $path = Storage::disk('s3')->put('candidate/'.$user->token.'/file', $request->file);
            // $url = Storage::disk('s3')->url($path);
            $UserCv = new UserCv();
            $UserCv->path = $path??"";
            $UserCv->cv_file = $url??"";
            $UserCv->user_id = $user->id;
            $UserCv->save();
        }
        
        return response()->json(array('success' => true));
    }


    public function updateUserCv(Request $request)
    {
        
        $user = Auth::user();
        $cv_id = $request->resume_id;
        
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file|mimes:pdf,docx,doc,txt,rtf|max:2048',
            ]); 
            // $path = Storage::disk('s3')->put('candidate/'.$user->token.'/file', $request->file);
            // $url = Storage::disk('s3')->url($path);
            $UserCv = UserCv::find($cv_id);
            $previous_file_path = $UserCv->path;
            // $UserCv->path = $path;
            // $UserCv->cv_file = $url;
            $UserCv->user_id = $user->id;
            $UserCv->save();
            Storage::disk('s3')->delete($previous_file_path); 
        }
        
        return response()->json(array('success' => true));       
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

        $headers = [
            'Content-Type'        => 'application/'.$extension,
            'Content-Disposition' => 'attachment; filename="'.$usercv->user->first_name.$usercv->user->last_name.'-resume.'.$extension.'"',
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

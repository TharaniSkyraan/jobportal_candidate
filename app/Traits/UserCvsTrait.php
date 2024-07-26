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
use App\Helpers\DataArrayHelper;


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
            $path = Storage::disk('s3')->put('candidate/'.$user->token.'/file', $request->file);
            $url = Storage::disk('s3')->url($path);
            $UserCv = new UserCv();
            $UserCv->path = $path??"";
            $UserCv->cv_file = $url??"";
            $UserCv->user_id = $user->id;
            $fileExt = pathinfo($url, PATHINFO_EXTENSION);
            if($fileExt=='pdf'){
                $UserCv->pdf_path = $path??'';
                $UserCv->pdf_file = $url??'';
            }else
            {
                $localFilePath = DataArrayHelper::convertionext($url);
                $pdf_path = "candidate/".$user->token."/file/".time().'.pdf';
                Storage::disk('s3')->put($pdf_path, file_get_contents($localFilePath['real_path']));
                $pdf_url = Storage::disk('s3')->url($pdf_path);  
                $UserCv->pdf_path = $pdf_path??'';
                $UserCv->pdf_file = $pdf_url??'';
                unlink(public_path($localFilePath['path']));
            }
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
            $path = Storage::disk('s3')->put('candidate/'.$user->token.'/file', $request->file);
            $url = Storage::disk('s3')->url($path);
            $UserCv = UserCv::find($cv_id);
            $previous_file_path = $UserCv->path;
            $previous_file_pdf_path = $UserCv->pdf_path;
            $UserCv->path = $path??'';
            $UserCv->cv_file = $url??'';
            $fileExt = pathinfo($url, PATHINFO_EXTENSION);
            if($fileExt=='pdf'){
                $UserCv->pdf_path = $path??'';
                $UserCv->pdf_file = $url??'';
            }else{
                $localFilePath = DataArrayHelper::convertionext($url);
                $pdf_path = "candidate/".$user->token."/file/".time().'.pdf';
                Storage::disk('s3')->put($pdf_path, file_get_contents($localFilePath['real_path']));
                $pdf_url = Storage::disk('s3')->url($pdf_path);  
                $UserCv->pdf_path = $pdf_path??'';
                $UserCv->pdf_file = $pdf_url??'';
                unlink(public_path($localFilePath['path']));    
            }
            $UserCv->save();

            Storage::disk('s3')->delete($previous_file_path); 
            if($previous_file_path != $previous_file_pdf_path){
                Storage::disk('s3')->delete($previous_file_pdf_path); 
            }
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
        UserCv::where('user_id',Auth::user()->id)
             ->where('is_default', '=', 1)
             ->where('id', '!=', $cv_id)
             ->update(['is_default' => 0]);
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
 
        return \Response::make($usercv->cv_file, 200, $headers);   
        // return \Response::make(Storage::disk('public')->get($usercv->path), 200, $headers);   
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

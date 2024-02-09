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
use App\Helpers\DataArrayHelper;

trait UserCvsTrait
{

    public function cvs()
    {
        $response['resume'] = [];
        $user = Auth::user();  
        if(count($user->UserCvs)!=0){
            $response['resume'][] = array(
                'id'         => $user->UserCvs[0]['id'],
                'cv_name'    => 'Resume 1.pdf',
                'pdf_file'   => $user->UserCvs[0]['pdf_file'],
                'pdf_path'   => $user->UserCvs[0]['pdf_path'],
                'cv_file'    => $user->UserCvs[0]['cv_file'],
                'path'       => $user->UserCvs[0]['path'],
                'is_default' => $user->UserCvs[0]['is_default'],
                'created_at' => (!empty($user->UserCvs[0]['created_at']))?Carbon::parse($user->UserCvs[0]['created_at'])->getTimestampMs():"",
                'updated_at' => (!empty($user->UserCvs[0]['updated_at']))?Carbon::parse($user->UserCvs[0]['updated_at'])->getTimestampMs():"",
           
            );
        }
        if(count($user->UserCvs)>=2){
            $response['resume'][] = array(
                'id'         => $user->UserCvs[1]['id'],
                'cv_name'    => 'Resume 2.pdf',
                'pdf_file'    => $user->UserCvs[1]['pdf_file'],
                'pdf_path'    => $user->UserCvs[1]['pdf_path'],
                'cv_file'    => $user->UserCvs[1]['cv_file'],
                'path'       => $user->UserCvs[1]['path'],
                'is_default' => $user->UserCvs[1]['is_default'],
                'created_at' => (!empty($user->UserCvs[1]['created_at']))?Carbon::parse($user->UserCvs[1]['created_at'])->getTimestampMs():"",
                'updated_at' => (!empty($user->UserCvs[1]['updated_at']))?Carbon::parse($user->UserCvs[1]['updated_at'])->getTimestampMs():"",
           
            );
        }
        return $this->sendResponse($response);
    }

    public function cvsUpdate(UserCvRequest $request)
    {
        $id = $request->cv_id??NULL;
        $user_id = Auth::user()->id;    
        $user_token = Auth::user()->token;    
        if($id){
            $userCv = UserCv::find($id);
            $previous_file_path = $userCv->path;
            $previous_file_pdf_path = $userCv->pdf_path;
        }else{
            $userCv = new UserCv();
        }    
        $userCv->user_id = $user_id;
        $path = $request->path??'';
        $url = $request->url??'';
        $userCv->path = $path??"";
        $userCv->cv_file = $url??"";
        $fileExt = pathinfo($url, PATHINFO_EXTENSION);
        if($fileExt=='pdf'){
            $userCv->pdf_path = $path??'';
            $userCv->pdf_file = $url??'';
        }else{
            $localFilePath = DataArrayHelper::convertionext($url);
            $pdf_path = "candidate/".$user_token."/file/".time().'.pdf';
            Storage::disk('s3')->put($pdf_path, file_get_contents($localFilePath['real_path']));
            $pdf_url = Storage::disk('s3')->url($pdf_path);  
            $userCv->pdf_path = $pdf_path??'';
            $userCv->pdf_file = $pdf_url??'';
            unlink(public_path($localFilePath['path']));    
        }  
        $userCv->save();  
        
        if($id){
            Storage::disk('s3')->delete($previous_file_path); 
            if($previous_file_path != $previous_file_pdf_path){
                Storage::disk('s3')->delete($previous_file_pdf_path); 
            }
        }
        $message = "Updated successfully.";        
        User::where('id',$user_id)->update(['updated_at'=>Carbon::now()]);

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

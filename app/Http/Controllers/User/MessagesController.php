<?php

namespace App\Http\Controllers\User;

use DB;
// use Storage;
use Auth;
use App\Model\User;
use App\Model\Message;
use App\Model\MessageContact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessagesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessageContact $message_contact,Message $message)
    {
        $this->message_contact = $message_contact;
        $this->message = $message;
    }
    

    public function index($message_id='')
    {
        $message = "";
        if(!empty($message_id)){
            $message = $this->message_contact->where('message_id', $message_id)->first();
        }
        return view('user.messages.message', compact('message','message_id'));
    }
    
    public function messageContactList(Request $request)
    {
        $message_id = $request->message_id??'Msg-0001';
        $search = $request->search;
        $status = $request->mstatus;
        $orderby = $request->orderby;
        $message_id = $request->message_id;
        $user_id =  Auth::user()->id;
        $contacts = $this->message_contact->select('sub_user_id','id','message_id','job_id','created_at')
                            ->whereHas('company', function($q) use($search){   
                                if(!empty($search)){                                        
                                    $q->whereHas('company', function($q1) use($search){ 
                                            $q1->where('name', 'like', "%{$search}%");
                                    }); 
                                } 
                            })->where(function ($q) use($status){
                                if($status!='inbox'){
                                    $q->where('employer_active_status',$status);
                                }else{
                                    $q->whereNull('employer_active_status');
                                }
                            })->where('message_id','!=', $message_id)
                            ->orderBy('created_at',$orderby)
                            ->whereUserId($user_id)
                            ->get()->each(function ($items) {
                                $items->append(['company_name','company_image','company_avatar','title','unread']);
                            });  
        $contacts->makeHidden(['job_id','job','company','message']);

        if(empty($search))
        {
            $contact = $this->message_contact->select('sub_user_id','id','message_id','job_id','created_at')
                            ->where('message_id', $message_id)                        
                            ->where(function ($q) use($status){
                                if($status!='inbox'){
                                    $q->where('employer_active_status',$status);
                                }else{
                                    $q->whereNull('employer_active_status');
                                }
                            })->get()->each(function ($items) {
                                $items->append(['company_name','company_image','company_avatar','title','unread']);
                            });  
            $contact->makeHidden(['sub_user_id','job_id','job','company','message']);
            $result = array_merge($contact->toArray(), $contacts->toArray()); 
        }

        $resArr = $result??$contacts;
        if(count($resArr)){
            return response()->json(array('status' => true, 'data' => $result??$contacts));
        }else{
            return response()->json(array('status' => false, 'data' => []));
        }
    }
    
    public function messageList(Request $request)
    {
        $contact = $this->message_contact->select('sub_user_id','id','message_id','user_id','job_id','created_at','employer_active_status')
                                         ->where('message_id',$request->message_id)
                                         ->first()
                                         ->append(['company_name','company_image','company_avatar','title','company_name','job_location','contact_number']);
        $contact->makeHidden(['user_id','job_id','job','company']);
        $messages = $this->message->select('message','send_at','send_by')
                                  ->where('message_id',$request->message_id)
                                  ->get();
        $this->message->where('message_id',$request->message_id)->where('send_by','employer')->update(['is_read'=>'1']);

        $resArr = array(
            'contact' =>$contact,
            'messages' =>$messages,
        );
        return response()->json(array('success' => true, 'datas' => $resArr));
    }

    public function messageListen(Request $request)
    {
        $last_chat_at = $request->last_chat_at;
        $messages = $this->message->select('message','send_at','send_by')
                                 ->where('message_id',$request->message_id)
                                 ->where(function ($q) use($last_chat_at){
                                    if(!empty($last_chat_at)){
                                        $q->where('send_at','>',$last_chat_at);
                                    }
                                 })
                                 ->get();
        $this->message->where('message_id',$request->message_id)->where('send_by','employer')->update(['is_read'=>'1']);

        return response()->json(array('success' => true, 'datas' => $messages));
    }
    
    public function messageSend(Request $request)
    {

        $message = new Message();
        $message->send_by = 'candidate';
        $message->message_id = $request->message_id;
        $message->message = $request->message;
        $message->send_at = $request->chat_at;
        $message->is_read = '0';
        $message->save();

        return 'success';
    }

    public function ContactStatus(Request $request)
    {
        $message_contact = $this->message_contact::where('message_id',$request->message_id)
                                ->update(['employer_active_status'=>$request->status]);
                                
        return 'success';
    }
    
}
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
        $company_id = Auth::user()->id;
        if(empty($message_id)){
            $message = $this->message_contact->first();
        }else{
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
        $sub_user_id =  Auth::user()->company_id;
        $is_archive = '0';
        if($status!='all' && $status=='archive'){
           $is_archive = '1';
        }
        $contacts = $this->message_contact->select('sub_user_id','id','message_id','user_id','job_id','is_archive','created_at')
                            ->whereHas('user', function($q) use($search){  
                                if(!empty($search)){                                        
                                    $q->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%{$search}%")
                                    ->orwhere('name', 'like', "%{$search}%");
                                }                    
                            })
                            ->orderBy('created_at',$orderby)
                            ->whereSubUserId($sub_user_id)
                            ->where('message_id','!=', $message_id);
        if($status!='all')
        {
            $contacts = $contacts->where('is_archive',$is_archive);
        }
        $contacts =  $contacts->get()->each(function ($items) {
            $items->append(['user_name','user_image','user_avatar','title','unread']);
        });  
        $contacts->makeHidden(['user_id','job_id','job','user','message']);

        if(empty($search))
        {
            $contact = $this->message_contact->select('sub_user_id','id','message_id','user_id','job_id','is_archive','created_at')
                            ->where('message_id', $message_id)
                            ->get()->each(function ($items) {
                                $items->append(['user_name','user_image','user_avatar','title','unread']);
                            });  
            $contact->makeHidden(['user_id','job_id','job','user','message']);
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
        $contact = $this->message_contact->select('sub_user_id','id','message_id','user_id','job_id','is_archive','created_at')
                                         ->where('message_id',$request->message_id)
                                         ->first()
                                         ->append(['user_name','user_image','user_avatar','title','company_name','job_location','contact_number']);
        $contact->makeHidden(['user_id','job_id','job','user']);
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
        $messages = $this->message->select('message','send_at','send_by')
                                 ->where('message_id',$request->message_id)
                                 ->where('send_at','>',$request->last_chat_at)
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
}
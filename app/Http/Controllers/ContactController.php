<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Contact;


class ContactController extends Controller
{

    public function ContactInsert(Request $request){

            
            $request->validate([
                'name' => 'required|max:130',
                'email'=>'required|email',
                'subject'=>'required',
                'message'=>'required',
            ]);
        
            $contact = new Contact;            
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            return response()->json([ 'success'=> 'Message sending successfully!']);
        }
    
    }
   
 

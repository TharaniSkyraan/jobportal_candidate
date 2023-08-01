<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Model\Contact;
use App\Model\Faq;
use App\Model\FaqCategory;
use App\Mail\ContactUs;

class ContactController extends Controller
{

    public function ContactInsert(Request $request)
    {
       
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
      
      Mail::send(new ContactUs($contact));

      return response()->json([ 'success'=> 'Message sending successfully!']);

    }
    
    public function faqindex($ckey="")
    {
        $faq_categories = FaqCategory::where('user_type','candidate')->select('slug','faq_category')->active()->get();
        if(!empty($ckey)){
            $cat = FaqCategory::where('user_type','candidate')->where('slug',$ckey)->first();
        }else{
            $cat = FaqCategory::where('user_type','candidate')->first();
        }
        return view('faq.faq', compact('faq_categories','ckey','cat'));
    }
    
    public function getFaqData(Request $request)
    {
        if(empty($request->search_q))
        {
            $faqcategory = FaqCategory::where('user_type','candidate')->where('slug',$request->ckey)->active()->first();
            $faqs = Faq::where('user_type','candidate')
                        ->whereFaqCategoryId($faqcategory->id)
                        ->select('question','answer')->get();          
        }else
        {
            $search_q = $request->search_q;
            $faqs = Faq::where('user_type','candidate')
                        ->whereHas('faq_category',function($q) use($search_q){
                            $q->where('faq_category', 'like', "%{$search_q}%");
                        })->orwhere('question', 'like', "%{$search_q}%")->get();
        }
         return response()->json(array('status' => true, 'data' => $faqs));
    }

}



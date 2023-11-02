<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Model\Contact;
use App\Model\Faq;
use DB;
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
        $faq_categories = FaqCategory::where('user_type','candidate')
        ->withCount('faqs')
        ->havingRaw("faqs_count != 0")
        ->active()->get();
        if(!empty($ckey)){
            $cat = FaqCategory::where('user_type','candidate')->where('slug',$ckey)->first();
            $cat = Faq::where('faq_category_id', $cat->id)
                    ->select('faq_category_id', DB::raw('count(*) as category_count'))
                    ->groupBy('faq_category_id')
                    ->orderBy('category_count', 'desc')
                    ->first();
            if($cat == null){
                abort(500);
            }
        }else{
            $cat = Faq::where('user_type', 'candidate')
                        ->select('faq_category_id', DB::raw('count(*) as category_count'))
                        ->groupBy('faq_category_id')
                        ->orderBy('category_count', 'desc')
                        ->first();
        }
        $cat = FaqCategory::where('id', $cat->faq_category_id)->first();
        return view('faq.faq', compact('faq_categories','ckey','cat'));

    }
    
    public function getFaqData(Request $request)
    {      
        if(empty($request->search_q))
        {
            $faqs = Faq::where('user_type','candidate')
                        ->whereFaqCategoryId($request->ids)
                        ->select('question','answer')->get();          
        }else
        {
            $search_q = $request->search_q;
            $faqs = Faq::where('user_type','candidate')
                        ->whereFaqCategoryId($request->ids)
                        ->where('question', 'like', "%{$search_q}%")
                        ->get();
        }
         return response()->json(array('status' => true, 'data' => $faqs));
    }

}



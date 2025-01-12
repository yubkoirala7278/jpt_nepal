<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){
        try{
            $faqs=Faq::latest()->get();
            return view('public.faq.index',compact('faqs'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

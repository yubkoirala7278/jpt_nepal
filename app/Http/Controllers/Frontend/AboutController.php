<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        try{
            $abouts = About::latest()->take(2)->get();
            return view('public.about.index',compact('abouts'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

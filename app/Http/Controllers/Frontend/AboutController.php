<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        try{
            return view('public.about.index');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

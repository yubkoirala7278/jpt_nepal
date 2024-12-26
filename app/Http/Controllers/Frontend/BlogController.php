<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        try{
            return view('public.blog.index');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    public function blogDetails(){
        try{
            return view('public.blog.blog_detail');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

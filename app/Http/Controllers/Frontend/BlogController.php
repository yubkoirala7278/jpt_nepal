<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        try{
            $blogs=Blog::where('status','active')->latest()->paginate(10);
            return view('public.blog.index',compact('blogs'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    public function blogDetails($slug){
        try{
            $blog=Blog::where('slug',$slug)->where('status','active')->first();
            $latestBlogs = Blog::where('status', 'active')->latest()->take(3)->get();
            return view('public.blog.blog_detail',compact('blog','latestBlogs'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

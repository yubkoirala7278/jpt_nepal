<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(){
        try{
            return view('public.notice.index');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    public function getNoticeDetail($slug){
        try{
            $notice=Notice::where('slug',$slug)->first();
            if(!$notice){
                return back()->with('error','Notice not found!');
            }
            return view('public.notice.notice_detail',compact('notice'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

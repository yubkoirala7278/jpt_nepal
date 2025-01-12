<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(){
        try{
            $notices=Notice::latest()->paginate(10);
            return view('public.notice.index',compact('notices'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    public function getNoticeDetail($slug){
        try{
            $notice=Notice::where('slug',$slug)->first();
            $latestNotices = Notice::latest()->take(3)->get();
            if(!$notice){
                return back()->with('error','Notice not found!');
            }
            return view('public.notice.notice_detail',compact('notice','latestNotices'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

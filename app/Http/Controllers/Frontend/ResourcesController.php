<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function index(){
        try{
            return view('public.resource.index');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        try{
            return view('admin.home.index');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

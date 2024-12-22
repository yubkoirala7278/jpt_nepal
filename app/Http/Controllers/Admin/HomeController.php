<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultancy;
use App\Models\TestCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        try{
            $totalTestCenter=null;
            $totalEducationConsultancy=null;
            if(Auth::user()->hasRole('admin')){
                $totalTestCenter=TestCenter::count();
                $totalEducationConsultancy=Consultancy::count();
            }
            return view('admin.home.index',compact('totalTestCenter','totalEducationConsultancy'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

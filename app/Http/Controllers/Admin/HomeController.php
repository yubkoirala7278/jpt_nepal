<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultancy;
use App\Models\TestCenter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        try{
            $totalTestCenter=TestCenter::count();
            $totalEducationConsultancy=Consultancy::count();
            return view('admin.home.index',compact('totalTestCenter','totalEducationConsultancy'));
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

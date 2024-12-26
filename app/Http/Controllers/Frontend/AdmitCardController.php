<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdmitCardController extends Controller
{
    public function index(){
        try{
            return view('public.admit_card.index');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    public function getApplicantResult(){
        try{
            return view('public.admit_card.result');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

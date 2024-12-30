<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestDetailController extends Controller
{
    public function index()
    {
        try {
            return view('public.test_detail.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    public function registration(){
        try {
            return view('public.test_detail.registration');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}

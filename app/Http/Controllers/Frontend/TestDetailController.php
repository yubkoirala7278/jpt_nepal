<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TestDetailController extends Controller
{
    public function index()
    {
        try {
            $testCenters = User::role('test_center_manager')->orderBy('name', 'asc')->get();
            return view('public.test_detail.index',compact('testCenters'));
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

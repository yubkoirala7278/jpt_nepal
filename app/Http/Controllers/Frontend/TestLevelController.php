<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestLevelController extends Controller
{
    public function index()
    {
        try {
            return view('public.test_levels.index');
        } catch (\Throwable $th) {
        }
    }
}

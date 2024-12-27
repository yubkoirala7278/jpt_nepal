<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ResultImport;
use App\Models\Students;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function  index()
    {
        try {
            $students=Students::has('results')->with('results')->latest()->get();
            return view('admin.result.index',compact('students'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv', // Validate that the file is an
        ]);
        try {
            Excel::import(new ResultImport, $request->file('file'));
            return back()->with('success','Results import successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}

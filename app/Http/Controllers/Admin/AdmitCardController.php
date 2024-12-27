<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AdmitCardController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (Auth::user()->hasRole('admin')) {
                $students = Students::has('admit_cards')->with('admit_cards')->latest()->get();
            } else if (Auth::user()->hasRole('consultancy_manager')) {
                $students = Students::with('admit_cards') 
                ->where('user_id', Auth::user()->id) 
                ->has('admit_cards')
                ->get();
            } else {
                return; // If the user does not have a valid role, return nothing
            }

            if ($request->ajax()) {
                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('admit_card', function ($student) {
                        // Add download button for the admit card
                        return '<a href="' . asset($student->admit_cards->admit_card) . '" class="btn btn-success btn-sm" download><i class="fa-solid fa-download me-1"></i>Download</a>';
                    })
                    ->rawColumns(['admit_card'])
                    ->make(true);
            }
            return view('admin.admit_card.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}

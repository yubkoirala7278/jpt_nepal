<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultancy;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AdmitCardController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Students::with('user.consultancy', 'user.test_center', 'exam_date', 'admit_cards')
                ->whereNotNull('exam_number') 
                ->latest();

                if (Auth::user()->hasRole('consultancy_manager')) {
                    $query->where('user_id', Auth::user()->id);
                } else if (Auth::user()->hasRole('test_center_manager')) {
                    $consultanciesUserIds = Consultancy::where('test_center_id', Auth::user()->id)
                        ->pluck('user_id')
                        ->toArray();
                    // Append the authenticated user's ID to the array
                    $consultanciesUserIds[] = Auth::user()->id;
                    $query->whereIn('user_id', $consultanciesUserIds);
                }

                // Fetch students
                $students = $query->get();

                // Loop through the students and check if consultancy address is null
                $students->map(function ($student) {
                    // Check if consultancy address is null and use test center address as fallback
                    $student->consultancy_address = $student->user->consultancy && $student->user->consultancy->address
                        ? $student->user->consultancy->address
                        : $student->user->test_center->address;
                    return $student;
                });

                return DataTables::of($students)
                    ->addIndexColumn()
                    ->editColumn('exam_duration', function ($row) {
                        return $row->exam_date
                            ? $row->exam_date->exam_start_time->format('h:i A') . ' - ' . $row->exam_date->exam_end_time->format('h:i A')
                            : 'N/A';
                    })
                    ->editColumn('admit_card', function ($row) {
                        if (!$row->status) {
                            return '<span class="badge text-bg-danger text-white">Pending</span>';
                        }

                        if ($row->status && !$row->exam_number) {
                            return '<span class="badge text-bg-warning text-white">Admit Card Under Process</span>';
                        }

                        if ($row->status && $row->exam_number) {
                            return '
                            <button 
                                type="button" 
                                class="btn btn-success btn-sm text-white" 
                                id="download-button-' . $row->id . '"
                                onclick="downloadAdmitCard(\'' . $row->dob . '\', \'' . $row->slug . '\', ' . $row->id . ')">
                                <i class="fa-solid fa-download"></i> Download
                            </button>
                        ';
                        }
                    })
                    ->rawColumns(['status', 'admit_card'])
                    ->make(true);
            }
            return view('admin.admit_card.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}

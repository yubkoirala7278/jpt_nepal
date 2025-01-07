<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $students = Students::with('exam_date', 'user')
            ->whereNotNull('amount');
            if (request()->ajax()) {
                return DataTables::of($students)
                    ->addIndexColumn() // Automatically adds a serial number
                    ->addColumn('exam_date', function($student) {
                        return $student->exam_date->exam_date;
                    })
                    ->addColumn('consultancy_name', function($student) {
                        return $student->user->name;
                    })
                    ->addColumn('consultancy_address', function($student) {
                        if($student->user->consultancy){
                            return $student->user->consultancy->address;
                        }else{
                            return $student->user->test_center->address;
                        }
                    })
                    ->addColumn('action', function($student) {
                        return '';
                    })
                    ->filterColumn('exam_date', function($query, $keyword) {
                        // Add filtering for exam_date if needed
                        $query->whereHas('exam_date', function($query) use ($keyword) {
                            $query->where('exam_date', 'like', "%$keyword%");
                        });
                    })
                    ->make(true);
            }
    
            $totalAmount = $students->sum('amount');
            $totalStudents = $students->count();
    
            return view('admin.transactions.index', compact('totalAmount', 'totalStudents'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    
}

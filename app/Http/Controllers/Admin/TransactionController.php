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
            $students = Students::with('exam_date')->latest();
    
            if (request()->ajax()) {
                return DataTables::of($students)
                    ->addIndexColumn() // Automatically adds a serial number
                    ->addColumn('exam_date', function($student) {
                        return $student->exam_date->exam_date;
                    })
                    ->addColumn('action', function($student) {
                        // You can add action buttons here if needed (Edit, Delete, etc.)
                        return '';
                    })
                    ->make(true);
            }
    
            // For the first load, return the view with the total values
            $totalAmount = $students->sum('amount');
            $totalStudents = $students->count();
    
            return view('admin.transactions.index', compact('totalAmount', 'totalStudents'));
    
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
}

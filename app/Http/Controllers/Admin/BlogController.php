<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Start building the query
            $query = Students::with('user.consultancy', 'exam_date', 'admit_cards');
    
            // Check for ordering input from DataTables
            if ($request->has('order') && isset($request->order[0]['column'])) {
                $columnIndex = $request->order[0]['column']; // Column index from DataTables
                $direction = $request->order[0]['dir']; // asc or desc
    
                // Map DataTables column index to database column names
                $columns = [
                    'id',        
                    'name',     
                    'email',     
                    'dob',      
                    'amount',   
                    'status',    
                    'exam_date',
                ];
    
                // Ensure the requested column exists in the mapping
                if (isset($columns[$columnIndex])) {
                    $query->orderBy($columns[$columnIndex], $direction);
                }
            } else {
                // Default ordering
                $query->latest();
            }
    
            $students = $query->get();
    
            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('receipt', function ($row) {
                    return '<img src="' . asset($row->receipt_image) . '" alt="Receipt Image" height="30" loading="lazy">';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('student.show', $row->slug) . '" class="btn btn-info text-white btn-sm" title="view">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                        <a href="' . route('student.edit', $row->slug) . '" class="btn btn-warning text-white btn-sm" title="edit">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form action="' . route('student.destroy', $row->slug) . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm text-white" title="Delete" 
                                    onclick="return confirm(\'Are you sure you want to delete this student?\');">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>';
                })
                ->editColumn('status', function ($row) {
                    return $row->status 
                        ? '<span class="badge text-bg-success">Approved</span>' 
                        : '<span class="badge text-bg-danger">Pending</span>';
                })
                ->editColumn('exam_duration', function ($row) {
                    return $row->exam_date
                        ? $row->exam_date->exam_start_time->format('h:i A') . ' - ' . $row->exam_date->exam_end_time->format('h:i A')
                        : 'N/A';
                })
                ->editColumn('admit_card', function ($row) {
                    return $row->admit_cards
                        ? '<a href="' . asset($row->admit_cards->admit_card) . '" download class="btn btn-success btn-sm"><i class="fa-solid fa-download"></i> Download</a>'
                        : '<a href="javascript:void(0);" class="btn btn-danger btn-sm"><i class="fa-solid fa-hourglass-half"></i> Pending</a>';
                })
                ->rawColumns(['receipt', 'action', 'status', 'admit_card'])
                ->make(true);
        }
    
        return view('admin.blog.index');
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamDateRequest;
use App\Models\ExamDate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExamDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = ExamDate::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('exam_duration', function ($row) {
                        // Assuming exam_start_time and exam_end_time are stored in 'H:i:s' format
                        $start_time = \Carbon\Carbon::parse($row->exam_start_time)->format('h:i A');
                        $end_time = \Carbon\Carbon::parse($row->exam_end_time)->format('h:i A');

                        // Concatenate start time and end time as the duration
                        return $start_time . ' - ' . $end_time;
                    })
                    ->addColumn('action', function ($row) {
                        return '
                            <div class="d-flex align-items-center" style="column-gap:10px">
                                <button type="button" class="btn btn-warning btn-sm edit-btn" data-slug="' . $row->slug . '">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-url="' . route('exam_date.destroy', $row->slug) . '">Delete</button>
                            </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.exam_date.index');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
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
    public function store(ExamDateRequest $request)
    {
        try {
            ExamDate::create([
                'exam_date' => $request['exam_date'],
                'exam_start_time' => $request['exam_start_time'],
                'exam_end_time' => $request['exam_end_time'],
            ]);
            return response()->json(['success' => 'Exam date has been created successfully!', 'message' => 'Exam Date created successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($slug)
    {
        try{
            $examDate = ExamDate::where('slug', $slug)->firstOrFail();

            // Format the start and end times to only show hour and minute
            $examStartTime = $examDate->exam_start_time->format('H:i');
            $examEndTime = $examDate->exam_end_time->format('H:i');
    
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $examDate->id,
                    'exam_date' => $examDate->exam_date,
                    'exam_start_time' => $examStartTime,
                    'exam_end_time' => $examEndTime,
                ]
            ]);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    // Update the specified resource in storage.
    public function update(ExamDateRequest $request, $id)
    {
        try{
            $examDate = ExamDate::find($id);
            // Update the exam date
            $examDate->exam_date = $request['exam_date'];
            $examDate->exam_start_time = $request['exam_start_time'];
            $examDate->exam_end_time = $request['exam_end_time'];
            $examDate->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Exam Date updated successfully',
            ]);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamDate $examDate)
    {
        try {
            $examDate->delete();
            return response()->json(['success' => 'Exam date deleted successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

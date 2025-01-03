<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ResultImport;
use App\Models\ExamDate;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (Auth::user()->hasRole('admin')) {
                $students = Students::has('results')
                    ->with('results', 'exam_date');
            } elseif (Auth::user()->hasRole('consultancy_manager')) {
                $students = Students::has('results')
                    ->where('user_id', Auth::user()->id)
                    ->with('results', 'exam_date');
            }

            $examDates = ExamDate::orderBy('exam_date', 'asc')->get();

            if ($request->ajax()) {
                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('marks', function ($student) {
                        return $student->results->marks ?? '-';
                    })
                    ->addColumn('result_status', function ($student) {
                        return $student->results->result ?? '-';
                    })
                    ->addColumn('exam_date', function ($student) {
                        return $student->exam_date->exam_date ?? '-';
                    })
                    ->addColumn('result', function ($student) {
                        $result = $student->results->result ?? null;
                        return $result == 'pass'
                            ? '<span class="badge text-bg-success">pass</span>'
                            : '<span class="badge text-bg-danger">fail</span>';
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->get('search')['value']) {
                            $search = $request->get('search')['value'];
                            $query->where(function ($q) use ($search) {
                                $q->whereHas('exam_date', function ($q) use ($search) {
                                    $q->where('exam_date', 'like', '%' . $search . '%');
                                })
                                    ->orWhere('name', 'like', '%' . $search . '%')
                                    ->orWhere('address', 'like', '%' . $search . '%')
                                    ->orWhere('phone', 'like', '%' . $search . '%')
                                    ->orWhere('dob', 'like', '%' . $search . '%')
                                    ->orWhere('email', 'like', '%' . $search . '%')
                                    ->orWhere('slug', 'like', '%' . $search . '%');
                            });
                        }
                    })
                    ->rawColumns(['result'])
                    ->make(true);
            }

            return view('admin.result.index', compact('examDates'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new ResultImport, $request->file('file'));
            return back()->with('success', 'Results imported successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handling duplicate entry error from the database (unique constraint violation)
            if ($e->getCode() == '23000') {
                return back()->with('error', 'Something went wrong.Please try again!');
            }
            // General error message for other database exceptions
            return back()->with('error', 'An error occurred while importing the results. Please try again later.');
        } catch (\Exception $e) {
            // Catch custom exceptions like non-existing student_id
            return back()->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            // Catch all other exceptions
            return back()->with('error', 'An unexpected error occurred: ' . $th->getMessage());
        }
    }


    public function export(Request $request)
    {
        // Validate the request
        $request->validate([
            'date' => 'required|exists:exam_dates,id', // Ensure the date exists
            'result' => 'required'
        ], [
            'date.required' => 'Exam date is required.',
            'date.exists' => 'Invalid exam date selected.',
        ]);
        try {
            // Fetch students filtered by the selected exam date
            $studentsQuery = Students::with('exam_date', 'results')
                ->where('exam_date_id', $request['date'])
                ->when($request['result'] == 'pass' || $request['result'] == 'fail', function ($query) use ($request) {
                    $query->whereHas('results', function ($q) use ($request) {
                        $q->where('result', $request['result']);
                    });
                })
                ->has('results'); // Ensure that only students with results are retrieved

            // Role-based conditions
            if (Auth::user()->hasRole('admin')) {
                // Admins can see all students
                $students = $studentsQuery->get();
            } else if (Auth::user()->hasRole('consultancy_manager')) {
                // Consultancy managers can only see their own students
                $students = $studentsQuery->where('user_id', Auth::user()->id)->get();
            }

            if (count($students) <= 0) {
                return back()->with('error', 'No applicants to download!');
            }

            // load the view and pass the data to it
            $pdf = PDF::loadView('admin.exports.results', compact('students'));
            // return the generated pdf to download
            return $pdf->download('results.pdf');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}

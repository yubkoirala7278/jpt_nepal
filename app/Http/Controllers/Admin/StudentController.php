<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\AdmitCard;
use App\Models\ExamDate;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.student.access')->only(['edit', 'update', 'destroy', 'create', 'store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('admin')) {
                $students = Students::with('consultancy', 'exam_date');
            } else if (Auth::user()->hasRole('consultancy_manager')) {
                $students = Students::with('consultancy', 'exam_date')
                    ->where('consultancy_id', Auth::user()->id);
            } else {
                return; // If the user does not have a valid role, return nothing
            }

            return datatables()
                ->of($students)
                ->addIndexColumn()
                ->addColumn(
                    'receipt_image',
                    fn($row) =>
                    '<img src="' . asset($row->receipt_image) . '" alt="Logo" height="30" class="receipt-image" data-url="' . asset($row->receipt_image) . '" style="cursor:pointer;" loading="lazy" />'
                )
                ->addColumn('action', function ($row) {
                    $viewUrl = route('student.show', $row->slug);

                    if (Auth::user()->hasRole('admin')) {
                        return '
                            <a href="' . $viewUrl . '" class="btn btn-info btn-sm">View</a>
                            <button class="btn btn-primary btn-sm upload-admit-card-btn" data-slug="' . $row->slug . '">Upload Admit Card</button>
                        ';
                    } else {
                        $editUrl = route('student.edit', $row->slug);
                        $deleteUrl = route('student.destroy', $row->id);

                        return '
                            <a href="' . $viewUrl . '" class="btn btn-info btn-sm">View</a>
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm delete-btn" data-url="' . $deleteUrl . '" data-id="' . $row->id . '">Delete</button>
                        ';
                    }
                })


                ->editColumn('is_appeared_previously', function ($row) {
                    return $row->is_appeared_previously ? 'Yes' : 'No';
                })
                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge text-bg-success">Approved</span>'
                        : '<span class="badge text-bg-danger">Pending</span>';
                })
                ->addColumn('exam_date', function ($row) {
                    return $row->exam_date->exam_date;
                })
                ->addColumn('exam_duration', function ($row) {
                    $startTime = Carbon::parse($row->exam_date->exam_start_time);
                    $endTime = Carbon::parse($row->exam_date->exam_end_time);

                    return $startTime->format('h:i A') . ' - ' . $endTime->format('h:i A');
                })
                ->rawColumns(['receipt_image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.students.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $examDates = ExamDate::where('exam_date', '>', now())->latest()->get();
            return view('admin.students.create', compact('examDates'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        try {
            // Handle file upload for the profile
            if ($request->hasFile('profile')) {
                $profilePath = $request->file('profile')->storeAs(
                    'public/profile',
                    uniqid() . '.' . $request->file('profile')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $profilePath = str_replace('public/', 'Storage/', $profilePath);
            }
            // Handle file upload for the receipt
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->storeAs(
                    'public/receipt_image',
                    uniqid() . '.' . $request->file('receipt_image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $receiptPath = str_replace('public/', 'Storage/', $receiptPath);
            }
            Students::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'profile' => $profilePath,
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'is_appeared_previously' => $request['is_appeared_previously'] ? true : false,
                'receipt_image' => $receiptPath,
                'consultancy_id' => Auth::user()->id,
                'exam_date_id' => $request['exam_date']
            ]);
            return redirect()->route('student.index')->with('success', "Applicant added successfully!");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Students $student)
    {
        try {
            return view('admin.students.show', compact('student'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Students $student)
    {
        try {
            $examDates = ExamDate::where('exam_date', '>', now())->latest()->get();
            return view('admin.students.edit', compact('student', 'examDates'));
        } catch (\Throwable $th) {
            return back()->with('erorr', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Students $student)
    {
        try {
            // Handle file upload for the profile
            if ($request->hasFile('profile')) {
                // Delete the old profile image if it exists
                if ($student->profile && Storage::exists(str_replace('Storage/', 'public/', $student->profile))) {
                    Storage::delete(str_replace('Storage/', 'public/', $student->profile));
                }

                $profilePath = $request->file('profile')->storeAs(
                    'public/profile',
                    uniqid() . '.' . $request->file('profile')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $profilePath = str_replace('public/', 'Storage/', $profilePath);
            } else {
                // Keep the old profile image if no new one is uploaded
                $profilePath = $student->profile;
            }

            // Handle file upload for the receipt image
            if ($request->hasFile('receipt_image')) {
                // Delete the old receipt image if it exists
                if ($student->receipt_image && Storage::exists(str_replace('Storage/', 'public/', $student->receipt_image))) {
                    Storage::delete(str_replace('Storage/', 'public/', $student->receipt_image));
                }

                $receiptPath = $request->file('receipt_image')->storeAs(
                    'public/receipt_image',
                    uniqid() . '.' . $request->file('receipt_image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $receiptPath = str_replace('public/', 'Storage/', $receiptPath);
            } else {
                // Keep the old receipt image if no new one is uploaded
                $receiptPath = $student->receipt_image;
            }

            // Update the student record
            $student->update([
                'name' => $request['name'],
                'address' => $request['address'],
                'profile' => $profilePath,
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'is_appeared_previously' => $request['is_appeared_previously'] ? true : false,
                'receipt_image' => $receiptPath,
                'consultancy_id' => Auth::user()->id,
                'exam_date_id' => $request['exam_date'],
            ]);

            return redirect()->route('student.index')->with('success', "Applicant updated successfully!");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $student = Students::findOrFail($id);
            // Ensure the path is relative to the 'public' disk
            $relativeReceiptPath = str_replace('Storage/', 'public/', $student->receipt_image);
            $relativeProfilePath = str_replace('Storage/', 'public/', $student->profile);

            // Delete the receipt if it exists
            if ($student->receipt_image && Storage::exists($relativeReceiptPath)) {
                Storage::delete($relativeReceiptPath);
            }
            // Delete the profile if it exists
            if ($student->profile && Storage::exists($relativeProfilePath)) {
                Storage::delete($relativeProfilePath);
            }
            $student->delete();

            return response()->json(['message' => 'Student deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete student.'], 500);
        }
    }

    /**
     * Update status
     */
    public function updateStatus(Request $request, $slug)
    {
        try {
            $student = Students::where('slug', $slug)->first();
            if (!$student) {
                return back()->with('error', 'Student not found!');
            }
            $student->update([
                'status' => $request['status']
            ]);
            return back()->with('success', 'Status changed successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

     /**
     * Upload admit card
     */
    public function uploadAdmitCard(Request $request, $slug)
    {
        $request->validate([
            'admit_card' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:2048',
        ]);
    
        try {
            // Fetch the student by slug
            $student = Students::where('slug', $slug)->firstOrFail();
    
            // Check if an admit card already exists for the student
            $existingAdmitCard = AdmitCard::where('student_id', $student->id)->first();
    
            // Handle file upload
            $admitCardPath = $request->file('admit_card')->storeAs(
                'public/admit_card',
                uniqid() . '.' . $request->file('admit_card')->getClientOriginalExtension()
            );
    
            // Store the relative path in the database
            $admitCardPath = 'Storage/' . str_replace('public/', '', $admitCardPath); // Adjusting path for storage
    
            // If an old admit card exists, delete the old image
            if ($existingAdmitCard && $existingAdmitCard->admit_card) {
                // Generate the correct relative path for the old file in 'public/admit_card'
                $relativeAdmitCardPath = str_replace('Storage/', 'public/', $existingAdmitCard->admit_card);
                
                // Check if the file exists in the storage and delete it
                if (Storage::exists($relativeAdmitCardPath)) {
                    Storage::delete($relativeAdmitCardPath);
                }
            }
    
            // Create or update the admit card record in the database
            AdmitCard::updateOrCreate(
                ['student_id' => $student->id], // Search criteria
                ['admit_card' => $admitCardPath] // Fields to update or insert
            );
    
            return response()->json(['message' => 'Admit Card uploaded successfully.'], 200);
        } catch (\Exception $e) {
            // Log error and return failure response
            return response()->json(['message' => 'Failed to upload admit card.'], 500);
        }
    }
    
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Mail\StudentCreatedMail;
use App\Models\AdmitCard;
use App\Models\ExamDate;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.student.access')->only(['edit', 'update', 'create', 'store', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Return the data for approved students
            return $this->getPendingOrApprovedStudents(null);
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
            $student = Students::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'profile' => $profilePath,
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'is_appeared_previously' => $request['is_appeared_previously'] ? true : false,
                'receipt_image' => $receiptPath,
                'user_id' => Auth::user()->id,
                'exam_date_id' => $request['exam_date']
            ]);
            // send email to applicant
            $examStartTime = \Carbon\Carbon::parse($student->exam_date->exam_start_time)->format('h:i A');
            $examEndTime = \Carbon\Carbon::parse($student->exam_date->exam_end_time)->format('h:i A');
            $data = [
                'name' => $request['name'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'exam_date' => \Carbon\Carbon::parse($student->exam_date->exam_date)->format('F j, Y'), // Formats as "Month Day, Year"
                'exam_duration' => "$examStartTime to $examEndTime",
                'consultancy_name' => $student->user->name,
                'consultancy_address' => $student->user->consultancy->address,
                'registration_number' => $student->slug
            ];
            Mail::to($request['email'])->send(new StudentCreatedMail($data));
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
            if ($student->status) {
                return back()->with('error', 'You cannot update the approved applicants');
            }
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
                'user_id' => Auth::user()->id,
                'exam_date_id' => $request['exam_date'],
            ]);
            // sending updated mail to applicant
            $examStartTime = \Carbon\Carbon::parse($student->exam_date->exam_start_time)->format('h:i A');
            $examEndTime = \Carbon\Carbon::parse($student->exam_date->exam_end_time)->format('h:i A');
            $data = [
                'name' => $request['name'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'exam_date' => \Carbon\Carbon::parse($student->exam_date->exam_date)->format('F j, Y'), // Formats as "Month Day, Year"
                'exam_duration' => "$examStartTime to $examEndTime",
                'consultancy_name' => $student->user->name,
                'consultancy_address' => $student->user->consultancy->address,
                'registration_number' => $student->slug
            ];
            Mail::to($request['email'])->send(new StudentCreatedMail($data));

            return redirect()->route('student.index')->with('success', "Applicant updated successfully!");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        try {
            $student = Students::with('admit_cards')->where('slug', $slug)->first();
            if ($student->status) {
                return response()->json(['message' => 'You cannot delete the approved applicants.'], 500);
            }
            // Ensure the path is relative to the 'public' disk
            $relativeReceiptPath = str_replace('Storage/', 'public/', $student->receipt_image);
            $relativeProfilePath = str_replace('Storage/', 'public/', $student->profile);
            // delete admit card if present
            if ($student->admit_cards) {
                $relativeAdmitCardPath = str_replace('Storage/', 'public/', $student->admit_cards->admit_card);
                if ($student->admit_cards->admit_card && Storage::exists($relativeAdmitCardPath)) {
                    Storage::delete($relativeAdmitCardPath);
                }
            }
            // Delete the receipt if it exists
            if ($student->receipt_image && Storage::exists($relativeReceiptPath)) {
                Storage::delete($relativeReceiptPath);
            }
            // Delete the profile if it exists
            if ($student->profile && Storage::exists($relativeProfilePath)) {
                Storage::delete($relativeProfilePath);
            }
            $student->delete();

            return response()->json(['message' => 'Applicant deleted successfully.'], 200);
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
            return redirect()->route('student.index')->with('success', 'Status changed successfully!');
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

    /**
     * Get pending or approved students
     */
    public function getPendingOrApprovedStudents($status)
    {
        if (Auth::user()->hasRole('admin')) {
            $students = Students::with('user', 'exam_date', 'admit_cards')
                ->when($status !== null, function ($query) use ($status) {
                    return $query->where('status', $status);
                });
        } else if (Auth::user()->hasRole('consultancy_manager')) {
            $students = Students::with('user', 'exam_date', 'admit_cards')
                ->where('user_id', Auth::user()->id)
                ->when($status !== null, function ($query) use ($status) {
                    return $query->where('status', $status);
                });
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
            ->addColumn('admit_card', function ($row) {
                if ($row->admit_cards) {
                    $admitCardUrl = asset($row->admit_cards->admit_card);
                    return '<a href="' . $admitCardUrl . '" download class="btn btn-success btn-sm" style="color: #fff; background-color: #28a745; border: 1px solid #28a745;" title="Download Admit Card">
                    <i class="fa-solid fa-download"></i> Download
                </a>';
                } else {
                    return '<a href="javascript:void(0)" class="btn btn-light btn-sm" style="color: white; background-color: #ff9800; border: 1px solid #ff9800;" title="Pending">
    <i class="fa-solid fa-hourglass-half"></i> Pending
</a>';
                }
            })
            ->addColumn('action', function ($row) {
                $viewUrl = route('student.show', $row->slug);

                // Admin Role Logic
                if (Auth::user()->hasRole('admin')) {
                    // If the status is true, show only the View and Upload Admit Card buttons
                    if ($row->status) {
                        return '
                            <a href="' . $viewUrl . '" class="btn btn-primary text-white btn-sm" title="view applicant details"><i class="fa-regular fa-eye"></i></a>
                            <button class="btn btn-success btn-sm upload-admit-card-btn" data-slug="' . $row->slug . '" title="upload admit card"><i class="fa-solid fa-upload"></i></button>
                        ';
                    }

                    // If the status is not true, show only the View button
                    return '<a href="' . $viewUrl . '" class="btn btn-primary text-white btn-sm" title="view applicant details"><i class="fa-regular fa-eye"></i></a>';
                }

                // Consultancy Manager Role Logic
                if (Auth::user()->hasRole('consultancy_manager')) {
                    // If the status is true, show only the View button
                    if ($row->status) {
                        return '<a href="' . $viewUrl . '" class="btn btn-primary text-white btn-sm" title="view applicant details"><i class="fa-regular fa-eye"></i></a>';
                    }

                    // If the status is not true, show View, Edit, and Delete buttons
                    $editUrl = route('student.edit', $row->slug);
                    $deleteUrl = route('student.destroy', $row->slug);
                    return '
                        <a href="' . $viewUrl . '" class="btn btn-primary btn-sm text-white" title="view applicant details"><i class="fa-regular fa-eye"></i></a>
                        <a href="' . $editUrl . '" class="btn btn-warning btn-sm text-white" title="update applicant"><i class="fa-solid fa-pencil"></i></a>
                        <button class="btn btn-danger btn-sm delete-btn" data-url="' . $deleteUrl . '" data-id="' . $row->id . '" title="delete applicant"><i class="fa-solid fa-trash"></i></button>
                    ';
                }

                return ''; // No action buttons for users without valid roles
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
            ->addColumn('consultancy_name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('consultancy_address', function ($row) {
                return $row->user->consultancy->address ?? 'N/A';
            })
            ->addColumn('exam_duration', function ($row) {
                $startTime = Carbon::parse($row->exam_date->exam_start_time);
                $endTime = Carbon::parse($row->exam_date->exam_end_time);
                return $startTime->format('h:i A') . ' - ' . $endTime->format('h:i A');
            })
            ->rawColumns(['receipt_image', 'status', 'action', 'admit_card']) // Add admit_card to rawColumns
            ->make(true);
    }



    /**
     * Get pending students
     */
    public function getPendingStudents(Request $request)
    {
        if ($request->ajax()) {
            // Return the data for pending students
            return $this->getPendingOrApprovedStudents(false);
        }
        return view('admin.students.pending');
    }

    /**
     * Get approved students
     */
    public function getApprovedStudents(Request $request)
    {
        if ($request->ajax()) {
            // Return the data for approved students
            return $this->getPendingOrApprovedStudents(true);
        }
        return view('admin.students.approved');
    }
}

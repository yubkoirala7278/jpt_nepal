<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Imports\ExamCodeImport;
use App\Mail\StudentCreatedMail;
use App\Models\Account;
use App\Models\AdmitCard;
use App\Models\Consultancy;
use App\Models\ExamDate;
use App\Models\Nationality;
use App\Models\Students;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

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
        $examDates = ExamDate::orderBy('exam_date', 'asc')->get();
        $testCenterManagers = User::role('test_center_manager')->get();
        if ($request->ajax()) {
            return $this->getPendingOrApprovedStudents($request, null);
        }
        return view('admin.students.index', compact('examDates', 'testCenterManagers'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $nationalities = Nationality::orderBy('name', 'asc')->get();
            $examDates = ExamDate::where('exam_date', '>', now()->addDays(10))
                ->latest()
                ->get();
                $account=Account::latest()->first();
            return view('admin.students.create', compact('examDates', 'nationalities','account'));
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
            $receiptPath = null;
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->storeAs(
                    'public/receipt_image',
                    uniqid() . '.' . $request->file('receipt_image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $receiptPath = str_replace('public/', 'Storage/', $receiptPath);
            }
            // Handle file upload for the citizenship
            if ($request->hasFile('citizenship')) {
                $citizenshipPath = $request->file('citizenship')->storeAs(
                    'public/citizenship',
                    uniqid() . '.' . $request->file('citizenship')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $citizenshipPath = str_replace('public/', 'Storage/', $citizenshipPath);
            }
            $test_center = Auth::user()->consultancy->test_center->test_center;
            $student = Students::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'profile' => $profilePath,
                'citizenship' => $citizenshipPath,
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'is_appeared_previously' => $request['is_appeared_previously'] ? true : false,
                'receipt_image' => $receiptPath,
                'user_id' => Auth::user()->id,
                'exam_date_id' => $request['exam_date'],
                'amount' => $request['amount'] ?? null,
                'gender' => $request['gender'],
                'nationality' => $request['nationality'],
                'venue_code' => $test_center->venue_code,
                'test_venue' => $test_center->test_venue,
                'venue_name'=>$test_center->venue_name,
                'venue_address'=>$test_center->venue_address,
                'exam_category' => $request['exam_category'],
                'examinee_category' => $request['examinee_category']
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
                'consultancy_phone_number' => $student->user->consultancy->phone,
                'registration_number' => $student->slug,
                'venue_code' => $test_center->venue_code,
                'venue_name'=>$test_center->venue_name,
                'venue_address'=>$test_center->venue_address,
                'test_venue' => $test_center->test_venue,
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
            if (Auth::user()->hasRole('admin')) {
                $student->update([
                    'is_viewed_by_admin' => true
                ]);
            } else if (Auth::user()->hasRole('test_center_manager')) {
                $student->update([
                    'is_viewed_by_test_center_manager' => true
                ]);
            }

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
            $examDates = ExamDate::where('exam_date', '>', now()->addDays(10))
                ->latest()
                ->get();
            $nationalities = Nationality::orderBy('name', 'asc')->get();
            return view('admin.students.edit', compact('student', 'examDates', 'nationalities'));
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
            // Handle file upload for the receipt image
            if ($request->hasFile('receipt_image')) {
                // Delete the old receipt image if it exists
                $sameReceiptCount = Students::where('receipt_image', $student->receipt_image)->count();

                if ($sameReceiptCount == 1 && $student->receipt_image && Storage::exists(str_replace('Storage/', 'public/', $student->receipt_image))) {
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

            // Handle citizenship 
            if ($request->hasFile('citizenship')) {
                // Delete the old citizenship image if it exists
                if ($student->citizenship && Storage::exists(str_replace('Storage/', 'public/', $student->citizenship))) {
                    Storage::delete(str_replace('Storage/', 'public/', $student->citizenship));
                }

                $citizenshipPath = $request->file('citizenship')->storeAs(
                    'public/citizenship',
                    uniqid() . '.' . $request->file('citizenship')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $citizenshipPath = str_replace('public/', 'Storage/', $citizenshipPath);
            } else {
                // Keep the old citizenship image if no new one is uploaded
                $citizenshipPath = $student->citizenship;
            }
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

            // Update the student record
            $student->update([
                'name' => $request['name'],
                'address' => $request['address'],
                'profile' => $profilePath,
                'citizenship' => $citizenshipPath,
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'is_appeared_previously' => $request['is_appeared_previously'] ? true : false,
                'receipt_image' => $receiptPath,
                'exam_date_id' => $request['exam_date'],
                'amount' => $request['amount'],
                'nationality' => $request['nationality'],
                'gender' => $request['gender'],
                'examinee_category' => $request['examinee_category'],
                'exam_category' => $request['exam_category']
            ]);
            // sending updated mail to applicant
            $examStartTime = \Carbon\Carbon::parse($student->exam_date->exam_start_time)->format('h:i A');
            $examEndTime = \Carbon\Carbon::parse($student->exam_date->exam_end_time)->format('h:i A');
            $data = [
                'name' => $request['name'],
                'address' =>  $request['address'],
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'exam_date' => \Carbon\Carbon::parse($student->exam_date->exam_date)->format('F j, Y'), // Formats as "Month Day, Year"
                'exam_duration' => "$examStartTime to $examEndTime",
                'consultancy_name' => $student->user->name,
                'consultancy_address' => $student->user->consultancy->address ?? $student->user->test_center->address,
                'consultancy_phone_number' => $student->user->consultancy->phone ?? $student->user->test_center->phone,
                'registration_number' => $student->slug,
                'test_venue' => $student->test_venue,
                'venue_code' => $student->venue_code
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
            if ($student->receipt_image) {
                $relativeReceiptPath = str_replace('Storage/', 'public/', $student->receipt_image);
            }
            // Delete the receipt if it exists
            if ($student->receipt_image && Storage::exists($relativeReceiptPath)) {
                $sameReceiptCount = Students::where('receipt_image', $student->receipt_image)->count();
                if ($sameReceiptCount == 1) {
                    Storage::delete($relativeReceiptPath);
                }
            }
            $relativeProfilePath = str_replace('Storage/', 'public/', $student->profile);
            // delete admit card if present
            if ($student->admit_cards) {
                $relativeAdmitCardPath = str_replace('Storage/', 'public/', $student->admit_cards->admit_card);
                if ($student->admit_cards->admit_card && Storage::exists($relativeAdmitCardPath)) {
                    Storage::delete($relativeAdmitCardPath);
                }
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
     * Get pending students
     */
    public function getPendingStudents(Request $request)
    {
        $examDates = ExamDate::latest()->get();
        $testCenterManagers = User::role('test_center_manager')->get();
        if ($request->ajax()) {
            return $this->getPendingOrApprovedStudents($request, false);
        }
        return view('admin.students.pending', compact('examDates','testCenterManagers'));
    }

    /**
     * Get approved students
     */
    public function getApprovedStudents(Request $request)
    {
        $examDates = ExamDate::latest()->get();
        $testCenterManagers = User::role('test_center_manager')->get();
        if ($request->ajax()) {
            return $this->getPendingOrApprovedStudents($request, true);
        }
        return view('admin.students.approved', compact('examDates','testCenterManagers'));
    }

    /**
     * Get pending or approved students
     */
    public function getPendingOrApprovedStudents($request, $status)
    {
        if ($request->ajax()) {
            $query = Students::with('user.consultancy', 'user.test_center', 'exam_date', 'admit_cards')
                ->latest();

            // Apply status filter if provided
            if ($status !== null) {
                $query->where('status', $status);
            }

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
                    : $student->user->test_center->venue_address;
                return $student;
            });

            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('receipt', function ($row) {
                    $modalId = 'modal-' . $row->id; // Unique modal ID for each row
                    $imageUrl = asset($row->receipt_image);

                    return '
                        <img src="' . $imageUrl . '" alt="Not Available" height="30" loading="lazy" 
                             style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">
                        <!-- Modal -->
                        <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="' . $modalId . '-label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="' . $modalId . '-label">Receipt Image</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="' . $imageUrl . '" alt="Not Available" class="img-fluid" loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '
                    <a href="' . route('student.show', $row->slug) . '" class="btn btn-info text-white btn-sm" title="view">
                        <i class="fa-regular fa-eye"></i>
                    </a>';

                    // Only show edit and delete buttons if status is false
                    if (auth()->user()->hasRole('consultancy_manager') && !$row->status) {
                        $buttons .= '
                        <a href="' . route('student.edit', $row->slug) . '" class="btn btn-warning text-white btn-sm" title="edit">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm text-white delete-student" data-slug="' . $row->slug . '" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>';
                    }

                    // Only show edit and delete buttons if status is false
                    if (auth()->user()->hasRole('test_center_manager') && !$row->status) {
                        $buttons .= '
                        <a href="' . route('student.edit', $row->slug) . '" class="btn btn-warning text-white btn-sm" title="edit">
                            <i class="fa-solid fa-pencil"></i>
                        </a>';
                    }
                    // Button to change status (for test_center_manager if amount is paid and receipt exists)
                    if (auth()->user()->hasRole('test_center_manager') && $row->amount && $row->receipt_image && !$row->exam_number) {
                        $statusText = $row->status ? 'Pending' : 'Approved';
                        $statusColor = $row->status ? 'warning' : 'success';
                        $buttons .= '
                        <button type="button" class="btn btn-' . $statusColor . ' btn-sm text-white change-status-btn" 
                                data-slug="' . $row->slug . '" 
                                data-status="' . $row->status . '" 
                                title="Change Status">
                            <i class="fa-solid fa-toggle-' . ($row->status ? 'off' : 'on') . '"></i>
                        </button>';
                    }


                    // // Show the upload admit card button only for admin and if status is false
                    // if (auth()->user()->hasRole('admin') && $row->status) {
                    //     $buttons .= '
                    //     <button type="button" class="btn btn-success btn-sm text-white upload-admit-card-btn" title="Upload Admit Card" 
                    //             data-slug="' . $row->slug . '"><i class="fa-solid fa-upload"></i>
                    //     </button>';
                    // }

                    return $buttons;
                })
                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge text-bg-success">Approved</span>'
                        : '<span class="badge text-bg-danger">Pending</span>';
                })
                ->editColumn('amount', function ($row) {
                    return $row->amount ?? '<span class="badge text-bg-warning text-white">Due</span>';
                })
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
                ->rawColumns(['receipt', 'action', 'status', 'admit_card', 'amount'])
                ->make(true);
        }
    }


    /**
     * Export applicants
     */
    public function exportApplicants(Request $request)
    {
        try {
            // Validate the request
            $validator = \Validator::make($request->all(), [
                'export' => 'required|in:excel,csv,pdf',
                'date' => 'required|exists:exam_dates,id',
                'status' => 'required',
                'test_center' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle the export based on the selected type
            if ($request->export === 'excel') {
                return $this->exportApplicantsToExcel($request->date, $request->status, $request->test_center,$request['export_reason']);
            } elseif ($request->export === 'csv') {
                return $this->exportApplicantsToCSV($request->date, $request->status, $request->test_center,$request['export_reason']);
            } elseif ($request->export === 'pdf') {
                return $this->exportApplicantsToPDF($request->date, $request->status, $request->test_center);
            }

            return response()->json(['success' => false, 'message' => 'Invalid export option.'], 400);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }


    /**
     * Export applicants to Excel
     */
    public function exportApplicantsToExcel($exam_date_id, $status, $testCenterId,$export_reason)
    {
        try {
            $userIdsArray = Consultancy::where('test_center_id', $testCenterId)->pluck('user_id')->toArray();
            $userIdsArray[] = $testCenterId;
            // Fetch students filtered by the selected exam date
            $students = Students::with('exam_date')
                ->where('exam_date_id', $exam_date_id)
                ->whereIn('user_id', $userIdsArray)
                ->when($status == 0 || $status == 1, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->get();


            // Export the students to Excel using Laravel Excel
            return Excel::download(new StudentsExport($students,$export_reason), 'applicants.xlsx');
        } catch (\Throwable $th) {
            // Return error message
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Export applicants to csv
     */
    public function exportApplicantsToCSV($exam_date_id, $status, $testCenterId,$export_reason)
    {
        try {
            $userIdsArray = Consultancy::where('test_center_id', $testCenterId)->pluck('user_id')->toArray();
            $userIdsArray[] = $testCenterId;
            // Fetch students filtered by the selected exam date
            $students = Students::with('exam_date')
                ->where('exam_date_id', $exam_date_id)
                ->whereIn('user_id', $userIdsArray)
                ->when($status == 0 || $status == 1, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->get();

            // Trigger the CSV export and download the file
            return Excel::download(new StudentsExport($students,$export_reason), 'applicants.csv');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Export applicants to pdf
     */
    public function exportApplicantsToPDF($exam_date_id, $status, $testCenterId)
    {
        try {
            $userIdsArray = Consultancy::where('test_center_id', $testCenterId)->pluck('user_id')->toArray();
            $userIdsArray[] = $testCenterId;
            // Fetch students filtered by the selected exam date
            $students = Students::with('exam_date')
                ->where('exam_date_id', $exam_date_id)
                ->whereIn('user_id', $userIdsArray)
                ->when($status == 0 || $status == 1, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->get();

            // load the view and pass the data to it
            $pdf = PDF::loadView('admin.exports.applicants', compact('students'));
            // return the generated pdf to download
            return $pdf->download('applicant_list.pdf');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * upload receipt
     */
    public function uploadReceipt()
    {
        try {
            $students = Students::where('user_id', Auth::id())
                ->whereNull('amount')
                ->latest()
                ->get();
                $account=Account::latest()->first();
            return view('admin.students.upload-receipt', compact('students','account'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function storeReceiptInfo(Request $request)
    {
        // Get the students array
        $students = $request->input('students', []);

        // Remove 'select_all' from the array if it exists
        $request['students'] = array_filter($students, function ($value) {
            return $value !== 'select_all';
        });

        // Reindex the array to avoid gaps in the keys (optional)
        $students = array_values($students);

        // Validate the students input (ensuring each ID exists in the database)
        $request->validate([
            'receipt_image' => 'required|max:2048',
            'amount' => 'required|numeric',
            'students' => 'required|array|min:1', // Ensure at least one student remains after removal
            'students.*' => 'exists:students,id'  // Validate each student ID exists in the students table
        ]);

        // Store the receipt image if it exists
        $receiptPath = null;
        if ($request->hasFile('receipt_image')) {
            // Generate unique file name and store the image
            $receiptPath = $request->file('receipt_image')->storeAs(
                'public/receipt_image', // Store in 'public/receipt_image' directory
                uniqid() . '.' . $request->file('receipt_image')->getClientOriginalExtension() // Unique file name
            );

            // Replace 'public/' with 'Storage/' for storing path in database
            $receiptPath = str_replace('public/', 'Storage/', $receiptPath);
        }

        $students = $request->input('students', []);
        $student_count = count($students);
        $each_student_receipt_amount = $request['amount'] / $student_count;

        try {
            // $receipt_amount=$request['amount']/;
            // Update each student's receipt image
            foreach ($students as $studentId) {
                $studentInfo = Students::findOrFail($studentId); // Find the student or fail

                // Update the student record with the receipt image path
                $studentInfo->update([
                    'receipt_image' => $receiptPath,
                    'amount' => $each_student_receipt_amount
                ]);
            }
            return redirect()->route('student.index')->with('success', 'Receipt has been uploaded for the selected applicants!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    // import exam code
    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,csv,application/csv,application/vnd.ms-excel',
        // ]);
        

        try {
            Excel::import(new ExamCodeImport, $request->file('file'));
            return back()->with('success', 'Exam Code imported successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handling duplicate entry error from the database (unique constraint violation)
            if ($e->getCode() == '23000') {
                return back()->with('error', 'Something went wrong.Please try again!');
            }
            // General error message for other database exceptions
            return back()->with('error', 'An error occurred while importing the exam codes. Please try again later.');
        } catch (\Exception $e) {
            // Catch custom exceptions like non-existing student_id
            return back()->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            // Catch all other exceptions
            return back()->with('error', 'An unexpected error occurred: ' . $th->getMessage());
        }
    }

    // =====change status of student=======
    public function changeStatus(Request $request)
    {
        $student = Students::where('slug', $request->slug)->firstOrFail();
        $student->update([
            'status' => $request->status == 'true' ? true : false
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Mail\StudentCreatedMail;
use App\Models\ExamDate;
use App\Models\Nationality;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function index()
    {
        try {
            $examDates = ExamDate::where('exam_date', '>', now()->addDays(10))
                ->orderBy('exam_date', 'asc')
                ->get();
            $testCenters = User::role('test_center_manager')
                ->whereHas('test_center', function ($query) {
                    $query->where('status', 'active');
                })
                ->orderBy('name', 'asc')
                ->get();
                $nationalities = Nationality::orderBy('name', 'asc')->get();
            return view('public.registration.index', compact('examDates', 'testCenters','nationalities'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function validateForm(RegistrationRequest $request)
    {
        try {
             // Get the exam date name
            $examDate = ExamDate::find($request->exam_date);
            $testCenter=User::find($request->test_center);
            // Return sanitized data on success
            return response()->json([
                'message' => 'Validation successful',
                'data' => array_merge(
                    $request->only([
                        'name',
                        'address',
                        'phone',
                        'dob',
                        'email',
                        'is_appeared_previously',
                        'gender',
                        'nationality'
                    ]),
                    [
                        'exam_date' => $examDate ? $examDate->exam_date : null,
                        'test_center'=>$testCenter?$testCenter->name:null,
                        'amount'=>$request->amount??"Pay Later",
                    ]
                ),
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function store(RegistrationRequest $request)
    {
        try {
            $profilePath = $request->hasFile('profile')
                ? $request->file('profile')->storeAs('public/profile', uniqid() . '.' . $request->file('profile')->getClientOriginalExtension())
                : null;

            $receiptPath = $request->hasFile('receipt_image')
                ? $request->file('receipt_image')->storeAs('public/receipt_image', uniqid() . '.' . $request->file('receipt_image')->getClientOriginalExtension())
                : null;

            $citizenshipPath = $request->hasFile('citizenship')
                ? $request->file('citizenship')->storeAs('public/citizenship', uniqid() . '.' . $request->file('citizenship')->getClientOriginalExtension())
                : null;

            $student = Students::create([
                'name' => $request->name,
                'address' => $request->address,
                'profile' => str_replace('public/', 'Storage/', $profilePath),
                'citizenship' => str_replace('public/', 'Storage/', $citizenshipPath),
                'phone' => $request->phone,
                'dob' => $request->dob,
                'email' => $request->email,
                'is_appeared_previously' => $request->has('is_appeared_previously'),
                'receipt_image' => str_replace('public/', 'Storage/', $receiptPath),
                'user_id' => $request->test_center,
                'exam_date_id' => $request->exam_date,
                'amount' => $request->amount??null,
                'gender'=>$request->gender,
                'nationality'=>$request->nationality
            ]);

            $examStartTime = \Carbon\Carbon::parse($student->exam_date->exam_start_time)->format('h:i A');
            $examEndTime = \Carbon\Carbon::parse($student->exam_date->exam_end_time)->format('h:i A');
            $data = [
                'name' => $student->name,
                'address' =>$student->address,
                'phone' => $student->phone,
                'dob' => $student->dob,
                'email' =>$student->email,
                'exam_date' => \Carbon\Carbon::parse($student->exam_date->exam_date)->format('F j, Y'), // Formats as "Month Day, Year"
                'exam_duration' => "$examStartTime to $examEndTime",
                'consultancy_name' => $student->user->name,
                'consultancy_address' => $student->user->test_center->address,
                'consultancy_phone_number' => $student->user->test_center->phone,
                'registration_number' => $student->slug,
            ];
            Mail::to($student->email)->send(new StudentCreatedMail($data));

            return response()->json(['message' => 'Registration successfully done!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdmitCardController extends Controller
{
    public function index()
    {
        try {
            return view('public.admit_card.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function getApplicantResult()
    {
        try {
            return view('public.admit_card.result');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    // =========get applicant result=============
    public function getResult(Request $request)
    {
        $validated = $request->validate([
            'dob' => 'required|date',
            'registration_number' => 'required|string',
        ]);

        $student = Students::with('results')
            ->where('slug', $validated['registration_number'])
            ->where('dob', $validated['dob'])
            ->first();
       

        if (!$student) {
            return response()->json(['error' => 'Invalid Date of Birth or Registration Number. Please check your input and try again.'], 404);
        }
        if ((!$student->exam_number || !$student->status) && $student->amount) {
            return response()->json(['error' => 'Your result is under process. Please check back later.'], 404);
        }

        if (!$student->amount) {
            return response()->json(['error' => 'Result not found!'], 404);
        }


        return response()->json([
            'success' => true,
            'marks' => $student->results->marks,
            'result' => $student->results->result,
        ]);
    }

    // display admit card
    public function showAdmitCard($dob, $registration_number)
    {
        try {
            if (!$dob || !$registration_number) {
                return redirect()->back()->with('error', 'DOB or Registration Missing!.');
            }
            $student = Students::with('exam_date')
                ->where('slug', $registration_number)
                ->where('dob', $dob)
                ->where('status', true)
                ->whereNotNull('exam_number')
                ->whereNotNull('amount')
                ->first();

            if (!$student) {
                return redirect()->back()->with('error', 'Admit card not found.');
            }

            $exam_time = $student->exam_date->exam_start_time->format('h:i A') .
                ' to ' .
                $student->exam_date->exam_end_time->format('h:i A');
            $exam_date = Carbon::parse($student->exam_date->exam_date)->format('Y F d');
            $data = [
                'examDate' => $exam_date,
                'receptionHours' => $exam_time,
                'testVenue' => $student->test_venue,
                'venueCode' => $student->venue_code,
                'examineeNumber' => $student->exam_number,
                'dob' => $student->dob,
                'gender' => $student->gender,
                'examineeCategory' => $student->examinee_category,
                'examCategory' => $student->exam_category,
                'applicantName' => $student->name,
                'venue_name' => $student->venue_name,
                'venue_address' => $student->venue_address,
                'imagePath' => $student->profile,
                'logo' => public_path('/admit_card/image.png'),
            ];

            return view('admin.students.admit_card', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}

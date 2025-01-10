<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    // =======download admit card===========
    // public function getAdmitCard(Request $request)
    // {
    //     $request->validate([
    //         'dob' => 'required',
    //         'registration_number' => 'required',
    //     ]);

    //     try {
    //         // Find the student with the given registration number and DOB
    //         $admitCard = Students::with('admit_cards')
    //             ->where('slug', $request['registration_number'])
    //             ->where('dob', $request['dob'])
    //             ->first();

    //         // Check if the student and admit card exists
    //         if (!$admitCard || !$admitCard->admit_cards) {
    //             return response()->json(['error' => 'Admit card not found.'], 404);
    //         }

    //         // Get the file path of the admit card
    //         $filePath = $admitCard->admit_cards->admit_card;  // Example: 'Storage/admit_card/admit_card1.png'

    //         // Remove the 'Storage/' part of the file path and use the storage path
    //         $filePath = str_replace('Storage/', 'public/', $filePath);

    //         // Ensure the file exists before trying to download
    //         if (Storage::exists($filePath)) {
    //             // Return the file path as a URL to trigger the download
    //             $downloadUrl = Storage::url($filePath);
    //             return response()->json(['downloadUrl' => $downloadUrl]);
    //         }

    //         return response()->json(['error' => 'File not found.'], 404);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th->getMessage()], 404);
    //     }
    // }


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

        if (!$student || !$student->results) {
            return response()->json(['error' => 'Invalid Date of Birth or Registration Number. Please check your input and try again.'], 404);
        }

        return response()->json([
            'success' => true,
            'marks' => $student->results->marks,
            'result' => $student->results->result,
        ]);
    }


    public function getAdmitCard(Request $request)
    {
        $request->validate([
            'dob' => 'required|date',
            'registration_number' => 'required',
        ]);

        try {
            $student = Students::with('exam_date')
                ->where('slug', $request['registration_number'])
                ->where('dob', $request['dob'])
                ->where('status', true)
                ->whereNotNull('exam_number')
                ->whereNotNull('amount')
                ->first();

            if (!$student) {
                return response()->json(['error' => 'Admit card not found.'], 404);
            }

            $exam_time = $student->exam_date->exam_start_time->format('h:i A') .
                ' to ' .
                $student->exam_date->exam_end_time->format('h:i A');
            $exam_date = Carbon::parse($student->exam_date->exam_date)->format('Y F d');
            $data = [
                'examDate' => $exam_date,
                'receptionHours' => $exam_time,
                'testVenue' => 'Butwal',
                'venueCode' => '003',
                'examineeNumber' => $student->exam_number,
                'dob' => $student->dob,
                'gender' => $student->gender,
                'examineeCategory' => 'Student',
                'examCategory' => '定期',
                'applicantName' => $student->name,
                'testingCenter' => 'Rammani Multiple Campus',
                'address' => $student->address,
                'venueDirections' => 'Sample Directions',
                'imagePath' => public_path($student->profile),
                'logo' => public_path('/admit_card/image.png'),
            ];

            return response()->json(['data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public function showAdmitCard($dob, $registration_number)
    {
        try {
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
                'testVenue' => 'Butwal',
                'venueCode' => '003',
                'examineeNumber' => $student->exam_number,
                'dob' => $student->dob,
                'gender' => $student->gender,
                'examineeCategory' => 'Student',
                'examCategory' => '定期',
                'applicantName' => $student->name,
                'testingCenter' => 'Rammani Multiple Campus',
                'address' => $student->address,
                'venueDirections' => 'Sample Directions',
                'imagePath' => public_path($student->profile),
                'logo' => public_path('/admit_card/image.png'),
            ];

            return view('admin.students.admit_card', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}

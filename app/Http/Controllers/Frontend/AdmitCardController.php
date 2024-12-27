<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmitCardController extends Controller
{
    public function index(){
        try{
            return view('public.admit_card.index');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }

    public function getAdmitCard(Request $request)
    {
        $request->validate([
            'dob' => 'required',
            'registration_number' => 'required',
        ]);
    
        // Find the student with the given registration number and DOB
        $admitCard = Students::with('admit_cards')
            ->where('slug', $request['registration_number'])
            ->where('dob', $request['dob'])
            ->first();
    
        // Check if the student and admit card exists
        if (!$admitCard || !$admitCard->admit_cards) {
            return response()->json(['error' => 'Admit card not found.'], 404);
        }
    
        // Get the file path of the admit card
        $filePath = $admitCard->admit_cards->admit_card;  // Example: 'Storage/admit_card/admit_card1.png'
    
        // Remove the 'Storage/' part of the file path and use the storage path
        $filePath = str_replace('Storage/', 'public/', $filePath);
    
        // Ensure the file exists before trying to download
        if (Storage::exists($filePath)) {
            // Return the file path as a URL to trigger the download
            $downloadUrl = Storage::url($filePath);
            return response()->json(['downloadUrl' => $downloadUrl]);
        }
    
        return response()->json(['error' => 'File not found.'], 404);
    }
    
    
    

    public function getApplicantResult(){
        try{
            return view('public.admit_card.result');
        }catch(\Throwable $th){
            return back()->with('error',$th->getMessage());
        }
    }
}

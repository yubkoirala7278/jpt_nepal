<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ExamDate;
use App\Models\Notice;
use App\Models\TestCenter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $upcomingTests = ExamDate::where('exam_date', '>', Carbon::now()->toDateString())
                ->orderBy('exam_date', 'asc')
                ->take(4)
                ->get();
            $notices = Notice::latest()->take(4)->get();
            $testCentreAddress = TestCenter::select('address')->distinct()->get();
            return view('public.home.index', compact('upcomingTests', 'notices', 'testCentreAddress'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function getTestCenterDetails(Request $request)
    {
        try {
            // Validate the address input
            $validated = $request->validate([
                'address' => 'required|string',  // Ensure the address is required and is a string
            ]);
    
            // If validation passes, proceed with fetching the test centers
            $address = $request->input('address');
            $testCentres = TestCenter::with('user')
                ->where('address', 'like', '%' . $address . '%') // Partial match for the address
                ->get();
    
            // Check if any test centers were found
            if ($testCentres->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No test centers found for this location.']);
            }
    
            // Return the data as a JSON response
            return response()->json(['success' => true, 'data' => $testCentres]);
    
        } catch (\Throwable $th) {
            // Handle any other errors
            return response()->json(['success' => false, 'message' => 'An error occurred, please try again later.']);
        }
    }
    
    
}

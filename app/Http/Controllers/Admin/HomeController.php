<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmitCard;
use App\Models\Consultancy;
use App\Models\ExamDate;
use App\Models\Notice;
use App\Models\Result;
use App\Models\Students;
use App\Models\TestCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $totalTestCenter = null;
            $totalEducationConsultancy = null;
            $totalApplicants = 0;
            $totalNotice = null;
            $totalAdmitCard = null;
            $totalResults = null;
            $students = [];
            $notices = [];
            $upcomingTests = [];
            $jptApplicants = 0;
            $pendingApplicants = 0;
            $upcomingTestCount = 0;
            if (Auth::user()->hasRole('admin')) {
                $totalTestCenter = TestCenter::count();
                $totalEducationConsultancy = Consultancy::count();
                $totalApplicants = Students::count();
                $pendingApplicants = Students::where('status', false)->count();
                $totalNotice = Notice::count();
                $totalAdmitCard = AdmitCard::count();
                $totalResults = Result::count();
                $students = Students::where('is_viewed_by_admin', false)->where('status', true)->with('user','exam_date')->latest()->paginate(10);
                $upcomingTestCount = ExamDate::where('exam_date', '>', Carbon::today())->count();
            } elseif (Auth::user()->hasRole('consultancy_manager') || Auth::user()->hasRole('test_center_manager')) {
                $notices = Notice::latest()->paginate(10);
                $upcomingTests = ExamDate::where('exam_date', '>', Carbon::now()->toDateString())
                    ->orderBy('exam_date', 'asc')
                    ->paginate(10);
                if (Auth::user()->hasRole('consultancy_manager')) {
                    $jptApplicants = Students::where('user_id', Auth::user()->id)->count();
                    $pendingApplicants = Students::where('user_id', Auth::user()->id)->where('status', false)->count();
                } else {
                    $totalEducationConsultancy = Consultancy::where('test_center_id', Auth::user()->id)->count();
                    $educationConsultancy = Consultancy::where('test_center_id', Auth::user()->id)
                        ->pluck('user_id')
                        ->toArray();

                    // Add the authenticated user's ID
                    $educationConsultancy[] = Auth::user()->id;

                    $jptApplicants = Students::whereIn('user_id', $educationConsultancy)->count();
                    $pendingApplicants = Students::whereIn('user_id', $educationConsultancy)->where('status', false)->count();

                    $students = Students::whereIn('user_id', $educationConsultancy)->where('is_viewed_by_test_center_manager', false)->where('status', false)->with('user','exam_date')->latest()->paginate(10);
                }
            }
            return view('admin.home.index', compact('totalTestCenter', 'totalEducationConsultancy', 'totalApplicants', 'totalNotice', 'totalAdmitCard', 'totalResults', 'students', 'notices', 'upcomingTests', 'jptApplicants', 'pendingApplicants', 'upcomingTestCount'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmitCard;
use App\Models\Blog;
use App\Models\Consultancy;
use App\Models\ExamDate;
use App\Models\Notice;
use App\Models\Result;
use App\Models\Students;
use App\Models\TestCenter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $totalTestCenter = null;
            $totalEducationConsultancy = null;
            $totalApplicants = 0;
            $totalNotice = null;
            $totalBlogs=null;
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
                $totalBlogs=Blog::count();
                $totalResults = Result::count();
                $students = Students::where('is_viewed_by_admin', false)->where('status', true)->with('user', 'exam_date')->latest()->paginate(10);
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

                    $students = Students::whereIn('user_id', $educationConsultancy)->where('is_viewed_by_test_center_manager', false)->where('status', false)->with('user', 'exam_date')->latest()->paginate(10);
                }
            }
            return view('admin.home.index', compact('totalTestCenter', 'totalEducationConsultancy', 'totalApplicants', 'totalNotice', 'totalBlogs', 'totalResults', 'students', 'notices', 'upcomingTests', 'jptApplicants', 'pendingApplicants', 'upcomingTestCount'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function showApplicantCountPerMonthChart(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
    
        // Get the authenticated user
        $user = auth()->user();
    
        // Try to get data from cache
        $cacheKey = 'students_by_month_' . $year . '_' . $user->id;
        $studentsByMonth = Cache::remember($cacheKey, 60, function () use ($year, $user) {
            $query = Students::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month', 'asc');
    
            // If the user is a test_center_manager
            if ($user->hasRole('test_center_manager')) {
                // Get the test center ID associated with the user
                $testCenterUserId = $user->id;
    
                // Get all consultancy user_ids associated with this test center
                $consultancyUserIds = DB::table('consultancies')
                    ->where('test_center_id', $testCenterUserId) // Get consultancies under the test center
                    ->pluck('user_id')
                    ->toArray();
    
                // Add the test center's own user_id to the list
                $consultancyUserIds[] = $testCenterUserId;
    
                // Count students created by the test center or any consultancy manager under the test center
                $query->whereIn('user_id', $consultancyUserIds);
            }
            // If the user is a consultancy_manager, only show their own students
            elseif ($user->hasRole('consultancy_manager')) {
                $query->where('user_id', $user->id);
            }
    
            return $query->pluck('count', 'month');
        });
    
        // Prepare the data for the chart
        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
    
        // Initialize counts array with zeros
        $counts = array_fill(0, 12, 0);
    
        // Assign counts for existing months
        foreach ($studentsByMonth as $month => $count) {
            $counts[$month - 1] = $count; // Adjust for 0-based index
        }
    
        return response()->json([
            'months' => $months,
            'counts' => $counts,
        ]);
    }
    
    





    // public function showApplicantAddedPerTestCenter()
    // {
    //     $consultancies = DB::table('consultancies')
    //         ->join('users', 'consultancies.test_center_id', '=', 'users.id')
    //         ->leftJoin('students', 'consultancies.user_id', '=', 'students.user_id')
    //         ->select('users.name as test_center_name', 'consultancies.user_id')
    //         ->addSelect(DB::raw('COUNT(students.id) as student_count'))
    //         ->groupBy('users.name', 'consultancies.user_id')
    //         ->get()
    //         ->groupBy('test_center_name')
    //         ->map(function ($group) {
    //             return [
    //                 'user_ids' => $group->pluck('user_id')->toArray(),
    //                 'student_count' => $group->sum('student_count')
    //             ];
    //         });
    //     $consultancyData = $consultancies->toArray();

    //     // Calculate total student count
    //     $totalStudentCount = $consultancies->sum('student_count');

    //     // Extract test center names, student counts, and calculate percentages
    //     $studentsCounts = $consultancies->map(function ($data) use ($totalStudentCount) {
    //         return $data['student_count'];
    //     })->toArray();

    //     $percentages = $consultancies->map(function ($data) use ($totalStudentCount) {
    //         return $totalStudentCount ? round(($data['student_count'] / $totalStudentCount) * 100, 2) : 0;
    //     })->toArray();

    //     return response()->json([
    //         'testCenterNames' => array_keys($studentsCounts),
    //         'studentsCounts' => array_values($studentsCounts),
    //         'percentages' => array_values($percentages),
    //         'totalStudentCount' => $totalStudentCount, // Include total student count
    //     ]);
    // }
}

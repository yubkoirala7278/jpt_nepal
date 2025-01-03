<?php

namespace App\Http\Controllers\Admin;

use App\Events\TestCenterCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestCenterRequest;
use App\Mail\TestCenterCreatedMail;
use App\Mail\TestCenterDisabledMail;
use App\Mail\TestCenterEnabledMail;
use App\Models\TestCenter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TestCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testCenters = TestCenter::select([
                'test_centers.*',
                'users.name as user_name',
                'users.email as user_email',
                'test_centers.created_at' // Directly use created_at
            ])
                ->join('users', 'users.id', '=', 'test_centers.user_id');

            // Apply filters dynamically based on search term
            if ($request->has('search') && !empty($request->search)) {
                $testCenters->where(function ($query) use ($request) {
                    $query->where('users.name', 'like', '%' . $request->search . '%')
                        ->orWhere('users.email', 'like', '%' . $request->search . '%')
                        ->orWhere('test_centers.phone', 'like', '%' . $request->search . '%')
                        ->orWhere('test_centers.address', 'like', '%' . $request->search . '%');
                });
            }

            return DataTables::of($testCenters)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->user_name) // Access joined user name
                ->addColumn('email', fn($row) => $row->user_email) // Access joined user email
                ->addColumn('status', function ($row) {
                    $badgeClass = $row->status === 'active' ? 'badge bg-success' : 'badge bg-danger';
                    return '<span class="' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('test_center.edit', $row->slug); // Route to edit test center
                    $disableUrl = route('disable.test_center'); // Post route for disabling/enabling test center

                    $actionButtons = '
                    <div class="d-flex align-items-center" style="column-gap:10px">
                        <a href="' . $editUrl . '" class="btn btn-warning btn-sm text-white" title="edit test center">
                            <i class="fa-solid fa-pencil"></i>
                        </a>';

                    if ($row->status === 'active') {
                        $actionButtons .= '
                        <button type="button" class="btn btn-secondary btn-sm disable-btn" 
                                data-slug="' . $row->slug . '" 
                                title="disable test center">
                            <i class="fa-solid fa-ban"></i>
                        </button>';
                    } else {
                        $actionButtons .= '
                        <button type="button" class="btn btn-success btn-sm enable-btn" 
                                data-slug="' . $row->slug . '" 
                                title="enable test center">
                            <i class="fa-solid fa-check"></i>
                        </button>';
                    }

                    $actionButtons .= '</div>';
                    return $actionButtons;
                })
                ->editColumn('created_at', fn($row) => Carbon::parse($row->created_at)->format('M d, Y')) // Format date
                ->orderColumn('created_at', 'test_centers.created_at $1') // Sorting logic
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.test_center.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.test_center.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestCenterRequest $request)
    {
        try {
            // Create the user
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            // assign role
            $user->assignRole('test_center_manager');

            // Create the test center record
            TestCenter::create([
                'user_id' => $user->id,
                'phone' => $request['phone'],
                'address' => $request['address'],
            ]);
            // send mail when created test center
            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
                'phone' => $request['phone']
            ];
            Mail::to($request['email'])->send(new TestCenterCreatedMail($data));

            return redirect()->route('test_center.index')->with('success', 'Test Center added successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestCenter $testCenter)
    {
        try {
            return view('admin.test_center.edit', compact('testCenter'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestCenterRequest $request, TestCenter $testCenter)
    {
        try {
            // Update user details
            $user = $testCenter->user;
            $user->name = $request->name;
            $user->email = $request->email;

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update Test Center details
            $testCenter->update([
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return redirect()->route('test_center.index')->with('success', 'Test Center updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestCenter $testCenter)
    {
        try {
            // Delete the related user
            $testCenter->user()->delete();

            // Delete the Test Center
            $testCenter->delete();

            return response()->json(['success' => 'Test Center deleted successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * disable test center
     */
    public function disableTestCenter(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'slug' => 'required|string|exists:test_centers,slug',
            'reason' => 'required|string|max:350',
        ]);
        try {
            $testCenter = TestCenter::where('slug', $request->slug)->firstOrFail();
            if (!$testCenter) {
                return response()->json(['message' => 'Test Center not found.'], 404);
            }
            // Add the reason for disabling
            $testCenter->status = 'disabled';
            $testCenter->disabled_reason = $request->reason;
            $testCenter->save();

            // sending mail to test center if the test center has been disabled
            $data = [
                'name' => $testCenter->user->name,
                'reason' => $request->reason
            ];
            Mail::to($testCenter->user->email)->send(new TestCenterDisabledMail($data));

            return response()->json(['message' => 'Test center disabled successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to disable test center.'], 500);
        }
    }


    /**
     * enable test center
     */
    public function enableTestCenter(Request $request)
    {
        try {
            $testCenter = TestCenter::where('slug', $request->slug)->firstOrFail();
            if (!$testCenter) {
                return response()->json(['message' => 'Test Center not found.'], 404);
            }
            $testCenter->status = 'active';
            $testCenter->disabled_reason = null; // Remove the disabled reason
            $testCenter->save();

             // sending mail to test center if the test center has been enabled
             $data = [
                'name' => $testCenter->user->name,
            ];
            Mail::to($testCenter->user->email)->send(new TestCenterEnabledMail($data));

            return response()->json(['message' => 'Test center enabled successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to enable test center.'], 500);
        }
    }
}

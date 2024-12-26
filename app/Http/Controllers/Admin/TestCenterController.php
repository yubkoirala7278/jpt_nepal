<?php

namespace App\Http\Controllers\Admin;

use App\Events\TestCenterCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestCenterRequest;
use App\Mail\TestCenterCreatedMail;
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
                ->addColumn('logo', fn($row) => '<img src="' . asset($row->logo) . '" alt="Logo" height="30" class="logo-image" data-url="' . asset($row->logo) . '" style="cursor:pointer;" loading="lazy" />') // Add data-url to image
                ->addColumn('action', function ($row) {
                    $editUrl = route('test_center.edit', $row->slug);
                    $deleteUrl = route('test_center.destroy', $row->slug);

                    return '
                    <div class="d-flex align-items-center" style="column-gap:10px">
                        <a href="' . $editUrl . '" class="btn btn-warning text-white btn-sm" title="edit test center"><i class="fa-solid fa-pencil"></i></a>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-url="' . $deleteUrl . '" title="delete test center"><i class="fa-solid fa-trash"></i></button>
                    </div>';
                })
                ->editColumn('created_at', fn($row) => Carbon::parse($row->created_at)->format('M d, Y')) // Format date
                ->orderColumn('created_at', 'test_centers.created_at $1') // Sorting logic
                ->rawColumns(['logo', 'action']) // Allow raw HTML in logo and action columns
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
            // Handle file upload for the logo
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->storeAs(
                    'public/TestCenter',
                    uniqid() . '.' . $request->file('logo')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $logoPath = str_replace('public/', 'Storage/', $logoPath);
            }

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
                'logo' => $logoPath,
            ]);
            // send mail when created test center
            $data=[
                'name'=>$request['name'],
                'email'=>$request['email'],
                'password'=>$request['password'],
                'phone'=>$request['phone']
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
            // Handle file upload for the logo
            if ($request->hasFile('logo')) {
                // Delete the old logo if it exists
                if ($testCenter->logo) {
                    $oldLogoPath = str_replace('Storage/', 'public/', $testCenter->logo); // Adjust path
                    if (Storage::disk('local')->exists($oldLogoPath)) {
                        Storage::disk('local')->delete($oldLogoPath);
                    }
                }

                // Store the new logo and update the path
                $logoPath = $request->file('logo')->storeAs(
                    'public/TestCenter',
                    uniqid() . '.' . $request->file('logo')->getClientOriginalExtension()
                );
                $logoPath = str_replace('public/', 'Storage/', $logoPath);
                $testCenter->logo = $logoPath;
            }

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
            // Ensure the path is relative to the 'public' disk
            $relativeLogoPath = str_replace('Storage/', 'public/', $testCenter->logo);

            // Delete the logo file if it exists
            if ($testCenter->logo && Storage::exists($relativeLogoPath)) {
                Storage::delete($relativeLogoPath);
            }

            // Delete the related user
            $testCenter->user()->delete();

            // Delete the Test Center
            $testCenter->delete();

            return response()->json(['success' => 'Test Center deleted successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

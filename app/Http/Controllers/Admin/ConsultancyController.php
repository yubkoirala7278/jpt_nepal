<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultancyRequest;
use App\Mail\ConsultancyCreatedMail;
use App\Mail\ConsultancyDisabledMail;
use App\Mail\ConsultancyEnabledMail;
use App\Models\Consultancy;
use App\Models\TestCenter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ConsultancyController extends Controller
{

    public function __construct()
    {
        $this->middleware('check.consultancy.access')->only(['edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $consultancies = Consultancy::select([
                'consultancies.*',
                'users.name as user_name',
                'users.email as user_email',
                'test_centers.name as test_center_name', // Add the test center name
                'consultancies.created_at'
            ])
                ->join('users', 'users.id', '=', 'consultancies.user_id')
                ->leftJoin('users as test_centers', 'test_centers.id', '=', 'consultancies.test_center_id'); // Join the users table again for test center

            // Check user role
            if (Auth::user()->hasRole('test_center_manager')) {
                $consultancies->where('consultancies.test_center_id', Auth::user()->id);
            }

            // Apply filters dynamically based on search term
            if ($request->has('search') && !empty($request->search)) {
                $consultancies->where(function ($query) use ($request) {
                    $query->where('users.name', 'like', '%' . $request->search . '%')
                        ->orWhere('users.email', 'like', '%' . $request->search . '%')
                        ->orWhere('consultancies.phone', 'like', '%' . $request->search . '%')
                        ->orWhere('consultancies.address', 'like', '%' . $request->search . '%');
                });
            }

            return DataTables::of($consultancies)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->user_name) // Access joined user name
                ->addColumn('email', fn($row) => $row->user_email) // Access joined user email
                ->addColumn('test_center', fn($row) => $row->test_center_name) // Add test center name column
                ->addColumn('logo', fn($row) => '<img src="' . asset($row->logo) . '" alt="Logo" height="30" class="logo-image" data-url="' . asset($row->logo) . '" style="cursor:pointer;" loading="lazy" />') // Add data-url to image
                ->addColumn('status', function ($row) {
                    $badgeClass = $row->status === 'active' ? 'badge bg-success' : 'badge bg-danger';
                    return '<span class="' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('consultancy.edit', $row->slug);
                    $disableUrl = route('disable.consultancy');
                    $enableUrl = route('enable.consultancy'); // Route for enabling consultancy

                    $buttons = '
                    <div class="d-flex align-items-center" style="column-gap:10px">
                        <a href="' . $editUrl . '" class="btn btn-warning btn-sm text-white" title="edit consultancy">
                            <i class="fa-solid fa-pencil"></i>
                        </a>';

                    if ($row->status === 'active') {
                        $buttons .= '
                        <button type="button" class="btn btn-secondary btn-sm disabled-btn" 
                                data-slug="' . $row->slug . '" 
                                data-toggle="modal" 
                                data-target="#disableModal" 
                                title="disable consultancy">
                            <i class="fa-solid fa-ban"></i>
                        </button>';
                    } else {
                        $buttons .= '
                        <button type="button" class="btn btn-success btn-sm enable-btn" 
                                data-slug="' . $row->slug . '" 
                                title="enable consultancy">
                            <i class="fa-solid fa-check"></i>
                        </button>';
                    }

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->editColumn('created_at', fn($row) => Carbon::parse($row->created_at)->format('M d, Y')) // Format date
                ->orderColumn('created_at', 'consultancies.created_at $1') // Sorting logic
                ->rawColumns(['logo', 'action', 'status']) // Allow raw HTML in logo and action columns
                ->make(true);
        }

        return view('admin.consultancy.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $testCenters = TestCenter::with('user')->latest()->get();
            return view('admin.consultancy.create', compact('testCenters'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultancyRequest $request)
    {
        try {
            // Handle file upload for the logo
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->storeAs(
                    'public/Consultancy',
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
            // assign role as consultancy manager
            $user->assignRole('consultancy_manager');

            // Create the consultancy record
            Consultancy::create([
                'user_id' => $user->id,
                'phone' => $request['phone'],
                'address' => $request['address'],
                'logo' => $logoPath,
                'test_center_id' => Auth::user()->hasRole('test_center_manager')
                    ? Auth::user()->id
                    : $request['test_center']
            ]);
            // calling event to send mail to consultancy
            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
                'phone' => $request['phone']
            ];
            Mail::to($request['email'])->send(new ConsultancyCreatedMail($data));
            return redirect()->route('consultancy.index')->with('success', 'Consultancy added successfully!');
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
    public function edit(Consultancy $consultancy)
    {
        try {
            $testCenters = TestCenter::with('user')->latest()->get();
            return view('admin.consultancy.edit', compact('consultancy', 'testCenters'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultancyRequest $request, Consultancy $consultancy)
    {
        try {
            // Handle file upload for the logo
            if ($request->hasFile('logo')) {
                // Delete the old logo if it exists
                if ($consultancy->logo) {
                    $oldLogoPath = str_replace('Storage/', 'public/', $consultancy->logo); // Adjust path
                    if (Storage::disk('local')->exists($oldLogoPath)) {
                        Storage::disk('local')->delete($oldLogoPath);
                    }
                }

                // Store the new logo and update the path
                $logoPath = $request->file('logo')->storeAs(
                    'public/Consultancy',
                    uniqid() . '.' . $request->file('logo')->getClientOriginalExtension()
                );
                $logoPath = str_replace('public/', 'Storage/', $logoPath);
                $consultancy->logo = $logoPath;
            }

            // Update user details
            $user = $consultancy->user;
            $user->name = $request->name;
            $user->email = $request->email;

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update consultancy details
            $consultancy->update([
                'phone' => $request->phone,
                'address' => $request->address,
                'test_center_id' => Auth::user()->hasRole('test_center_manager')
                    ? Auth::user()->id
                    : $request['test_center']
            ]);

            return redirect()->route('consultancy.index')->with('success', 'Consultancy updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultancy $consultancy)
    {
        try {
            // Ensure the path is relative to the 'public' disk
            $relativeLogoPath = str_replace('Storage/', 'public/', $consultancy->logo);

            // Delete the logo file if it exists
            if ($consultancy->logo && Storage::exists($relativeLogoPath)) {
                Storage::delete($relativeLogoPath);
            }

            // Delete the related user
            $consultancy->user()->delete();

            // Delete the consultancy
            $consultancy->delete();

            return response()->json(['success' => 'Consultancy deleted successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * disable consultancy
     */
    public function disableConsultancy(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'slug' => 'required|string|exists:consultancies,slug',  // Ensure slug is provided and exists in the consultancies table
            'reason' => 'required|string|max:350',  // Validate reason is required and not more than 350 characters
        ]);

        try {
            // Get the consultancy by slug
            $consultancy = Consultancy::where('slug', $request->slug)->first();

            if (!$consultancy) {
                return response()->json(['message' => 'Consultancy not found.'], 404);
            }

            // Add the reason for disabling
            $consultancy->status = 'disabled'; // or whatever status you use for disabling
            $consultancy->disabled_reason = $request->reason;
            $consultancy->save();

            // sending mail to consultancy if the consultancy has been disabled
            $data = [
                'name' => $consultancy->user->name,
                'reason'=>$request->reason
            ];
            Mail::to($consultancy->user->email)->send(new ConsultancyDisabledMail($data));

            return response()->json(['message' => 'Consultancy has been disabled successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to disable consultancy.'], 500);
        }
    }


    /**
     * enable consultancy
     */
    public function enableConsultancy(Request $request)
    {
        try {
            $consultancy = Consultancy::where('slug', $request->slug)->first();

            if (!$consultancy) {
                return response()->json(['message' => 'Consultancy not found.'], 404);
            }

            $consultancy->status = 'active';
            $consultancy->disabled_reason = null;
            $consultancy->save();

             // sending mail to consultancy if the consultancy has been enabled
             $data = [
                'name' => $consultancy->user->name,
            ];
            Mail::to($consultancy->user->email)->send(new ConsultancyEnabledMail($data));

            return response()->json(['message' => 'Consultancy enabled successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to enable consultancy.'], 500);
        }
    }
}

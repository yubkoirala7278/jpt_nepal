<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultancyRequest;
use App\Mail\ConsultancyCreatedMail;
use App\Models\Consultancy;
use App\Models\TestCenter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AgentController extends Controller
{
    public function index()
    {
        try {
            $testCenters = TestCenter::with('user')->latest()->get();
            return view('public.agent.index', compact('testCenters'));
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
            // Handle file upload for the logo if present
            $logoPath = null;
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
                'mobile_number' => $request['mobile_number'],
                'owner_name' => $request['owner_name'],
                'test_center_id' => $request['test_center'],
                'status'=>'disabled',
                'disabled_reason'=>$request['disabled_reason']
            ]);
            // calling event to send mail to consultancy
            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
                'phone' => $request['phone']
            ];
            Mail::to($request['email'])->send(new ConsultancyCreatedMail($data));

            // Send success response
            return response()->json(['message' => 'Consultancy successfully created!'], 200);
        } catch (\Throwable $e) {
            // Handle error and return the message
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Students;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.students.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.students.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        try {
            // Handle file upload for the profile
            if ($request->hasFile('profile')) {
                $profilePath = $request->file('profile')->storeAs(
                    'public/profile',
                    uniqid() . '.' . $request->file('profile')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $profilePath = str_replace('public/', 'Storage/', $profilePath);
            }
            // Handle file upload for the receipt
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->storeAs(
                    'public/receipt_image',
                    uniqid() . '.' . $request->file('receipt_image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $receiptPath = str_replace('public/', 'Storage/', $receiptPath);
            }
            Students::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'profile' => $profilePath,
                'phone' => $request['profile'],
                'dob' => $request['dob'],
                'email' => $request['email'],
                'is_appeared_previously' => $request['is_appeared_previously'],
                'receipt_image' => $receiptPath,
                'consultancy_id' => 1
            ]);
            return back()->with('success','Applicant added successfully!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $accounts = Account::latest()->paginate(10);
            return view('admin.account.index', compact('accounts'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.account.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        try {
            // Handle file upload for the qr_code
            if ($request->hasFile('qr_code')) {
                $imagePath = $request->file('qr_code')->storeAs(
                    'public/StaticImage',
                    uniqid() . '.' . $request->file('qr_code')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $imagePath = str_replace('public/', 'Storage/', $imagePath);
            }

            Account::create([
                'bank_name' => $request['bank_name'],
                'account_name' => $request['account_name'],
                'account_number' => $request['account_number'],
                'branch_name' => $request['branch_name'],
                'qr_code' => $imagePath
            ]);
            return redirect()->route('account.index')->with('success', 'Account added successfully!');
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
    public function edit(Account $account)
    {
        try {
            return view('admin.account.edit', compact('account'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $request, Account $account)
    {
        try {
            $imagePath = $account->qr_code;

            // Check if a new qr_code is uploaded
            if ($request->hasFile('qr_code')) {
                // Ensure the path is relative to the 'public' disk
                $relativeImagePath = str_replace('Storage/', 'public/', $account->qr_code);

                // Delete the old qr_code file if it exists
                if ($account->qr_code && Storage::exists($relativeImagePath)) {
                    Storage::delete($relativeImagePath);
                }

                // Store the new qr_code
                $newImagePath = $request->file('qr_code')->storeAs(
                    'public/StaticImage',
                    uniqid() . '.' . $request->file('qr_code')->getClientOriginalExtension()
                );

                // Convert the new path for storage in the database
                $imagePath = str_replace('public/', 'Storage/', $newImagePath);
            }

            // Update the account record
            $account->update([
                'bank_name' => $request['bank_name'],
                'account_name' => $request['account_name'],
                'account_number' => $request['account_number'],
                'branch_name' => $request['branch_name'],
                'qr_code' => $imagePath
            ]);

            return redirect()->route('account.index')->with('success', 'Account updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        try {
            // Ensure the path is relative to the 'public' disk
            $relativeImagePath = str_replace('Storage/', 'public/', $account->qr_code);

            // Delete the image file if it exists
            if ($account->qr_code && Storage::exists($relativeImagePath)) {
                Storage::delete($relativeImagePath);
            }

            // Delete the account
            $account->delete();

            return back()->with('success', 'Account deleted successfully!');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

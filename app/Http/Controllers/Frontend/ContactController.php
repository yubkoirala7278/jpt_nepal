<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        try {
            return view('public.contact.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function store(ContactRequest $request)
    {
        try {
            Contact::create($request->validated());

            $data = [
                'name' => $request['name'],
                'phone' => $request['phone'],
                'message' => $request['message'],
                'email' => $request['email'],
            ];

            Mail::to('admin@admin.com')->send(new ContactMail($data));

            return response()->json([
                'status' => 'success',
                'message' => 'Your message has been sent successfully!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }
}

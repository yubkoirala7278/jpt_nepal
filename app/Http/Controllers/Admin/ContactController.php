<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $contacts = Contact::latest()->get();
                return DataTables::of($contacts)
                    ->addIndexColumn()
                    ->editColumn('message', function ($contact) {
                        return \Illuminate\Support\Str::limit($contact->message, 30);
                    })
                    ->addColumn('action', function ($contact) {
                        return '
                            <button class="btn btn-primary view-btn" data-id="' . $contact->id . '">View</button>
                            <button class="btn btn-danger delete-btn" data-slug="' . $contact->slug . '">Delete</button>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.contact.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    public function destroy($slug)
    {
        try {
            $contact = Contact::where('slug', $slug)->first();
            if (!$contact) {
                return response()->json(['success' => false, 'message' => 'Contact not found!']);
            }
            $contact->delete();
            return response()->json(['success' => true, 'message' => 'Contact deleted successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            return response()->json(['success' => true, 'contact' => $contact]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}

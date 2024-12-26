<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class NoticeController extends Controller
{
    public function __construct()
    {
        // Only users with 'view' permission can access index and show methods
        $this->middleware('permission:view', ['only' => ['index', 'show']]);
    
        // Only users with 'manage' permission can access other methods
        $this->middleware('permission:manage', ['except' => ['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notices = Notice::select(['id', 'title', 'image', 'slug']);

            return DataTables::of($notices)
                ->addIndexColumn()
                ->editColumn('title', function ($notice) {
                    return \Str::limit($notice->title, 20); // Limit title length
                })
                ->editColumn('image', function ($notice) {
                    return '<img src="' . asset($notice->image) . '" alt="Notice Image" height="30" style="cursor:pointer;" class="notice-image" data-url="' . asset($notice->image) . '">';
                })
                ->addColumn('action', function ($notice) {
                    $user = auth()->user(); // Get the authenticated user
                    $buttons = '
                        <a href="' . route('notice.show', $notice->slug) . '" class="btn btn-primary btn-sm text-white" title="view notice"><i class="fa-solid fa-eye"></i></a>
                    ';
                
                    // Check if the user is an admin
                    if ($user->hasRole('admin')) {
                        $buttons .= '
                            <a href="' . route('notice.edit', $notice->slug) . '" class="btn btn-warning btn-sm text-white" title="edit notice"><i class="fa-solid fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-slug="' . $notice->slug . '" title="delete notice"><i class="fa-solid fa-trash"></i></button>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['image', 'action']) // Handle HTML in 'image' and 'action' columns
                ->make(true);
        }

        return view('admin.notice.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.notice.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoticeRequest $request)
    {
        try {
            // Handle file upload for the image
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs(
                    'public/notice',
                    uniqid() . '.' . $request->file('image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $imagePath = str_replace('public/', 'Storage/', $imagePath);
            }
            // Create the notice record
            Notice::create([
                'title' => $request['title'],
                'image' => $imagePath,
                'description' => $request['description'],
                'author_name' => Auth::user()->name
            ]);
            return redirect()->route('notice.index')->with('success', 'Notice has been created successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        try {
            return view('admin.notice.view', compact('notice'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        try {
            return view('admin.notice.edit', compact('notice'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoticeRequest $request, Notice $notice)
    {
        try {
            // Handle file upload for the notice
            if ($request->hasFile('image')) {
                // Delete the old notice image if it exists
                if ($notice->image && Storage::exists(str_replace('Storage/', 'public/', $notice->image))) {
                    Storage::delete(str_replace('Storage/', 'public/', $notice->image));
                }

                $noticePath = $request->file('image')->storeAs(
                    'public/notice',
                    uniqid() . '.' . $request->file('image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $noticePath = str_replace('public/', 'Storage/', $noticePath);
            } else {
                // Keep the old notice image if no new one is uploaded
                $noticePath = $notice->image;
            }

            // Update the notice record
            $notice->update([
                'title' => $request['title'],
                'image' => $noticePath,
                'description' => $request['description'],
            ]);
            return redirect()->route('notice.index')->with('success', 'Notice has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        try {
            $notice = Notice::where('slug', $slug)->first();
            if ($notice) {
                // Ensure the path is relative to the 'public' disk
                $relativeNoticePath = str_replace('Storage/', 'public/', $notice->image);

                // Delete the notice file if it exists
                if ($notice->image && Storage::exists($relativeNoticePath)) {
                    Storage::delete($relativeNoticePath);
                }

                $notice->delete();
                return response()->json(['status' => 'success', 'message' => 'Notice deleted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Notice not found']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

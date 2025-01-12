<?php

namespace App\Http\Controllers\StaticPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderRequest;
use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $headers = Header::latest()->paginate(10);
            return view('admin.static_pages.header.index', compact('headers'));
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
            return view('admin.static_pages.header.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeaderRequest $request)
    {
        try {
            // Handle file upload for the image
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs(
                    'public/StaticImage',
                    uniqid() . '.' . $request->file('image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $imagePath = str_replace('public/', 'Storage/', $imagePath);
            }

            Header::create([
                'title' => $request['title'],
                'description' => $request['description'],
                'image' => $imagePath
            ]);
            return redirect()->route('header.index')->with('success', 'Header added successfully!');
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
    public function edit(Header $header)
    {
        try {
            return view('admin.static_pages.header.edit', compact('header'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeaderRequest $request, Header $header)
    {
        try {
            $imagePath = $header->image;
    
            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Ensure the path is relative to the 'public' disk
                $relativeImagePath = str_replace('Storage/', 'public/', $header->image);
    
                // Delete the old image file if it exists
                if ($header->image && Storage::exists($relativeImagePath)) {
                    Storage::delete($relativeImagePath);
                }
    
                // Store the new image
                $newImagePath = $request->file('image')->storeAs(
                    'public/StaticImage',
                    uniqid() . '.' . $request->file('image')->getClientOriginalExtension()
                );
    
                // Convert the new path for storage in the database
                $imagePath = str_replace('public/', 'Storage/', $newImagePath);
            }
    
            // Update the header record
            $header->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $imagePath,
            ]);
    
            return redirect()->route('header.index')->with('success', 'Header updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Header $header)
    {
        try {
            // Ensure the path is relative to the 'public' disk
            $relativeImagePath = str_replace('Storage/', 'public/', $header->image);

            // Delete the image file if it exists
            if ($header->image && Storage::exists($relativeImagePath)) {
                Storage::delete($relativeImagePath);
            }

            // Delete the header
            $header->delete();

            return back()->with('success', 'Header deleted successfully!');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

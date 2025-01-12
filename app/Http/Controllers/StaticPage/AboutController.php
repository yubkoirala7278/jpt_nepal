<?php

namespace App\Http\Controllers\StaticPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutRequest;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $abouts = About::latest()->paginate(10);
            return view('admin.static_pages.about.index', compact('abouts'));
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
            return view('admin.static_pages.about.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutRequest $request)
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

            About::create([
                'title' => $request['title'],
                'sub_title' => $request['sub_title'],
                'description' => $request['description'],
                'image' => $imagePath
            ]);
            return redirect()->route('about.index')->with('success', 'Data added successfully!');
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
    public function edit(About $about)
    {
        try {
            return view('admin.static_pages.about.edit', compact('about'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutRequest $request, About $about)
    {
        try {
            $imagePath = $about->image;
    
            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Ensure the path is relative to the 'public' disk
                $relativeImagePath = str_replace('Storage/', 'public/', $about->image);
    
                // Delete the old image file if it exists
                if ($about->image && Storage::exists($relativeImagePath)) {
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
    
            // Update the about record
            $about->update([
                'title' => $request->input('title'),
                'sub_title' => $request->input('sub_title'),
                'description' => $request->input('description'),
                'image' => $imagePath,
            ]);
    
            return redirect()->route('about.index')->with('success', 'Data updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        try {
            // Ensure the path is relative to the 'public' disk
            $relativeImagePath = str_replace('Storage/', 'public/', $about->image);

            // Delete the image file if it exists
            if ($about->image && Storage::exists($relativeImagePath)) {
                Storage::delete($relativeImagePath);
            }

            // Delete the about
            $about->delete();

            return back()->with('success', 'Data deleted successfully!');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

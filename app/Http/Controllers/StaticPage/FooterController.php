<?php

namespace App\Http\Controllers\StaticPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\FooterRequest;
use App\Models\Footer;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $footers = Footer::latest()->paginate(10);
            return view('admin.static_pages.footer.index', compact('footers'));
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
            return view('admin.static_pages.footer.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FooterRequest $request)
    {
        try {
            Footer::create([
                'location' => $request['location'],
                'description' => $request['description'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'facebook_link'=>$request['facebook_link'],
                'twitter_link'=>$request['twitter_link'],
                'whatsapp_link'=>$request['whatsapp_link']
            ]);
            return redirect()->route('footer.index')->with('success', 'Footer added successfully!');
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
    public function edit(Footer $footer)
    {
        try {
            return view('admin.static_pages.footer.edit', compact('footer'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FooterRequest $request, Footer $footer)
    {
        try {
            // Update the footer record
            $footer->update([
                'location' => $request['location'],
                'description' => $request['description'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'facebook_link'=>$request['facebook_link'],
                'twitter_link'=>$request['twitter_link'],
                'whatsapp_link'=>$request['whatsapp_link']
            ]);
    
            return redirect()->route('footer.index')->with('success', 'Footer updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Footer $footer)
    {
        try {
            // Delete the footer
            $footer->delete();

            return back()->with('success', 'Footer deleted successfully!');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

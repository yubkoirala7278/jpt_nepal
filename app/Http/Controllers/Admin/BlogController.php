<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::select(['id', 'title', 'image', 'slug','status']);

            return DataTables::of($blogs)
                ->addIndexColumn()
                ->editColumn('image', function ($blog) {
                    return '<img src="' . asset($blog->image) . '" alt="Blog Image" height="30" style="cursor:pointer;" class="blog-image" data-url="' . asset($blog->image) . '">';
                })
                ->editColumn('status', function ($blog) {
                    if ($blog->status === 'active') {
                        return '<span class="badge bg-success">Active</span>';
                    }
                    return '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($blog) {
                    $user = auth()->user(); // Get the authenticated user
                    $buttons = '
                        <a href="' . route('blog.show',$blog->slug) . '" class="btn btn-primary btn-sm text-white" title="view blog"><i class="fa-solid fa-eye"></i></a>
                    ';
                
                    // Check if the user is an admin
                    if ($user->hasRole('admin')) {
                        $buttons .= '
                            <a href="' . route('blog.edit', $blog->slug) . '" class="btn btn-warning btn-sm text-white" title="edit blog"><i class="fa-solid fa-pencil"></i></a>
                            <button class="btn btn-danger btn-sm delete-btn" data-slug="' . $blog->slug . '" title="delete blog"><i class="fa-solid fa-trash"></i></button>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['image', 'action','status']) // Handle HTML in 'image' and 'action' columns
                ->make(true);
        }

        return view('admin.blog.index');
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.blog.create');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            // Handle file upload for the image
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs(
                    'public/blog',
                    uniqid() . '.' . $request->file('image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $imagePath = str_replace('public/', 'Storage/', $imagePath);
            }
            // Create the blog record
            Blog::create([
                'title' => $request['title'],
                'image' => $imagePath,
                'description' => $request['description'],
                'status'=>$request['status']
            ]);
            return redirect()->route('blog.index')->with('success', 'Blog has been created successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        try {
            $blog=Blog::where('slug',$slug)->first();
            if(!$blog){
                return back()->with('error','Blog not found!');
            }
            return view('admin.blog.view', compact('blog'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        try {
            $blog=Blog::where('slug',$slug)->first();
            if(!$blog){
                return back()->with('error','Blog not found!');
            }
            return view('admin.blog.edit', compact('blog'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, $slug)
    {
        try {
            $blog=Blog::where('slug',$slug)->first();
            if(!$blog){
                return back()->with('error','Blog not found!');
            }
            // Handle file upload for the blog
            if ($request->hasFile('image')) {
                // Delete the old blog image if it exists
                if ($blog->image && Storage::exists(str_replace('Storage/', 'public/', $blog->image))) {
                    Storage::delete(str_replace('Storage/', 'public/', $blog->image));
                }

                $blogPath = $request->file('image')->storeAs(
                    'public/blog',
                    uniqid() . '.' . $request->file('image')->getClientOriginalExtension()
                );
                // Replace 'public/' with 'Storage/' to store the desired path in the database
                $blogPath = str_replace('public/', 'Storage/', $blogPath);
            } else {
                // Keep the old blog image if no new one is uploaded
                $blogPath = $blog->image;
            }

            // Update the blog record
            $blog->update([
                'title' => $request['title'],
                'image' => $blogPath,
                'description' => $request['description'],
                'status'=>$request['status']
            ]);
            return redirect()->route('blog.index')->with('success', 'Blog has been updated successfully!');
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
            $blog = Blog::where('slug', $slug)->first();
            if ($blog) {
                // Ensure the path is relative to the 'public' disk
                $relativeBlogPath = str_replace('Storage/', 'public/', $blog->image);

                // Delete the blog file if it exists
                if ($blog->image && Storage::exists($relativeBlogPath)) {
                    Storage::delete($relativeBlogPath);
                }

                $blog->delete();
                return response()->json(['status' => 'success', 'message' => 'Blog deleted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Blog not found']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

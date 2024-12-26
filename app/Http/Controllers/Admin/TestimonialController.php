<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Testimonial::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('description', function ($row) {
                        return strlen($row->description) > 30 ? substr($row->description, 0, 30) . '...' : $row->description;
                    })
                    ->addColumn('status', function ($row) {
                        // Check the status value and return the corresponding badge
                        if ($row->status == 1) {
                            return '<span class="badge text-bg-success">Publish</span>';
                        } else {
                            return '<span class="badge text-bg-secondary">Unpublished</span>'; // Adjust for other status values
                        }
                    })
                    ->addColumn('action', function ($row) {
                        return '
                            <div class="d-flex align-items-center" style="column-gap:10px">
                                <button type="button" class="btn btn-warning text-white btn-sm edit-btn" data-slug="' . $row->slug . '" title="edit testimonial"><i class="fa-solid fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-url="' . route('testimonial.destroy', $row->slug) . '" title="delete testimonial"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                    })
                    ->rawColumns(['status', 'action']) // Make sure to include 'status' here
                    ->make(true);
            }
            return view('admin.testimonial.index');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request)
    {
        try {
            Testimonial::create($request->validated());
            return response()->json(['success' => 'Testimonial has been created successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // Show the form for editing the specified resource.
    public function edit($slug)
    {
        try {
            $testimonial = Testimonial::where('slug', $slug)->firstOrFail(); // Find testimonial by slug
            return response()->json(['data' => $testimonial]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Testimonial not found'], 404); // Return error if not found
        }
    }

    // Update the specified testimonial
    public function update(TestimonialRequest $request, $id)
    {
        try {
            // Fetch the testimonial by slug
            $testimonial = Testimonial::find($id);

            // Update testimonial with validated data from the request
            $testimonial->update($request->validated());

            return response()->json(['success' => 'Testimonial has been updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to update testimonial. Please try again later.'], 500); // Return error if update fails
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        try {
            $testimonial = Testimonial::where('slug', $slug)->firstOrFail();
            $testimonial->delete();
            return response()->json(['success' => 'Testimonial has been deleted successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}

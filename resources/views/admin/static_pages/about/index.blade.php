@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>About</h2>
        <a class="btn btn-secondary btn-sm" href="{{route('about.create')}}">Add New</a>
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover pt-3 w-100" id="studentsTable" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Sub Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($abouts)>0)
                    @foreach ($abouts as $key=>$about)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ \Illuminate\Support\Str::limit($about->title, 30) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($about->sub_title, 30) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($about->description, 30) }}</td>
                        <td><img src="{{asset($about->image)}}" alt="About Image" height="30" loading="lazy"></td>
                        <td>
                            <form action="{{ route('about.destroy', $about->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?');" class=" d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <a href="{{route('about.edit',$about->slug)}}" class="btn btn-warning d-inline">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr class="text-center">
                    <td colspan="20">No data to display..</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{$abouts->links('pagination::bootstrap-5')}}
    </div>
@endsection




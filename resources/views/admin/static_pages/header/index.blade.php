@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Headers</h2>
        <a class="btn btn-secondary btn-sm" href="{{route('header.create')}}">Add New</a>
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover pt-3 w-100" id="studentsTable" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($headers)>0)
                    @foreach ($headers as $key=>$header)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ \Illuminate\Support\Str::limit($header->title, 30) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($header->description, 30) }}</td>
                        <td><img src="{{asset($header->image)}}" alt="Header Image" height="30" loading="lazy"></td>
                        <td>
                            <form action="{{ route('header.destroy', $header->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this header?');" class=" d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ">Delete</button>
                            </form>
                            <a href="{{route('header.edit',$header->slug)}}" class="btn btn-warning  d-inline">Edit</a>
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
        {{$headers->links('pagination::bootstrap-5')}}
    </div>
@endsection




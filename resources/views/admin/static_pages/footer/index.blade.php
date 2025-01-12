@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Footer</h2>
        <a class="btn btn-secondary btn-sm" href="{{route('footer.create')}}">Add New</a>
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover pt-3 w-100" id="studentsTable" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>location</th>
                    <th>description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($footers)>0)
                    @foreach ($footers as $key=>$footer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$footer->phone}}</td>
                        <td>{{$footer->email}}</td>
                        <td>{{$footer->location}}</td>
                        <td>{{ \Illuminate\Support\Str::limit($footer->description, 30) }}</td>
                        <td>
                            <form action="{{ route('footer.destroy', $footer->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this footer?');" class=" d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ">Delete</button>
                            </form>
                            <a href="{{route('footer.edit',$footer->slug)}}" class="btn btn-warning  d-inline">Edit</a>
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
        {{$footers->links('pagination::bootstrap-5')}}
    </div>
@endsection




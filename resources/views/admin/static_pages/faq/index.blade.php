@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Faq's</h2>
        <a class="btn btn-secondary btn-sm" href="{{route('faq.create')}}">Add New</a>
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover pt-3 w-100" id="studentsTable" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($faqs)>0)
                    @foreach ($faqs as $key=>$faq)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ \Illuminate\Support\Str::limit($faq->question, 30) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($faq->answer, 30) }}</td>
                        <td>
                            <form action="{{ route('faq.destroy', $faq->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this faq?');" class=" d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ">Delete</button>
                            </form>
                            <a href="{{route('faq.edit',$faq->slug)}}" class="btn btn-warning  d-inline">Edit</a>
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
        {{$faqs->links('pagination::bootstrap-5')}}
    </div>
@endsection




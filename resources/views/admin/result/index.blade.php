@extends('admin.layouts.master')

@section('content')
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <h2>Applicant Results</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importResults">
            Import Result
        </button>

    </div>

    <div class="table-responsive"> <!-- Wrapper for horizontal scroll -->
        <table class="table admit-card-datatable table-hover pt-3">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone No.</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Registration Number</th>
                    <th>Marks</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @if(count($students)>0)
                    @foreach ($students as $key=>$student)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$student->name}}</td>
                        <td>{{$student->address}}</td>
                        <td>{{$student->phone}}</td>
                        <td>{{$student->dob}}</td>
                        <td>{{$student->email}}</td>
                        <td>{{$student->slug}}</td>
                        <td>{{$student->results->marks}}</td>
                        <td>{{$student->results->result}}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    {{-- import results --}}
    <div class="modal fade" id="importResults" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="importResultsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('results.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="importResultsLabel">Import Results</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@push('script')
@endpush

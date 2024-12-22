@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Applicants</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('student.create') }}">Add New</a>
    </div>
    <table class="table exam-date-datatable table-hover pt-3">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Address</th>
                <th>Profile</th>
                <th>Phone Number</th>
                <th>DOB</th>
                <th>Email</th>
                <th>Receipt</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('modal')

@endsection

@push('script')
 
@endpush

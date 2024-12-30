@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Transactions</h2>
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover pt-3 w-100" id="studentsTable" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Consultancy Name</th>
                    <th>Consultancy Address</th>
                    <th>Phone Number</th>
                    <th>Amount</th>
                    <th>Exam Date</th>
                    <th>Registration No.</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated by Yajra DataTables -->
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total Students:</strong> {{ $totalStudents }}</td>
                    <td colspan="5"><strong>Total Amount:</strong> {{ $totalAmount }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#studentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('transaction') }}',  // AJAX request to the same route
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },  // S.N column
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'consultancy_name', name: 'consultancy_name' },
                { data: 'consultancy_address', name: 'consultancy_address' },
                { data: 'phone', name: 'phone' },
                { data: 'amount', name: 'amount' },
                { data: 'exam_date', name: 'exam_date' },
                { data: 'slug', name: 'slug' },
            ],
            order: [[1, 'desc']]  // Sorting by first column (S.N)
        });
    });
</script>
@endpush

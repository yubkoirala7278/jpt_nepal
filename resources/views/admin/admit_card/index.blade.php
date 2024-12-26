@extends('admin.layouts.master')

@section('content')
    <div class="mb-3">
        <h2>Admit Card</h2>
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
                    <th>Admit Card</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded via Yajra DataTables -->
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
   
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Initialize the DataTable
        $('.admit-card-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.admit-card") }}', // Your route to fetch the data
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'phone', name: 'phone' },
                { data: 'dob', name: 'dob' },
                { data: 'email', name: 'email' },
                { data: 'admit_card', name: 'admit_card', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush

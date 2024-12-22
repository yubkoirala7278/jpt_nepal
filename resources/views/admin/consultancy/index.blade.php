@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Consultancy</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('consultancy.create') }}">Add New</a>
    </div>
    <table class="table consultancy-datatable table-hover pt-3">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Phone No.</th>
                <th>Address</th>
                <th>Email</th>
                <th>Logo</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('modal')
    <!-- Displaying logo in modal -->
    <div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoModalLabel">Logo Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Modal image -->
                    <img id="modal-logo" src="" alt="Logo Preview" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            // =======display all the consultancy in table==========
            $(document).ready(function() {
                $('.consultancy-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('consultancy.index') }}",
                        data: function(d) {
                            d.search = $('input[type="search"]').val(); // Pass search query
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'user_name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'address',
                            name: 'address',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'email',
                            name: 'user_email',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'logo',
                            name: 'logo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [6, 'desc']
                    ] // Default sorting by 'created_at' column
                });
            });


            // ======end of displaying all the consultancy in table======

            // ========delete consultancy=============
            $(document).on('click', '.delete-btn', function() {
                let url = $(this).data('url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}' // Include CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.success,
                                        'success'
                                    );
                                    $('.consultancy-datatable').DataTable().ajax
                                        .reload(); // Reload DataTable
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.error,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON?.error ||
                                    'An unknown error occurred.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            // ======end of deleting consultancy========

            // =======displaying logo in modal============
            $(document).on('click', '.logo-image', function() {
                var logoUrl = $(this).data('url'); // Get the image URL from data-url attribute
                $('#modal-logo').attr('src', logoUrl); // Set the image source in the modal
                $('#logoModal').modal('show'); // Show the modal
            });
            // ======end of displaying logo in modal========
        });
    </script>
@endpush

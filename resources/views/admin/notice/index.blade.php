@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>News & Notice</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('notice.create') }}">Add New</a>
    </div>

    <div class="table-responsive">
        <table class="table notice-datatable table-hover pt-3">
            <thead>
                <tr>
                    <th>S.N:</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated via DataTables -->
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
   <!-- Modal for Image Preview -->
<div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noticeModalLabel">Notice Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Modal Image -->
                <img id="modal-notice" src="" alt="Notice Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize DataTable with AJAX
            var table = $('.notice-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('notice.index') }}", // Data source URL
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Handle delete with SweetAlert2
            $(document).on('click', '.delete-btn', function() {
                var slug = $(this).data('slug');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform delete via AJAX
                        $.ajax({
                            url: '/admin/notice/' + slug,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your notice has been deleted.',
                                        'success'
                                    );
                                    table.ajax
                                        .reload(); // Reload DataTable after delete
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong!',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            //display image in modal
            $(document).on('click', '.notice-image', function() {
                var noticeUrl = $(this).data('url'); // Get the image URL from the data-url attribute
                $('#modal-notice').attr('src', noticeUrl); // Set the image source in the modal
                var myModal = new bootstrap.Modal(document.getElementById(
                'noticeModal')); // Initialize the modal
                myModal.show(); // Show the modal
            });
        });
    </script>
@endpush

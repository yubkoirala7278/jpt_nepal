@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Contact</h2>
    </div>

    <div class="table-responsive">
        <table class="table contact-datatable table-hover pt-3 w-100">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No.</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('modal')
    {{-- contact detail modal --}}
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Contact Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="contact-name"></span></p>
                    <p><strong>Email:</strong> <span id="contact-email"></span></p>
                    <p><strong>Phone:</strong> <span id="contact-phone"></span></p>
                    <p><strong>Message:</strong> <span id="contact-message"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var table = $('.contact-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.contact") }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'message',
                        name: 'message'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // View Button Click
            $(document).on('click', '.view-btn', function() {
                let contactId = $(this).data('id');

                $.ajax({
                    url: `/admin/contact/${contactId}`,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#contact-name').text(response.contact.name);
                            $('#contact-email').text(response.contact.email);
                            $('#contact-phone').text(response.contact.phone);
                            $('#contact-message').text(response.contact.message);
                            $('#viewModal').modal('show');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Unable to fetch contact details.', 'error');
                    }
                });
            });

            // Delete Button Click
            $(document).on('click', '.delete-btn', function() {
                let slug = $(this).data('slug');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/contact/' + slug,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message, 'success');
                                    table.ajax.reload();
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'An error occurred.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

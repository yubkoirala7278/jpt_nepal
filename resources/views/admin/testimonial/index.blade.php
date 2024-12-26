@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Testimonial</h2>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addTestimonial"
            id="addTestimonialModal">
            Add
        </button>

    </div>
    <table class="table testimonial-datatable table-hover pt-3">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('modal')
    {{-- Add Testimonial Modal --}}
    <div class="modal fade" id="addTestimonial" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addTestimonialLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTestimonialLabel">Add Testimonial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createTestimonialForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe">
                            <div id="name_error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Description" id="description" name="description" rows="6"></textarea>
                            <div id="description_error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <div id="status_error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createTestimonial">Create</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Testimonial Modal --}}
    <div class="modal fade" id="editTestimonial" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editTestimonialLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTestimonialLabel">Edit Testimonial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTestimonialForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="testimonial_id" name="id">
                        <div class="mb-3">
                            <label for="name_edit" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name_edit" name="name">
                            <div id="name_error_edit" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="description_edit" class="form-label">Description</label>
                            <textarea class="form-control" id="description_edit" name="description" rows="6"></textarea>
                            <div id="description_error_edit" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="status_edit" class="form-label">Status</label>
                            <select class="form-select" id="status_edit" name="status">
                                <option selected disabled>Select Status</option>
                                <option value="1">Publish</option>
                                <option value="0">Draft</option>
                            </select>
                            <div id="status_error_edit" class="invalid-feedback" style="display: none;"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editTestimonialButton">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('.testimonial-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('testimonial.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Clear form fields when the modal opens
            $('#addTestimonial').on('show.bs.modal', function() {
                // Clear all the input fields
                $('#name').val('');
                $('#description').val('');
            });

            // Ajax request to create testimonial
            $('#createTestimonial').click(function(e) {
                e.preventDefault();

                var formData = {
                    name: $('#name').val(),
                    description: $('#description').val(),
                    status: $('#status').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: '{{ route('testimonial.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addTestimonial').modal('hide');
                        Swal.fire('Created!', response.success, 'success');
                        table.draw();
                    },
                    error: function(xhr) {
                        handleFormErrors(xhr, '#addTestimonial');
                    }
                });
            });


            // =========Delete Testimonial==========
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
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.success, 'success');
                                    table.draw();
                                } else {
                                    Swal.fire('Error!', response.error, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'An unknown error occurred.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // ===========edit testimonial============
            $(document).on('click', '.edit-btn', function() {
                var slug = $(this).data('slug'); // Get the slug from the data attribute
                // Clear all input fields and error messages
                $('#name_edit').val('');
                $('#description_edit').val('');
                $('#status_edit').val('');
                $('.invalid-feedback').hide().text(''); // Hide any previous error messages
                $('input, select').removeClass(
                'is-invalid'); // Remove 'is-invalid' class from all input fields

                $.ajax({
                    url: '/admin/testimonial/' + slug + '/edit', // URL to fetch the edit form
                    type: 'GET',
                    success: function(response) {
                        if (response.data) {
                            // Populate the modal fields with data
                            $('#testimonial_id').val(response.data.id);
                            $('#name_edit').val(response.data.name);
                            $('#description_edit').val(response.data.description);
                            $('#status_edit').val(response.data.status);

                            // Show the modal
                            $('#editTestimonial').modal('show');
                        } else {
                            alert('Failed to load testimonial data');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching the testimonial data');
                    }
                });
            });

            $('#editTestimonialButton').click(function() {
                var formData = $('#editTestimonialForm').serialize(); // Serialize form data

                $.ajax({
                    url: '/admin/testimonial/' + $('#testimonial_id')
                    .val(), // Dynamic route based on exam ID
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Updated!',
                                response.success,
                                'success'
                            );
                            $('#editTestimonial').modal('hide'); // Close the modal
                            // Optionally, you can reload or update the table
                            table
                        .draw(); // Assuming you are using DataTables for displaying testimonials
                        } else {
                            // Handle success message or further processing if needed
                            alert(response.success);
                        }
                    },
                    error: function(xhr) {
                        // Clear existing error messages
                        $('.invalid-feedback').hide().text('');
                        $('input, select').removeClass(
                        'is-invalid'); // Remove invalid class from all input fields

                        // Handle validation errors
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (let field in errors) {
                                let errorMessages = errors[field].join(', ');

                                // Find the input's corresponding error message div and display the error
                                $(`#${field}_edit`).addClass('is-invalid');
                                $(`#${field}_error_edit`).text(errorMessages).show();
                            }
                        } else {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.error || 'An unknown error occurred.',
                                'error'
                            );
                        }
                    }
                });
            });


            // Handle form validation errors
            function handleFormErrors(xhr, modalId) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    Object.keys(errors).forEach(function(key) {
                        $('#' + key + '_error').text(errors[key][0]).show();
                        $('#' + key).addClass('is-invalid');
                    });
                }
            }
        });
    </script>
@endpush

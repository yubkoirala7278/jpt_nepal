@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Exam Date</h2>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addExamDate"
            id="addExamDateModal">
            Add
        </button>

    </div>
    <table class="table exam-date-datatable table-hover pt-3">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Exam Date</th>
                <th>Exam Duration</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('modal')
    {{-- add exam date modal --}}
    <div class="modal fade" id="addExamDate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addExamDateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addExamDateLabel">Add Exam Date</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exam_date" class="form-label">Exam Date</label>
                            <input type="date" class="form-control" id="exam_date" name="exam_date">
                            <!-- Error message container for exam_date -->
                            <div id="exam_date_error" class="invalid-feedback d-block" style="display: none;"></div>
                        </div>

                        <div class="mb-3">
                            <label for="exam_start_time" class="form-label">Exam Duration</label>
                            <div class="d-flex align-items-center">
                                <input type="time" class="form-control me-2" id="exam_start_time" name="exam_start_time"
                                    placeholder="Start Time">
                                <span class="mx-2">to</span>
                                <input type="time" class="form-control" id="exam_end_time" name="exam_end_time"
                                    placeholder="End Time">
                            </div>
                            <!-- Error Message for exam_start_time -->
                            <div id="exam_start_time_error" class="invalid-feedback d-block" style="display: none;"></div>
                            <!-- Error Message for exam_end_time -->
                            <div id="exam_end_time_error" class="invalid-feedback d-block" style="display: none;"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createExamDate">Create</button>
                </div>
            </div>
        </div>
    </div>

    {{-- edit exam date --}}
    <div class="modal fade" id="editExamDate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editExamDateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editExamDateLabel">Edit Exam Date</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editExamDateForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="" id="exam_id">
                        <div class="mb-3">
                            <label for="exam_date" class="form-label">Exam Date</label>
                            <input type="date" class="form-control" id="exam_date_edit" name="exam_date">
                            <div id="exam_date_error_edit" class="invalid-feedback d-block" style="display: none;"></div>
                        </div>

                        <div class="mb-3">
                            <label for="exam_start_time" class="form-label">Exam Duration</label>
                            <div class="d-flex align-items-center">
                                <input type="time" class="form-control me-2" id="exam_start_time_edit"
                                    name="exam_start_time">
                                <span class="mx-2">to</span>
                                <input type="time" class="form-control" id="exam_end_time_edit" name="exam_end_time">
                            </div>
                            <div id="exam_start_time_error_edit" class="invalid-feedback d-block" style="display: none;">
                            </div>
                            <div id="exam_end_time_error_edit" class="invalid-feedback d-block" style="display: none;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editExamDateButton">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            // ======displaying exam dates===============
            var table = $('.exam-date-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('exam_date.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'exam_date',
                        name: 'exam_date'
                    },
                    {
                        data: 'exam_duration',
                        name: 'exam_duration',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]

            });

            // =========end of displaying exam dates=====


            // ==========create exam date==============
            $('#addExamDateModal').click(function(e) {
                // Clear all input fields and error messages
                $('#exam_date').val('');
                $('#exam_start_time').val('');
                $('#exam_end_time').val('');
                $('.invalid-feedback').hide().text(''); // Hide any previous error messages
                $('input').removeClass('is-invalid'); // Remove 'is-invalid' class from all input fields
            });

            $('#createExamDate').click(function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.text-danger').remove();

                // Gather form data
                let data = {
                    exam_date: $('#exam_date').val(),
                    exam_start_time: $('#exam_start_time').val(),
                    exam_end_time: $('#exam_end_time').val(),
                    _token: '{{ csrf_token() }}'
                };

                // Send AJAX request
                $.ajax({
                    url: '{{ route('exam_date.store') }}',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        $("#addExamDate").modal('hide');
                        if (response.success) {
                            Swal.fire(
                                'Created!',
                                response.success,
                                'success'
                            );
                            table.draw();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.error,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        // Clear existing error messages
                        $('.invalid-feedback').hide().text('');
                        $('input').removeClass(
                            'is-invalid'); // Remove invalid class from all input fields

                        // Handle validation errors
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (let field in errors) {
                                let errorMessages = errors[field].join(', ');

                                // Find the input's corresponding error message div and display the error
                                $(`#${field}`).addClass('is-invalid');
                                $(`#${field}_error`).text(errorMessages).show();
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
            // =======end of creating exam date==========


            // =========delete exam date===========
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
                                    table.draw();
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
            // ========end of deleting exam date====

            // =============update exam date=============
            $(document).on('click', '.edit-btn', function() {
                var examSlug = $(this).data('slug'); // Get the slug from the data attribute
                // Clear all input fields and error messages
                $('#exam_date_edit').val('');
                $('#exam_start_time_edit').val('');
                $('#exam_end_time_edit').val('');
                $('.invalid-feedback').hide().text(''); // Hide any previous error messages
                $('input').removeClass('is-invalid'); // Remove 'is-invalid' class from all input fields


                $.ajax({
                    url: '/admin/exam_date/' + examSlug + '/edit', // URL to fetch the edit form
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Populate the modal fields with data
                            $('#exam_id').val(response.data.id);
                            $('#exam_date_edit').val(response.data.exam_date);
                            $('#exam_start_time_edit').val(response.data
                            .exam_start_time); // The formatted time
                            $('#exam_end_time_edit').val(response.data
                            .exam_end_time); // The formatted time

                            // Show the modal
                            $('#editExamDate').modal('show');
                        } else {
                            alert('Failed to load exam data');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching the exam data');
                    }
                });
            });


            $('#editExamDateButton').click(function() {
                var formData = $('#editExamDateForm').serialize(); // Serialize form data

                $.ajax({
                    url: '/admin/exam_date/' + $('#exam_id')
                        .val(), // Dynamic route based on exam ID
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Updated!',
                                response.message,
                                'success'
                            );
                            $('#editExamDate').modal('hide'); // Close the modal
                            table.draw();
                        } else {
                            // Handle validation errors (optional)
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Clear existing error messages
                        $('.invalid-feedback').hide().text('');
                        $('input').removeClass(
                        'is-invalid'); // Remove invalid class from all input fields

                        // Handle validation errors
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (let field in errors) {
                                let errorMessages = errors[field].join(', ');

                                // Find the input's corresponding error message div and display the error
                                $(`#${field}`).addClass('is-invalid');
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
            // =========end of updating exam date===========
        });
    </script>
@endpush

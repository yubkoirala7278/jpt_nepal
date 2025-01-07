@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Test Centers</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('test_center.create') }}">Add New</a>
    </div>
    <div class="table-responsive">
        <table class="table test-center-datatable table-hover pt-3 w-100">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Phone No.</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                    {{-- <th>Dashboard</th> --}}
                </tr>
            </thead>
            <tbody style="vertical-align: middle"></tbody>
        </table>
    </div>
@endsection

@section('modal')
    {{-- disable test center --}}
    <div class="modal fade" id="disableModal" tabindex="-1" role="dialog" aria-labelledby="disableModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="disableForm">
                @csrf
                <input type="hidden" name="slug" id="testCenterSlug">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="disableModalLabel">Disable Test Center</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label for="disabled_reason">Disabled Reason</label>
                                <span id="charCount">0/350</span>
                            </div>
                            <textarea id="disabled_reason" name="reason" class="form-control" rows="6" maxlength="350"
                                placeholder="Disabled reason.."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Disable</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Consultancies Modal -->
    <div class="modal fade" id="consultanciesModal" tabindex="-1" aria-labelledby="consultanciesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="consultanciesModalLabel">Consultancies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="consultanciesList">
                        <!-- Dynamic content will be loaded here -->
                    </div>
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
        $(function() {
            // =======display all the test center in table==========
            $(document).ready(function() {
                $('.test-center-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    searchDelay: 1000, // Delay search for 1000ms
                    ajax: {
                        url: "{{ route('test_center.index') }}",
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
                            data: 'created_at',
                            name: 'created_at',
                            orderable: true,
                            searchable: true
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
                        },
                        // {
                        //     data: 'dashboard',
                        //     name: 'dashboard',
                        // }
                    ],
                    order: [
                        [6, 'desc']
                    ] // Default sorting by 'created_at' column
                });
            });

            // ======end of displaying all the test center in table======

            // =========disable test center=========================
            // Handle the button click for disabling the test center
            $(document).on('click', '.disable-btn', function() {
                var slug = $(this).data('slug');
                $('#testCenterSlug').val(slug); // Set the slug value in the hidden input
                $('#disableModal').modal('show'); // Show the modal
                $('#disabled_reason').val(''); // Clear the textarea
                $('#charCount').text('0/350'); // Reset character count
            });

            // Handle the button click for enabling the test center
            $(document).on('click', '.enable-btn', function() {
                var slug = $(this).data('slug');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to enable this test center?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, enable it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('enable.test_center') }}', // Post route for enabling test center
                            method: 'POST',
                            data: {
                                slug: slug,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });

                                $('.test-center-datatable').DataTable().ajax
                                    .reload(); // Reload data table
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred: ' + error,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });

            // Handle the form submission inside the modal
            $('#disableForm').on('submit', function(e) {
                e.preventDefault();

                var reason = $('#disabled_reason').val();
                var disableButton = $('#disableForm button[type="submit"]');

                if (reason === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Disabled reason is required.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                var formData = $(this).serialize();

                disableButton.prop('disabled', true).text('Disabling...');

                $.ajax({
                    url: '{{ route('disable.test_center') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#disableModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });

                        $('.test-center-datatable').DataTable().ajax.reload();
                        disableButton.prop('disabled', false).text('Disable');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                            confirmButtonText: 'OK'
                        });

                        disableButton.prop('disabled', false).text('Disable');
                    }
                });
            });

            // Real-time character counting and limit enforcement
            $('#disabled_reason').on('input', function() {
                var charCount = $(this).val().length;
                var maxLength = 350;

                // Update the character count
                $('#charCount').text(charCount + '/' + maxLength);

                // Enforce the character limit
                if (charCount > maxLength) {
                    $(this).val($(this).val().substring(0,
                        maxLength)); // Truncate the text if over 350 characters
                    $('#charCount').text(maxLength + '/' +
                        maxLength); // Show max count if limit is exceeded
                }
            });

            // ========end of disabling test center===================

            // ========delete test center=============
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
                                    $('.test-center-datatable').DataTable().ajax
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
            // ======end of deleting test center========


            // ========view consultancies=============
            $(document).on('click', '.view-dashboard', function() {
                const testCenterId = $(this).data('id');
                const modal = $('#consultanciesModal');
                const consultanciesList = $('#consultanciesList');

                // Clear previous content
                consultanciesList.html('<p>Loading...</p>');

                // Fetch consultancies via AJAX
                $.ajax({
                    url: "{{ route('test_center.consultancies') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        test_center_id: testCenterId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            let content = '';

                            response.consultancies.forEach(consultancy => {
                                // Add consultancy name
                                content +=
                                    `<h5 class=" fw-bold bg-success p-2 text-white rounded-2">${consultancy.user.name}</h5>`;

                                // Check if there are students
                                if (consultancy.students.length > 0) {
                                    // Initialize counters for active and inactive students
                                    let activeCount = 0;
                                    let inactiveCount = 0;

                                    // Start the table
                                    content +=
                                        '<table class="table table-bordered"><thead><tr><th>Student Name</th><th>Phone</th><th>Email</th><th>Nationality</th><th>Status</th></tr></thead><tbody>';

                                    consultancy.students.forEach(student => {
                                        content += `
                                <tr>
                                    <td>${student.name}</td>
                                    <td>${student.phone}</td>
                                    <td>${student.email}</td>
                                    <td>${student.nationality}</td>
                                    <td>
                                        <span class="badge ${student.status ? 'bg-success' : 'bg-warning'}">
                                            ${student.status ? 'Active' : 'Pending'}
                                        </span>
                                    </td>
                                </tr>
                            `;

                                        // Increment active or inactive count based on student status
                                        if (student.status) {
                                            activeCount++;
                                        } else {
                                            inactiveCount++;
                                        }
                                    });

                                    // Close the table
                                    content += '</tbody></table>';

                                    // Add total active and inactive counts
                                    content += `
                            <p><strong>Total Active Students:</strong> ${activeCount}</p>
                            <p><strong>Total Pending Students:</strong> ${inactiveCount}</p>
                        `;
                                } else {
                                    // If no students found, show a message
                                    content +=
                                        `<p>No students found for this consultancy.</p>`;
                                }
                            });

                            // Insert the content into the modal body
                            $('#consultanciesList').html(content);
                        } else {
                            $('#consultanciesList').html('<p>No consultancies found.</p>');
                        }
                    },
                    error: function() {
                        consultanciesList.html('<p>An error occurred while fetching data.</p>');
                    }
                });

                // Show the modal
                modal.modal('show');
            });


            // =====end of viewing consultancies=========

        });
    </script>
@endpush

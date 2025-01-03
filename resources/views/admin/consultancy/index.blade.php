@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Consultancy</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('consultancy.create') }}">Add New</a>
    </div>

    <div class="table-responsive"> <!-- Wrapper for horizontal scroll -->
        <table class="table consultancy-datatable table-hover pt-3 w-100">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Phone No.</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Created At</th>
                    <th>Test Center Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
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
    <!-- Modal for disabling consultancy -->
    <div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="disableModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disableModalLabel">Disable Consultancy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="disableForm">
                        @csrf
                        <input type="hidden" id="consultancySlug" name="slug">
                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label for="disabled_reason">Disabled Reason</label>
                                <span id="charCount">0/350</span>
                            </div>
                            <textarea id="disabled_reason" name="reason" class="form-control" rows="6" maxlength="350" placeholder="Disabled reason.."></textarea>
                        </div>
                        <div class="d-flex mt-3 justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Disable</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $(document).ready(function() {
                // =======display all the consultancy in table==========
                $('.consultancy-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    searchDelay: 1000,
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
                            data: 'test_center', // Column for test center name
                            name: 'test_center_name', // Alias defined in the controller
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
                        }
                    ],
                    order: [
                        [6, 'desc']
                    ], // Default sorting by 'created_at' column

                    // Conditionally hide the 'test_center_name' column if the user is a 'consultancy_manager'
                    initComplete: function() {
                        if ("{{ Auth::user()->hasRole('test_center_manager') }}") {
                            this.api().column(7).visible(
                                false); // Hide the 'test_center_name' column (index 7)
                        }
                    }
                });
                // ======end of displaying all the consultancy in table======

                // ========disable consultancy=============
                // Handle Disabled Button Click
                // Handle Disabled Button Click
                $(document).on('click', '.disabled-btn', function() {
                    var slug = $(this).data('slug');
                    $('#consultancySlug').val(slug); // Set the slug value in the hidden input
                    $('#disableModal').modal('show'); // Show the modal
                    $('#disabled_reason').val(''); // Clear the textarea
                    $('#charCount').text('0/350'); // Reset character count
                });

                // Handle the form submission inside the modal
                $('#disableForm').on('submit', function(e) {
                    e.preventDefault();

                    var reason = $('#disabled_reason').val(); // Get the disabled reason input value
                    var disableButton = $(
                    '#disableForm button[type="submit"]'); // Reference to the submit button

                    // Validate if the reason is provided
                    if (reason === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Disabled reason is required.',
                            confirmButtonText: 'OK'
                        });
                        return; // Prevent form submission if the reason is not provided
                    }

                    var formData = $(this).serialize(); // Get form data

                    // Disable the button and show "Disabling..."
                    disableButton.prop('disabled', true).text('Disabling...');

                    // Send AJAX request to disable consultancy
                    $.ajax({
                        url: '{{ route('disable.consultancy') }}', // Post route for disabling consultancy
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#disableModal').modal('hide'); // Hide the modal

                            // Use SweetAlert2 for success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });

                            // Reload data table
                            $('.consultancy-datatable').DataTable().ajax.reload();

                            // Enable the button and reset text
                            disableButton.prop('disabled', false).text('Disable');
                        },
                        error: function(xhr, status, error) {
                            // Use SweetAlert2 for error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred: ' + error,
                                confirmButtonText: 'OK'
                            });

                            // Enable the button and reset text
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
                        $(this).val($(this).val().substring(0, maxLength));
                        $('#charCount').text(maxLength + '/' +
                        maxLength); // Show max count if limit is exceeded
                    }
                });

                // ======end of disabling consultancy========

                // ==========enable consultancy====================
                $(document).on('click', '.enable-btn', function() {
                    var slug = $(this).data('slug');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to enable this consultancy?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, enable it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send an AJAX request to enable the consultancy
                            $.ajax({
                                url: "{{ route('enable.consultancy') }}",
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    slug: slug
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Enabled!',
                                        response.message,
                                        'success'
                                    );
                                    $('.consultancy-datatable').DataTable().ajax
                                        .reload();
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to enable the consultancy.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
                // ========end of enabling consultancy=============

                // =======displaying logo in modal============
                $(document).on('click', '.logo-image', function() {
                    var logoUrl = $(this).data('url'); // Get the image URL from data-url attribute
                    $('#modal-logo').attr('src', logoUrl); // Set the image source in the modal
                    $('#logoModal').modal('show'); // Show the modal
                });
                // ======end of displaying logo in modal========
            });
        });
    </script>
@endpush

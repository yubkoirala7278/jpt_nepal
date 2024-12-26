@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Applicants</h2>
        @if (Auth::user()->hasRole('consultancy_manager'))
            <a class="btn btn-secondary btn-sm" href="{{ route('student.create') }}">Add New</a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover pt-3" id="studentsTable" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Address</th>
                    @if(Auth::user()->hasRole('admin'))
                    <th>Consultancy Name</th>
                    <th>Consultancy Address</th>
                    @endif
                    <th>Phone Number</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Receipt</th>
                    <th>Status</th>
                    <th>Exam Date</th>
                    <th>Exam Duration</th>
                    <th>Registration No.</th>
                    <th>Admit Card</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection



@section('modal')
    <!-- Displaying receipt in modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Receipt Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Modal image -->
                    <img id="modal-receipt" src="" alt="Receipt Preview" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <!-- Upload Admit Card Modal -->
    <div class="modal fade" id="uploadAdmitCardModal" tabindex="-1" aria-labelledby="uploadAdmitCardModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadAdmitCardModalLabel">Upload Admit Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadAdmitCardForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="admit_card" class="form-label">Admit Card</label>
                            <input type="file" class="form-control" name="admit_card" id="admit_card"
                                accept=".pdf,.jpg,.jpeg,.png,.webp" required>
                        </div>
                        <input type="hidden" name="student_slug" id="student_slug">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitAdmitCard">Upload</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // ======display applicants in data table============
            var userRole = "{{ Auth::user()->getRoleNames()->first() }}";

            // Define the common columns
            let columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'dob',
                    name: 'dob'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'receipt_image',
                    name: 'receipt_image'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'exam_date',
                    name: 'exam_date'
                },
                {
                    data: 'exam_duration',
                    name: 'exam_duration'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'admit_card',
                    name: 'admit_card'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ];

            // Add additional columns for roles other than consultancy_manager
            if (userRole !== 'consultancy_manager') {
                columns.splice(3, 0, // Insert at position 3
                    {
                        data: 'consultancy_name',
                        name: 'consultancy_name'
                    }, {
                        data: 'consultancy_address',
                        name: 'consultancy_address'
                    }
                );
            }

            // Initialize the DataTable
            $('#studentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('student.index') }}",
                columns: columns,
                order: [
                    [1, 'desc']
                ] // Default sorting on the "name" column
            });
            // =========end of displaying applicants in data table====

            // =======displaying receipt in modal============
            $(document).on('click', '.receipt-image', function() {
                var receiptUrl = $(this).data('url'); // Get the image URL from data-url attribute
                $('#modal-receipt').attr('src', receiptUrl); // Set the image source in the modal
                $('#receiptModal').modal('show'); // Show the modal
            });
            // ======end of displaying receipt in modal========

            // =========delete student==============
            $(document).on('click', '.delete-btn', function() {
                const url = $(this).data('url');
                const id = $(this).data('id');

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
                                _token: '{{ csrf_token() }}', // CSRF token for Laravel
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message, // Display success message
                                    'success'
                                );
                                $('#studentsTable').DataTable().ajax
                                    .reload(); // Reload DataTable
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON.message || 'An unexpected error occurred.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });


            // ========end of deleting student=========


            // =========Open the modal when the "Upload Admit Card" button is clicked==============
            $(document).on('click', '.upload-admit-card-btn', function() {
                const slug = $(this).data('slug');
                $('#student_slug').val(slug); // Set the student's slug in the hidden input
                $('#uploadAdmitCardModal').modal('show'); // Show the modal
            });

            // =============Handle form submission==================
            $('#submitAdmitCard').click(function() {
                const formData = new FormData($('#uploadAdmitCardForm')[0]);

                $.ajax({
                    url: "{{ route('student.uploadAdmitCard.store', '') }}/" + $('#student_slug')
                        .val(),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#uploadAdmitCardModal').modal('hide'); // Hide the modal
                        $('#uploadAdmitCardForm')[0].reset(); // Reset the form
                        $('#studentsTable').DataTable().ajax
                            .reload(); // Reload DataTable
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + xhr.responseJSON.message,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endpush

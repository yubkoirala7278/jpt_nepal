@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Applicants</h2>
        @if (Auth::user()->hasRole('consultancy_manager'))
            <a class="btn btn-secondary btn-sm" href="{{ route('student.create') }}">Add New</a>
        @endif
        @if (Auth::user()->hasRole('admin'))
            <div>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importExamCodes">
                    Import Exam Code
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportApplicants">
                    Export Applicants
                </button>
            </div>
        @endif
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
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Phone Number</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Exam Date</th>
                    <th>Exam Duration</th>
                    <th>Registration No.</th>
                    <th>Examinee Category</th>
                    <th>Exam Category</th>
                    <th>Test Venue</th>
                    <th>Venue Code</th>
                    <th>Receipt</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Admit Card</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('modal')

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
    {{-- export applicants --}}
    <div class="modal fade modal-lg" id="exportApplicants" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exportApplicantsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="exportApplicantsForm" action="{{ route('applicants.export') }}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exportApplicantsLabel">Export Applicants</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @csrf
                        <div id="form-errors" class="alert alert-danger d-none"></div>
                        <div class="mb-3">
                            <label class="form-label">Select Exam Date</label>
                            <select class="form-select" name="date" required>
                                <option selected disabled>Select Date</option>
                                @if (count($examDates) > 0)
                                    @foreach ($examDates as $examDate)
                                        <option value="{{ $examDate->id }}">{{ $examDate->exam_date }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="date-error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Test Center</label>
                            <select class="form-select" name="test_center" required>
                                <option selected disabled>Select Test Center</option>
                                @if (count($testCenterManagers) > 0)
                                    @foreach ($testCenterManagers as $testCenterManager)
                                        <option value="{{ $testCenterManager->id }}">{{ $testCenterManager->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="test_center-error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Export File To</label>
                            <div class="d-flex align-items-center" style="column-gap: 20px">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="export" value="excel"
                                        id="excel" checked>
                                    <label class="form-check-label" for="excel">
                                        Excel
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="export" value="csv"
                                        id="csv">
                                    <label class="form-check-label" for="csv">
                                        CSV
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="export" value="pdf"
                                        id="pdf">
                                    <label class="form-check-label" for="pdf">
                                        PDF
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="d-flex align-items-center" style="column-gap: 20px">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="1"
                                        id="approved" checked>
                                    <label class="form-check-label" for="approved">
                                        Approved
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="0"
                                        id="pending">
                                    <label class="form-check-label" for="pending">
                                        Pending
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="2"
                                        id="both">
                                    <label class="form-check-label" for="both">
                                        Both
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Export Reason</label>
                            <div class="d-flex align-items-center" style="column-gap: 20px">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="export_reason" value="exam_code"
                                        id="exam_code" checked>
                                    <label class="form-check-label" for="exam_code">
                                       Insert Examinee Number
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="export_reason" value="result"
                                        id="result">
                                    <label class="form-check-label" for="result">
                                       Insert Result
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="export_reason" value="monitor"
                                        id="monitor">
                                    <label class="form-check-label" for="monitor">
                                        Just to Monitor
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Export</button>
                    </div>
            </form>
        </div>
    </div>
    </div>

    {{-- import exam codes --}}
    <div class="modal fade" id="importExamCodes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="importExamCodesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('exam-code.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="importExamCodesLabel">Import Exam Code</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Excel/CSV File</label>
                            <input type="file" class="form-control" name="file" id="file"
                                accept=".xlsx,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // ====== Display Applicants in Data Table ======
            var isConsultancyManager = {{ auth()->user()->hasRole('consultancy_manager') ? 'true' : 'false' }};

            $('#studentsTable').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                ajax: "{{ route('student.index') }}",
                columns: [{
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
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'consultancy_address',
                        name: 'consultancy_address'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'nationality',
                        name: 'nationality'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'dob',
                        name: 'dob',
                        orderable: false,
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'exam_date.exam_date',
                        name: 'exam_date.exam_date'
                    },
                    {
                        data: 'exam_duration',
                        name: 'exam_duration',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'examinee_category',
                        name: 'examinee_category',
                    },
                    {
                        data: 'exam_category',
                        name: 'exam_category',
                    },
                    {
                        data: 'test_venue',
                        name: 'test_venue',
                    },
                    {
                        data: 'venue_code',
                        name: 'venue_code',
                    },
                    {
                        data: 'receipt',
                        name: 'receipt',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: false
                    },
                    {
                        data: 'admit_card',
                        name: 'admit_card',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ],
                // Hide Consultancy Name and Address columns if the user is a Consultancy Manager
                columnDefs: isConsultancyManager ? [{
                    targets: [3, 4],
                    visible: false
                }] : []
            });
            // ====== End of Display Applicants in Data Table ======

            // ===========delete student======================
            $(document).on('click', '.delete-student', function() {
                const slug = $(this).data('slug');
                const url = "{{ route('student.destroy', '') }}/" + slug;

                // Show SweetAlert for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the student
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'The student has been deleted.',
                                    confirmButtonText: 'OK'
                                });
                                // Reload DataTable or perform any other actions
                                $('#studentsTable').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error deleting the student. Please try again.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
            // ==========end of deleting student=============

            // =========Open the modal when the "Upload Admit Card" button is clicked==============
            $(document).on('click', '.upload-admit-card-btn', function() {
                const slug = $(this).data('slug');
                $('#student_slug').val(slug); // Set the student's slug in the hidden input
                $('#uploadAdmitCardModal').modal('show'); // Show the modal
            });

            // =============Handle form submission==================
            $('#submitAdmitCard').click(function() {
                const formData = new FormData($('#uploadAdmitCardForm')[0]);

                // Disable the button and change text to "Uploading..."
                $('#submitAdmitCard').prop('disabled', true).text('Uploading...');

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
                        $('#studentsTable').DataTable().ajax.reload(); // Reload DataTable

                        // Re-enable the button and restore the original text
                        $('#submitAdmitCard').prop('disabled', false).text('Upload');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + xhr.responseJSON.message,
                            confirmButtonText: 'OK'
                        });

                        // Re-enable the button and restore the original text
                        $('#submitAdmitCard').prop('disabled', false).text('Upload');
                    }
                });
            });

            // ==========change status of student==========
            $(document).on('click', '.change-status-btn', function() {
                let studentSlug = $(this).data('slug');
                let currentStatus = $(this).data('status');
                let newStatus = currentStatus ? 'Pending' : 'Approved';
                let alertText = currentStatus ?
                    "Are you sure you want to mark this student as Pending?" :
                    "Are you sure you want to mark this student as Approved?";

                Swal.fire({
                    title: "Change Student Status",
                    text: alertText,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Change it!",
                    cancelButtonText: "No, Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/change-student-status', // Adjust this route to your backend
                            method: 'POST',
                            data: {
                                slug: studentSlug,
                                status: !currentStatus, // Toggle the status
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content') // Include CSRF token
                            },
                            success: function(response) {
                                Swal.fire(
                                    "Status Changed!",
                                    "The student's status has been updated to " +
                                    newStatus + ".",
                                    "success"
                                );
                                // Reload the data table to reflect the updated status
                                $('#studentsTable').DataTable().ajax.reload();
                            },
                            error: function() {
                                Swal.fire(
                                    "Error!",
                                    "There was an error updating the student's status. Please try again.",
                                    "error"
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>


    <script>
        function downloadAdmitCard(dob, registration_number, student_id) {
            // Disable the download button and change its text
            var downloadButton = $('#download-button-' + student_id);
            downloadButton.prop('disabled', true);
            downloadButton.html('Downloading...');

            $.ajax({
                url: '/get-admit-card', // This is your AJAX route
                type: 'GET',
                data: {
                    dob: dob,
                    registration_number: registration_number,
                },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Open the admit card in a new tab
                        window.open('/admit-card/' + dob + '/' + registration_number, '_blank');
                    }
                },
                error: function(xhr) {
                    alert('Something went wrong!');
                },
                complete: function() {
                    // Re-enable the button and reset the text
                    downloadButton.prop('disabled', false);
                    downloadButton.html('<i class="fa-solid fa-download"></i> Download');
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('#exportApplicants form');
            const exportButton = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const url = form.action;

                // Disable the Export button and change its text to "Exporting..."
                exportButton.disabled = true;
                const originalButtonText = exportButton.innerHTML;
                exportButton.innerHTML = 'Exporting...';

                // Clear previous errors
                document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');
                const formErrors = document.getElementById('form-errors');
                if (formErrors) {
                    formErrors.classList.add('d-none');
                    formErrors.innerHTML = '';
                }

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    });

                    if (!response.ok) {
                        if (response.status === 422) { // Validation error
                            const errors = await response.json();
                            if (errors.errors) {
                                // Display validation errors below respective fields
                                Object.keys(errors.errors).forEach(key => {
                                    const input = form.querySelector(`[name="${key}"]`);
                                    if (input) {
                                        // Remove existing invalid-feedback if any
                                        let errorElement = input.parentNode.querySelector(
                                            '.invalid-feedback');
                                        if (!errorElement) {
                                            errorElement = document.createElement('div');
                                            errorElement.classList.add('invalid-feedback');
                                            input.parentNode.appendChild(errorElement);
                                        }
                                        errorElement.innerText = errors.errors[key][0];
                                        input.classList.add('is-invalid');
                                    }
                                });

                                // Optionally, show a general error message
                                if (formErrors) {
                                    formErrors.classList.remove('d-none');
                                    formErrors.innerHTML = 'Please fix the errors and try again.';
                                }
                            }
                        } else {
                            // Handle other types of errors (e.g., server errors)
                            const errorData = await response.json();
                            Swal.fire(
                                "Error!",
                                errorData.message ||
                                "There was an error processing your request. Please try again.",
                                "error"
                            );
                        }
                    } else {
                        // Assuming the response is a file download
                        const contentDisposition = response.headers.get('content-disposition');
                        let filename = 'applicants_exported';
                        if (contentDisposition && contentDisposition.indexOf('filename=') !== -1) {
                            const filenameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
                            if (filenameMatch.length > 1) filename = filenameMatch[1];
                        } else {
                            // Fallback filename based on export type
                            const exportType = formData.get('export') || 'file';
                            filename = `applicants.${exportType}`;
                        }

                        const blob = await response.blob();
                        const downloadUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = downloadUrl;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();

                        // Optionally, show a success message
                        Swal.fire(
                            "Success!",
                            "Applicants have been exported successfully.",
                            "success"
                        );

                        // Close the modal
                        const modalElement = document.getElementById('exportApplicants');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) {
                            modal.hide();
                        }

                        // Optionally, reset the form
                        form.reset();
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                    Swal.fire(
                        "Error!",
                        "There was an unexpected error. Please try again.",
                        "error"
                    );
                } finally {
                    // Re-enable the Export button and reset its text
                    exportButton.disabled = false;
                    exportButton.innerHTML = originalButtonText;
                }
            });
        });
    </script>
@endpush

@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Applicants</h2>
        @if (Auth::user()->hasRole('consultancy_manager'))
            <a class="btn btn-secondary btn-sm" href="{{ route('student.create') }}">Add New</a>
        @endif
        @if (Auth::user()->hasRole('admin'))
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportApplicants">
                Export Applicants
            </button>
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
                    <th>Phone Number</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Receipt</th>
                    <th>Amount</th>
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
                            <input type="file" class="form-control" name="admit_card" id="admit_card" required>
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
    <div class="modal fade" id="exportApplicants" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exportApplicantsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('applicants.export') }}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exportApplicantsLabel">Export Applicants</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @csrf
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
                                    <input class="form-check-input" type="radio" name="status" value="0"
                                        id="pending" checked>
                                    <label class="form-check-label" for="pending">
                                        Pending
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
                ajax: "{{ route('student.pending') }}",
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
                        data: 'user.consultancy.address',
                        name: 'user.consultancy.address'
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
                    } // 3 is for Consultancy Name, 4 is for Consultancy Address
                ] : []
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

        });
    </script>
@endpush

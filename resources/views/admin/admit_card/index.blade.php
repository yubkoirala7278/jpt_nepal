@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2>Download Admit Card</h2>
    </div>
    <div class="table-responsive">
        <table class="table applicants-datatable table-hover w-100" id="studentsTable" style="white-space: nowrap;">
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
                    <th>Admit Card</th>
                </tr>
            </thead>
        </table>
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
                ajax: "{{ route('admin.admit-card') }}",
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
                        data: 'admit_card',
                        name: 'admit_card',
                        searchable: false
                    }
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
@endpush

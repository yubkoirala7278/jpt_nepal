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
        function downloadAdmitCard(dob, slug, rowId) {
            // Select the button
            const button = document.getElementById(`download-button-${rowId}`);

            // Disable the button and update text
            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Downloading';

            // Send an AJAX request
            fetch('/my-admit-card', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        dob: dob,
                        registration_number: slug
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.downloadUrl) {
                        // Trigger the file download
                        const link = document.createElement('a');
                        link.href = data.downloadUrl;
                        link.download = 'AdmitCard.pdf';
                        link.click();
                    } else {
                        alert('Error: Unable to download the admit card.');
                    }
                })
                .catch(error => {
                    console.error('Download failed:', error);
                    alert('An error occurred while processing the download.');
                })
                .finally(() => {
                    // Re-enable the button and restore text
                    button.disabled = false;
                    button.innerHTML = '<i class="fa-solid fa-download"></i> Download';
                });
        }
    </script>
@endpush

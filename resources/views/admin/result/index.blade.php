@extends('admin.layouts.master')

@section('content')
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <h2>Applicant Results</h2>
        <div>
            @if (Auth::user()->hasRole('admin'))
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importResults">
                    Import Result
                </button>
            @endif
            <button type="button" class="btn  btn-success" data-bs-toggle="modal" data-bs-target="#exportResults">
                Export Result
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="studentsTable" class="table table-hover pt-3 w-100">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone No.</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Registration No.</th>
                    <th>Exam Date</th>
                    <th>Marks</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically filled by DataTables -->
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    {{-- import results --}}
    <div class="modal fade" id="importResults" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="importResultsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('results.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="importResultsLabel">Import Results</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" class="form-control" name="file" id="file" accept=".xlsx"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
            </form>
        </div>
    </div>
    {{-- export result --}}
    <div class="modal fade" id="exportResults" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exportResultsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.applicant-result-export') }}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exportResultsLabel">Export Result</h1>
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
                            <label class="form-label">Result</label>
                            <div class="d-flex align-items-center" style="column-gap: 20px">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="result" value="pass"
                                        id="pass" checked>
                                    <label class="form-check-label" for="pass">
                                        Pass
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="result" value="fail"
                                        id="fail">
                                    <label class="form-check-label" for="fail">
                                        Fail
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="result" value="both"
                                        id="both">
                                    <label class="form-check-label" for="both">
                                        Both
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Export</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#studentsTable').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                ajax: '{{ route('admin.applicant-result') }}', // Your route to get data
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
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'exam_date',
                        name: 'exam_date'
                    }, // Display badges
                    {
                        data: 'marks',
                        name: 'marks'
                    },
                    {
                        data: 'result',
                        name: 'result',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ], // Default sort by name column
                lengthMenu: [10, 25, 50, 100], // Allow pagination of different lengths
                pageLength: 10, // Default page length
            });
        });
    </script>
@endpush

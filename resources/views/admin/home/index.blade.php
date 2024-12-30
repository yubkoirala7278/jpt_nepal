@extends('admin.layouts.master')

@section('header-links')
    <style>
        .table {
            border-collapse: separate;
            border-spacing: 0;
            background-color: #fff;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 15px;
        }

        .table-dark {
            background-color: #343a40;
            color: white;
            font-weight: 600;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .table-responsive {
            margin-top: 1rem;
        }

        .shadow-sm {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .rounded-lg {
            border-radius: 8px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 5px 12px;
            font-size: 14px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
@endsection

@section('content')
    @if (Auth::user()->hasRole('admin'))
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Test Centers</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalTestCenter ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-info text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Education Consultancy</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalEducationConsultancy ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-success text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalApplicants }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-danger text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">News & Notices</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalNotice }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-warning text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Admit Card</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalAdmitCard }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-secondary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Results</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalResults }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-start">
                    <div>
                        <h2>Recent Applicants</h2>
                        <table class="table mt-3 table-hover table-responsive shadow-sm rounded-xl">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col">Applicant Name</th>
                                    <th scope="col">Education Consultancy</th>
                                    <th scope="col">Test Center</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($students) > 0)
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->user->name }}</td>
                                            <td>{{ $student->user->consultancy->test_center->name }}</td>
                                            <td>
                                                <a href="{{ route('student.show', $student->slug) }}"
                                                    class="btn btn-success btn-sm">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="20">No applicants to display..</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $students->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->hasRole('test_center_manager'))
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Education Consultancy</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalEducationConsultancy ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $jptApplicants ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Pending Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $pendingApplicants ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Approved Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $jptApplicants - $pendingApplicants }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-start">
                    <div class=" my-5">
                        <div class="row">
                            <!-- News & Notice Section -->
                            <div class="col-lg-7 mb-4">
                                <div class="card shadow-sm border-0 rounded-xl">
                                    <div class="card-header bg-success text-white text-center">
                                        <h4 class="mb-0">News & Notice</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover text-center w-100">
                                            <thead class="table-success table-striped">
                                                <tr>
                                                    <th scope="col">S.N</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($notices) > 0)
                                                    @foreach ($notices as $key => $notice)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ \Illuminate\Support\Str::limit($notice->title, 30, '...') }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('notice.show', $notice->slug) }}"
                                                                    class="btn btn-sm btn-outline-success">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $notices->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Test Section -->
                            <div class="col-lg-5 mb-4">
                                <div class="card shadow-sm border-0 rounded-xl">
                                    <div class="card-header bg-success text-white text-center">
                                        <h4 class="mb-0">Upcoming Test</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table  table-hover text-center w-100">
                                            <thead class="table-success">
                                                <tr>
                                                    <th scope="col">S.N</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($upcomingTests) > 0)
                                                    @foreach ($upcomingTests as $key => $test)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $test->exam_date }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($test->exam_start_time)->format('h:i A') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($test->exam_end_time)->format('h:i A') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $upcomingTests->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @elseif(Auth::user()->hasRole('consultancy_manager'))
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">JPT Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $jptApplicants ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Pending Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $pendingApplicants ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Approved Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $jptApplicants - $pendingApplicants }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-start">
                    <div class=" my-5">
                        <div class="row">
                            <!-- News & Notice Section -->
                            <div class="col-lg-7 mb-4">
                                <div class="card shadow-sm border-0 rounded-xl">
                                    <div class="card-header bg-success text-white text-center">
                                        <h4 class="mb-0">News & Notice</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover text-center w-100">
                                            <thead class="table-success table-striped">
                                                <tr>
                                                    <th scope="col">S.N</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($notices) > 0)
                                                    @foreach ($notices as $key => $notice)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ \Illuminate\Support\Str::limit($notice->title, 30, '...') }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('notice.show', $notice->slug) }}"
                                                                    class="btn btn-sm btn-outline-success">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $notices->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Test Section -->
                            <div class="col-lg-5 mb-4">
                                <div class="card shadow-sm border-0 rounded-xl">
                                    <div class="card-header bg-success text-white text-center">
                                        <h4 class="mb-0">Upcoming Test</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table  table-hover text-center w-100">
                                            <thead class="table-success">
                                                <tr>
                                                    <th scope="col">S.N</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($upcomingTests) > 0)
                                                    @foreach ($upcomingTests as $key => $test)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $test->exam_date }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($test->exam_start_time)->format('h:i A') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($test->exam_end_time)->format('h:i A') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $upcomingTests->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
@endpush

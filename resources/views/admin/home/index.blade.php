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

        /* Custom text colors based on backgrounds */
        .text-custom-light {
            color: #ffffff;
        }

        .text-custom-dark {
            color: #212529;
        }

        /* Hover effect */
        .custom-test-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Card shadow customization */
        .custom-test-card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .widgets-icons-2 {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ededed;
            font-size: 21px;
        }
    </style>
@endsection

@section('content')
    @if (Auth::user()->hasRole('admin'))
        <div class="container-fluid ">
            <div class="row ">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Upcoming Test</p>
                                    <h4 class="my-1 text-primary fw-bold">{{ $upcomingTestCount }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #FF5733, #FFC300);">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Test Centers</p>
                                    <h4 class="my-1 text-success fw-bold">{{ $totalTestCenter ?? '0' }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #28a745, #6c757d);">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Education Consultancy</p>
                                    <h4 class="my-1 text-danger fw-bold">{{ $totalEducationConsultancy ?? '0' }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #dc3545, #ff5733);">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Applicants</p>
                                    <h4 class="my-1 text-warning fw-bold">{{ $totalApplicants }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #ffc107, #ff8c00);">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-secondary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Pending Applicants</p>
                                    <h4 class="my-1 text-secondary fw-bold">{{ $pendingApplicants }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #6c757d, #495057);">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Approved Applicants</p>
                                    <h4 class="my-1 text-info fw-bold">{{ $totalApplicants - $pendingApplicants }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #17a2b8, #007bff);">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-dark">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">News & Notices</p>
                                    <h4 class="my-1 text-dark fw-bold">{{ $totalNotice }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #343a40, #212529);">
                                    <i class="fas fa-bell"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Admit Card</p>
                                    <h4 class="my-1 text-primary fw-bold">{{ $totalAdmitCard }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #007bff, #004085);">
                                    <i class="fas fa-id-card"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Results</p>
                                    <h4 class="my-1 text-danger fw-bold">{{ $totalResults }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #dc3545, #ff5733);">
                                    <i class="fas fa-trophy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- line chart to display applicant added per month --}}
                <div class="col-8 mt-4">
                    <div id="students-line-chart"></div>
                </div>
                {{-- pie chart to display pending and approved applicants --}}
                <div class="col-4 mt-4">
                    <div id="test-centers-pie-chart"></div>
                </div>

                <!-- Recent Applicants Table -->
                <div class="col-12 text-start mt-4">
                    <div>
                        <h2>Recent Approved Applicants</h2>
                        <table class="table mt-3 table-hover table-responsive shadow-lg rounded-xl">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col">Applicant Name</th>
                                    <th scope="col">Education Consultancy</th>
                                    <th scope="col">Test Center</th>
                                    <th scope="col">Exam Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($students) > 0)
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->user->name }}</td>
                                            <td>{{ $student->user->consultancy->test_center->name??$student->user->name }}</td>
                                            <td>{{ $student->exam_date ? \Carbon\Carbon::parse($student->exam_date->exam_date)->format('M d, Y') : 'N/A' }}</td>
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
    @elseif(Auth::user()->hasRole('test_center_manager') && Auth::user()->test_center->status == 'active')
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Education Consultancy</p>
                                    <h4 class="my-1 text-danger fw-bold">{{ $totalEducationConsultancy ?? '0' }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #dc3545, #ff5733);">
                                    <i class="fas fa-trophy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Applicants</p>
                                    <h4 class="my-1 text-info fw-bold">{{ $jptApplicants ?? '0' }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #17a2b8, #007bff);">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Pending Applicants</p>
                                    <h4 class="my-1 text-warning fw-bold">{{ $pendingApplicants ?? '0' }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #ff9800, #f57c00);">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Approved Applicants</p>
                                    <h4 class="my-1 text-success fw-bold">{{ $jptApplicants - $pendingApplicants }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #28a745, #218838);">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Notice</p>
                                    <h4 class="my-1 text-primary fw-bold">2</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #17a2b8, #138496);">
                                    <i class="fas fa-bell"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- line chart to display applicant added per month --}}
                <div class="col-8 mt-4">
                    <div id="students-line-chart"></div>
                </div>
                {{-- pie chart to display pending and approved applicants --}}
                <div class="col-4 mt-4">
                    <div id="test-centers-pie-chart"></div>
                </div>

                <div class="col-12 text-start">
                    <div class=" my-5">
                        <div class="row">
                            {{-- students details --}}
                            <div class="col-12 mb-4">
                                <div class="card shadow-sm border-0 rounded-xl">
                                    <div class="card-header bg-success text-white text-center">
                                        <h4 class="mb-0">Recent Applicants</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover text-center w-100">
                                            <thead class="table-success table-striped">
                                                <tr>
                                                    <th scope="col">Applicant Name</th>
                                                    <th scope="col">Consultancy Name</th>
                                                    <th scope="col">Exam Date</th>
                                                    <th scope="col">View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($students) > 0)
                                                    @foreach ($students as $student)
                                                        <tr>
                                                            <td>{{$student->name}}</td>
                                                            <td>{{$student->user->name}}</td>
                                                            <td>{{ $student->exam_date ? \Carbon\Carbon::parse($student->exam_date->exam_date)->format('M d, Y') : 'N/A' }}</td>
                                                            <td>
                                                                <a href="{{route('student.show',$student->slug)}}"
                                                                    class="btn btn-sm btn-outline-success">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif


                                            </tbody>
                                        </table>
                                        {{ $students->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
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
                                                            <td
                                                                style="word-wrap: break-word; white-space: normal; max-width: 200px;">
                                                                {{ $notice->title }}</td>
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
    @elseif(Auth::user()->hasRole('consultancy_manager') && Auth::user()->consultancy->status == 'active')
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Applicants</p>
                                    <h4 class="my-1 text-info fw-bold">{{ $jptApplicants ?? '0' }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #17a2b8, #007bff);">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Pending Applicants</p>
                                    <h4 class="my-1 text-warning fw-bold">{{ $pendingApplicants ?? '0' }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #ff9800, #f57c00);">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card radius-10 border-start border-0 border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Approved Applicants</p>
                                    <h4 class="my-1 text-success fw-bold">{{ $jptApplicants - $pendingApplicants }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"
                                    style="background: linear-gradient(to right, #28a745, #218838);">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- line chart to display applicant added per month --}}
                <div class="col-12 mt-4">
                    <div id="students-line-chart"></div>
                </div>
                {{-- pie chart to display pending and approved applicants --}}
                {{-- <div class="col-5 mt-4">
                    <div id="test-centers-pie-chart"></div>
                </div> --}}
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
                                                        <tr class="text-start">
                                                            <td>{{ $key + 1 }}</td>
                                                            <td style="word-wrap: break-word; white-space: normal;">
                                                                {{ $notice->title }}</td>
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
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($upcomingTests) > 0)
                                                    @foreach ($upcomingTests as $key => $test)
                                                        <tr class="text-start">
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $test->exam_date }}
                                                                <br>
                                                                <span style="font-size: 12px">
                                                                    {{ \Carbon\Carbon::parse($test->exam_start_time)->format('h:i A') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($test->exam_end_time)->format('h:i A') }}
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <a href="{{ route('student.create') }}"
                                                                    class="btn btn-success btn-sm rounded-pill text-white">Add
                                                                    Student</a>
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
    @else
        @if (Auth::user()->hasRole('consultancy_manager'))
            <div class="col-12">
                <div class="card dashboard-notice radius-10" style="background-color:#F7DDE7">
                    <a href="javascript:void(0)" class="close-notice"><i class="bx bx-x"></i></a>
                    <div class="card-body bg-light-danger py-4">
                        <div class="d-flex align-items-start">
                            <img src="{{ asset('admin/assets/img/banned.png') }}" width="90" height="auto"
                                alt="...">
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mt-0">Consultancy Disabled !! Contact Admin !!</h5>
                                <p>
                                    Hello {{ Auth::user()->name }},
                                    <br><br>
                                    We regret to inform you that your consultancy has been temporarily disabled.
                                    This action has been taken due to a breach of our company policies or other significant
                                    reasons.
                                    <br><br>

                                    <b>Reason :</b>
                                    <strong>{{ Auth::user()->consultancy->disabled_reason }}</strong>
                                    <br><br>
                                    If you believe this action has been taken in error or if you'd like to discuss this
                                    further, please contact the admin for resolution. The consultancy will remain disabled
                                    until the issue is addressed.
                                    <br><br>
                                    Thank you for your understanding and cooperation.
                                    <br><br>
                                    Best regards,
                                    <br>
                                    Japanese Proficiency Test
                                </p>
                                <a href="https://www.yourwebsite.com" target="_blank" class="btn btn-primary">Contact
                                    Admin</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @elseif(Auth::user()->hasRole('test_center_manager'))
            <div class="col-12">
                <div class="card dashboard-notice radius-10" style="background-color:#F7DDE7">
                    <a href="javascript:void(0)" class="close-notice"><i class="bx bx-x"></i></a>
                    <div class="card-body bg-light-danger py-4">
                        <div class="d-flex align-items-start">
                            <img src="{{ asset('admin/assets/img/banned.png') }}" width="90" height="auto"
                                alt="...">
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mt-0">Test Center Disabled !! Contact Admin !!</h5>
                                <p>
                                    Hello {{ Auth::user()->name }},
                                    <br><br>
                                    We regret to inform you that your test center has been temporarily disabled.
                                    This action has been taken due to a breach of our company policies or other significant
                                    reasons.
                                    <br><br>

                                    <b>Reason :</b>
                                    <strong>{{ Auth::user()->test_center->disabled_reason }}</strong>
                                    <br><br>
                                    If you believe this action has been taken in error or if you'd like to discuss this
                                    further, please contact the admin for resolution. The consultancy will remain disabled
                                    until the issue is addressed.
                                    <br><br>
                                    Thank you for your understanding and cooperation.
                                    <br><br>
                                    Best regards,
                                    <br>
                                    Japanese Proficiency Test
                                </p>
                                <a href="https://www.yourwebsite.com" target="_blank" class="btn btn-primary">Contact
                                    Admin</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @endif

    @endif
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ===========line chart to display applicant added per month============
            var options1 = {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: false // Hides export/download options
                    },
                    zoom: {
                        enabled: false // Disables zooming
                    }
                },
                series: [{
                    name: 'Applicants Added',
                    data: [45, 50, 55, 60, 70, 80, 85, 90, 100, 110, 120, 130] // Example data
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ], // Months
                    title: {
                        text: 'Month',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Applicant Count',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold'
                        }
                    }
                },
                colors: ['#4CAF50'], // Line color (green in this case)
                stroke: {
                    curve: 'smooth', // Smooth curve for the line
                    width: 5
                },
                markers: {
                    size: 5,
                    colors: ['#4CAF50'], // Marker color
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                grid: {
                    borderColor: '#e7e7e7'
                },
                tooltip: {
                    theme: 'dark'
                },
                title: {
                    text: 'Applicant Added Per Month',
                    align: 'center',
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold'
                    }
                }
            };

            var chart1 = new ApexCharts(document.querySelector("#students-line-chart"), options1);
            chart1.render();
            // ============end of line chart to display applicant added per month============

            // ===========pie chart to display total applicants of related test centers==========
            var testCenterNames = ['Center A', 'Center B', 'Center C', 'Center D']; // Example test center names
            var applicantCounts = [120, 90, 150, 80]; // Example applicant counts for each center

            var options2 = {
                chart: {
                    type: 'pie',
                    height: 350,
                },
                series: applicantCounts, // Dynamic applicant data
                labels: testCenterNames, // Dynamic test center names
                colors: ['#FF5733', '#33FF57', '#337BFF', '#FFC300'], // Custom colors for each center
                legend: {
                    position: 'bottom',
                },
                title: {
                    text: 'Applicants',
                    align: 'center',
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold'
                    }
                },
                tooltip: {
                    theme: 'dark'
                }
            };

            var chart2 = new ApexCharts(document.querySelector("#test-centers-pie-chart"), options2);
            chart2.render();
            // ============end of pie chart to display total applicants of related test centers==========
        });
    </script>
@endpush

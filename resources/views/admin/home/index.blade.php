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
    </style>
@endsection

@section('content')
    @if (Auth::user()->hasRole('admin'))
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Upcoming Test</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $upcomingTestCount }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-custom-primary text-custom-light">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Test Centers</h2>
                            <p class="custom-test-card-count display-4 mb-3 ">{{ $totalTestCenter ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center text-custom-light">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Education Consultancy</h2>
                            <p class="custom-test-card-count display-4 mb-3 ">{{ $totalEducationConsultancy ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center text-custom-light">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Total Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3 ">{{ $totalApplicants }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center text-custom-light">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Pending Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3 ">{{ $pendingApplicants }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center text-custom-light">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Approved Applicants</h2>
                            <p class="custom-test-card-count display-4 mb-3 ">{{ $totalApplicants-$pendingApplicants }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center  text-custom-light">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">News & Notices</h2>
                            <p class="custom-test-card-count display-4 mb-3 ">{{ $totalNotice }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-custom-warning">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Admit Card</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalAdmitCard }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center  text-custom-light">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Results</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalResults }}</p>
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
                        <h2>Recent Applicants</h2>
                        <table class="table mt-3 table-hover table-responsive shadow-lg rounded-xl">
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
                            <h2 class="custom-test-card-title font-weight-bold mb-3 ">Education Consultancy</h2>
                            <p class="custom-test-card-count display-4 mb-3">{{ $totalEducationConsultancy ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Total Applicants</h2>
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
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-mdrounded-lg overflow-hidden">
                        <div class="card-body d-flex flex-column align-items-center bg-gradient-primary text-white">
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Notice</h2>
                            <p class="custom-test-card-count display-4 mb-3">2</p>
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
                                                            <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $notice->title }}</td>
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
                            <h2 class="custom-test-card-title font-weight-bold mb-3">Total Applicants</h2>
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
                                                            <td style="word-wrap: break-word; white-space: normal;">{{ $notice->title }}</td>
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

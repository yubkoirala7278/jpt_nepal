@extends('public.layouts.master')
@section('header-links')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* General Styles */
        .section-body {
            background-color: #f9fafb;
            padding: 40px;
            border-radius: 8px;
        }

        /* Shadow for Form and Buttons */
        .form-select,
        .btn {
            border-radius: 8px;
        }

        /* Styling for Button Hover */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Styling for the Search Data Section */
        .search-data h3 {
            font-weight: 600;
            font-size: 1.6rem;
            color: #333;
            margin-bottom: 10px;
        }

        .search-data p {
            font-size: 1rem;
            color: #6c757d;
            line-height: 1.6;
        }

        /* Adding Spacing for better readability */
        .search-data {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        /* Adding Spacing for Inputs and Select */
        .form-select {
            padding: 9px;
        }

        /* Small animations for hover on each section */
        [data-aos="fade-up"],
        [data-aos="fade-right"] {
            transition: all 0.5s ease-in-out;
        }

        [data-aos="fade-up"]:hover,
        [data-aos="fade-right"]:hover {
            transform: translateY(-5px);
        }

        #searchData {
            display: none;
        }
    </style>
@endsection
@section('content')
    <section class="banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner slider-body">
                @if (count($headers) > 0)
                    @foreach ($headers as $key => $header)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset($header->image) }}" class="slide-image d-block w-100" alt="Carousel Image"
                                loading="lazy">
                            <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center">
                                <h1 class="display-5 fw-bold" data-aos="fade-left" data-aos-duration="2000">
                                    {{ $header->title }}
                                </h1>
                                <p class="fs-4 text-start text-white" style="max-width: 600px;" data-aos="fade-right"
                                    data-aos-duration="2000">
                                    {{ $header->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="banner-button">
            <a href="{{ route('admit-card') }}" class="download-admit-card">Download Your Admit Card</a>
            <a href="{{ route('applicant-result') }}" class="check-your-result">Check Your Result</a>
        </div>


    </section>

    @if (count($blogs) > 0)
        <section class="my-news-slider mt-0">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div id="top-bar-slider">
                        <div class="top-blog-slider">
                            @foreach ($blogs as $blog)
                                <div>
                                    <a class="link fs-5"
                                        href="{{ route('blog-detail', $blog->slug) }}">{{ $blog->title }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (count($abouts) > 0)
        <section class="container">
            <div class="row gy-4">
                @foreach ($abouts as $index => $about)
                    <div class="col-md-6 {{ $index == 0 ? 'order-md-0 order-1' : 'order-md-1 order-0' }}"
                        data-aos="fade-{{ $index == 0 ? 'right' : 'left' }}" data-aos-duration="1500">
                        <div class="d-flex flex-column justify-content-center h-100">
                            <div class="section-title">
                                <span><i class="fa-solid fa-angles-right"></i> {{ $about->sub_title }}</span>
                                <h2>{{ $about->title }}</h2>
                            </div>
                            <p>{{ $about->description }}</p>
                            <div class="">
                                <a href="{{ route('about') }}" class="btn btn-outline-primary">Learn More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 {{ $index == 0 ? 'order-md-1 order-0' : 'order-md-0 order-1' }}"
                        data-aos="fade-{{ $index == 0 ? 'left' : 'right' }}" data-aos-duration="1500">
                        <img class="w-100 image-fluid rounded" src="{{ asset($about->image) }}" alt="{{ $about->title }}"
                            loading="lazy">
                    </div>
                @endforeach
            </div>
        </section>
    @endif


    <section class="container">
        <div class="section-title">
            <span><i class="fa-solid fa-angles-right"></i> Test Center</span>
            <h2>Available Test Center</h2>
        </div>
        <div class="section-body mt-5">
            <form id="testCenterForm" method="POST">
                @csrf
                <div class="row gy-4">
                    <!-- Location Dropdown -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                        <label for="location" class="form-label">Location</label>
                        <select id="location" class="form-select form-select-lg shadow-sm" name="address">
                            <option selected disabled>Select location</option>
                            @if (count($testCentreAddress) > 0)
                                @foreach ($testCentreAddress as $testCentre)
                                    <option value="{{ $testCentre->venue_address }}">{{ $testCentre->venue_address }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Find Button -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                        <label for="" class="form-label d-block">&nbsp;</label>
                        <button id="findButton" class="btn btn-lg btn-primary w-100 shadow-lg" type="submit">Find
                            Now</button>
                    </div>
                </div>
            </form>

            <!-- Loading Spinner -->
            <div id="loading" style="display: none;">Finding...</div>

            <!-- Search Data Section -->
            <div id="searchData" class="search-data mt-5 border-0" data-aos="fade-right" data-aos-duration="1500"></div>
        </div>


    </section>


    <section class="container">
        <div class="row gy-4">
            <div class="col-md-6" data-aos="flip-right" data-aos-duration="1500">
                <div class="section-title">
                    <span><i class="fa-solid fa-angles-right"></i> Upcoming Test</span>
                    <h2>Upcoming Test</h2>
                </div>
                <ul class="mt-4 list-group">
                    @if (count($upcomingTests) > 0)
                        @foreach ($upcomingTests as $test)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <!-- Date Section -->
                                <div class="col-md-8">
                                    <p class="fs-6 m-0">
                                        {{ \Carbon\Carbon::parse($test->exam_date)->format('l, F j, Y') }}</p>
                                </div>
                                <!-- Time Section -->
                                <div class="col-md-4 text-end">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm">
                                        {{ \Carbon\Carbon::parse($test->exam_start_time)->format('g:i A') }} -
                                        {{ \Carbon\Carbon::parse($test->exam_end_time)->format('g:i A') }}
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            <div class="d-flex justify-content-center">
                                <p class="fs-6 m-0 text-muted">No upcoming test to display.</p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col-md-6" data-aos="flip-left" data-aos-duration="1500">
                <div class="section-title">
                    <span><i class="fa-solid fa-angles-right"></i> Latest News</span>
                    <h2>News & Notice</h2>
                </div>
                <ul class="mt-4 list-group">
                    @if (count($notices) > 0)
                        @foreach ($notices as $notice)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-md-9">
                                        <p class="fs-6 m-0">{{ \Illuminate\Support\Str::limit($notice->title, 50) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('notice.detail', $notice->slug) }}" class="btn btn-primary">
                                            View Detail
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-12 text-center">
                                    <p class="fs-6 m-0">No notice to display.. </p>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
    @if (count($testimonials) > 0)
        <section class="container" data-aos="fade-right" data-aos-duration="1500">
            <div class="section-title mb-5">
                <span><i class="fa-solid fa-angles-right"></i> Clint Opinion</span>
                <h2>Testominal</h2>
            </div>
            <div id="testominal">


                <div class="testominal-slider">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-4">
                            <div class="card testominal-item" style="width: 95%">
                                <div class="card-body">
                                    <h5 class="card-title text-center fw-bold">{{ $testimonial->name }}</h5>
                                    <p class="card-text text-center fst-italic">"{{ $testimonial->description }}"
                                    </p>
                                    <div class="hr"></div>
                                    <p class="text-center fst-italic mt-2 mb-0"> <small>Good Experience</small> </p>
                                    <div class="rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#testCenterForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting normally

                // Disable the button and show loading text
                $('#findButton').prop('disabled', true);
                $('#loading').show();
                $('#searchData').html(''); // Clear previous results
                $('#searchData').hide(); // Hide the search data section before searching

                // Get the selected address value
                var address = $('#location').val();

                // Send the AJAX request
                $.ajax({
                    url: "{{ route('test-center-details') }}", // The route that will handle the request
                    method: "POST",
                    data: {
                        _token: $("input[name='_token']").val(),
                        address: address
                    },
                    success: function(response) {
                        // Re-enable the button and hide loading text
                        $('#findButton').prop('disabled', false);
                        $('#loading').hide();

                        // Check if we have data and update the search data section
                        if (response.success) {
                            var data = response.data;
                            var html = '';

                            // Loop through the data and display the test centers
                            data.forEach(function(testCentre) {
                                html += '<div class="test-center-details mb-3">';
                                html += '<h3 class="text-primary">' + testCentre.user
                                    .name + '</h3>'; // Display test center name (slug)
                                html += '<p class="mb-0"><strong>Phone:</strong> ' +
                                    testCentre.phone + '</p>';
                                html += '<p class="mb-0"><strong>Address:</strong> ' +
                                    testCentre.address + '</p>';
                                html += '<p class="mb-0"><strong>Email:</strong> ' +
                                    testCentre.user.email + '</p>';
                                html += '<hr/></div>';
                            });

                            // Display the results and show the search data section
                            $('#searchData').html(html);
                            $('#searchData').show();
                        } else {
                            $('#searchData').html(
                                '<p class="text-danger">Please select the location first.</p>'
                            );
                            $('#searchData')
                                .show(); // Show the search data section even if no data is found
                        }
                    },
                    error: function() {
                        // Re-enable the button and hide loading text
                        $('#findButton').prop('disabled', false);
                        $('#loading').hide();

                        // Display error message and show the search data section
                        $('#searchData').html(
                            '<p class="text-danger">An error occurred, please try again later.</p>'
                        );
                        $('#searchData')
                            .show(); // Show the search data section when there's an error
                    }
                });
            });
        });
    </script>
@endpush

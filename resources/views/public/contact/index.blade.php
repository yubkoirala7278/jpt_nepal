@extends('public.layouts.master')

@section('header-links')
    {{-- jqeury cdn --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- sweet alert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <section class="secondary-banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">

            <div class="carousel-inner slider-body">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/img/slider/japan-2.jpg') }}" class="slide-image d-block w-100"
                        alt="Japan Image" loading="lazy">
                    <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Contact Us</h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500">For any questions or assistance, contact us using the information below.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container contact-detail">
        <div class="section-title mb-4">
            <span><i class="fa-solid fa-angles-right"></i> Our Info</span>
            <h2>Contact Us</h2>
        </div>
        <div class="row gy-3 contact-info">
            <div class="col-md-4" data-aos="fade-right" data-aos-duration="1500">
                <div class="shadow p-3 rounded-4">
                    <div class="d-flex align-items-center gap-4">
                        <div class="">
                            <i class="fa-solid fa-location-dot display-5"></i>
                        </div>
                        <div class="">
                            <h2 class="fs-4 fw-bold">Address</h2>
                            <p>
                                Kathmandu, Nepal
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                <div class="shadow p-3 rounded-4">
                    <div class="d-flex align-items-center gap-4">
                        <div class="">
                            <i class="fa-solid fa-phone-volume display-5"></i>
                        </div>
                        <div class="">
                            <h2 class="fs-4 fw-bold">Phone</h2>
                            <p>
                                +977 9876543210
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-left" data-aos-duration="1500">
                <div class="shadow p-3 rounded-4">
                    <div class="d-flex align-items-center gap-4">
                        <div class="">
                            <i class="fa-solid fa-envelope display-5"></i>
                        </div>
                        <div class="">
                            <h2 class="fs-4 fw-bold">Email</h2>
                            <p>
                                info@example.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container">
        <div class="section-title mb-4">
            <span><i class="fa-solid fa-angles-right"></i> Contact</span>
            <h2>Get in Touch</h2>
        </div>
        <div class="row gy-4">

            <div class="col-md-6 order-md-0 order-1" data-aos="fade-right" data-aos-duration="1500">
                <div class="mapouter">
                    <div class="gmap_canvas"><iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=University of Oxford&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a
                            href="https://sprunkin.com/">Sprunki</a></div>
                    <style>
                        .mapouter {
                            position: relative;
                            text-align: right;
                            width: 100%;
                            height: 100%;
                        }

                        .gmap_canvas {
                            overflow: hidden;
                            background: none !important;
                            width: 100%;
                            height: 100%;
                        }

                        .gmap_iframe {
                            width: 100% !important;
                            height: 100% !important;
                        }
                    </style>
                </div>
            </div>

            <div class="col-md-6 order-md-1 order-0" data-aos="fade-left" data-aos-duration="1500">
                <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="contact-form row gy-3">
                        <div class="col-12">
                            <input type="text" class="form-control" placeholder="Full Name" name="name"
                                id="name">
                            <span class="text-danger error-text" id="error-name"></span>
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                            <span class="text-danger error-text" id="error-email"></span>
                        </div>
                        <div class="col-12">
                            <input type="number" class="form-control" placeholder="Phone" name="phone" id="phone">
                            <span class="text-danger error-text" id="error-phone"></span>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" id="message" rows="3" placeholder="Message..." name="message"></textarea>
                            <span class="text-danger error-text" id="error-message"></span>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit" id="submitBtn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Disable the submit button and show 'Submitting...'
                $('#submitBtn').attr('disabled', true).text('Submitting...');

                // Clear any previous error messages
                $('.error-text').text('');

                $.ajax({
                    url: "{{ route('contact.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Enable the submit button and reset the text
                        $('#submitBtn').attr('disabled', false).text('Submit');

                        if (response.status === 'success') {
                            // Clear the form fields after success
                            $('#contactForm')[0].reset();

                            Swal.fire({
                                icon: 'success',
                                title: 'Contact submitted successfully',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        // Enable the submit button and reset the text
                        $('#submitBtn').attr('disabled', false).text('Submit');

                        // Handle validation errors and display them below the fields
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                        }else if (xhr.responseJSON.message) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.message
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush

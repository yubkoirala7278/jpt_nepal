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
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">JPT Nepal</h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500">Lorem ipsum dolor sit amet
                            consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container">
        <div class="row">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500">
                <div class="section-title">
                    <span><i class="fa-solid fa-angles-right"></i> Download</span>
                    <h2>Download Your Admit Card</h2>
                </div>
                <form id="admitCardForm" class="mt-4">
                    <div class="border p-4 rounded-3 border-1" style="max-width: 600px;">
                        <div>
                            <label for="dob">Enter Date of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob">
                            <span id="dobError" class="text-danger"></span>
                        </div>
                        <div class="mt-3">
                            <label for="registration_number">Registration No.</label>
                            <input type="text" class="form-control" name="registration_number" id="registration_number"
                                placeholder="xxxxxx">
                            <span id="registrationError" class="text-danger"></span>
                        </div>
                        <div class="mt-3">
                            <button id="submitBtn" class="btn btn-primary" type="submit">View Admit Card</button>
                        </div>
                    </div>
                </form>


            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-duration="1500">
                <img src="{{ asset('frontend/img/download.jpg') }}" class="w-100 image-fluid" alt="Admit Card"
                    loading="lazy">
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#admitCardForm').on('submit', function(e) {
                e.preventDefault();

                // Get input values
                let dob = $('#dob').val();
                let registrationNumber = $('#registration_number').val();

                // Clear previous error messages
                $('#dobError').text('');
                $('#registrationError').text('');

                if (!dob || !registrationNumber) {
                    if (!dob) $('#dobError').text('Date of birth is required.');
                    if (!registrationNumber) $('#registrationError').text(
                        'Registration number is required.');
                    return;
                }

                // Disable the submit button while processing
                $('#submitBtn').prop('disabled', true).text('Processing...');

                // Redirect to the route
                let route = `{{ url('/admit-card') }}/${dob}/${registrationNumber}`;
                window.location.href = route;
            });

        });
    </script>
@endpush

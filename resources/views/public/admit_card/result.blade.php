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
                        <h1 class="display-5 fw-bold text-start" data-aos="fade-right" data-aos-duration="1500">Check Result
                        </h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500"> Lorem ipsum dolor sit amet
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
                    <span><i class="fa-solid fa-angles-right"></i> Result</span>
                    <h2>Check Your Result</h2>
                </div>
                <form id="resultForm" class="mt-4">
                    @csrf
                    <div class="border p-4 rounded-3 border-1">
                        <div>
                            <label for="">Enter Date of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob">
                            <span class="text-danger" id="dobError"></span>
                        </div>
                        <div class="mt-3">
                            <label for="">Registration No.</label>
                            <input type="text" class="form-control" name="registration_number" id="registration_number"
                                placeholder="xxxxxx">
                            <span class="text-danger" id="registrationError"></span>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" type="button" id="checkResultBtn">
                                <i class="fa-regular fa-circle-check"></i> Check Now
                            </button>
                        </div>
                    </div>
                </form>


            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-duration="1500">
                <img src="{{ asset('frontend/img/exam-results.png') }}" class="w-100 image-fluid"
                    style="max-height:350px;object-fit: contain;" alt="Result Image" loading="lazy">
            </div>
        </div>


    </section>
@endsection



@push('script')
    <script>
        $(document).ready(function() {
            $('#checkResultBtn').on('click', function() {
                const $button = $(this); // Cache the button element
                const defaultText = $button.html(); // Store default button text

                // Prepare form data
                const formData = {
                    dob: $('#dob').val(),
                    registration_number: $('#registration_number').val(),
                    _token: $('input[name="_token"]').val(),
                };

                // Clear previous error messages
                $('#dobError').text('');
                $('#registrationError').text('');

                // Disable the button and show loading text
                $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Checking...');

                $.ajax({
                    url: '{{ route('my-result') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Restore button to default state
                        $button.prop('disabled', false).html(defaultText);

                        if (response.success) {
                            // Dynamic Swal design based on result
                            const isPass = response.result.toLowerCase() === 'pass';

                            Swal.fire({
                                title: isPass ? '🎉 Congratulations!' :
                                    'Better Luck Next Time!',
                                html: `
                            <p style="font-size: 16px;"><strong>Marks:</strong> ${response.marks}</p>
                            <p style="font-size: 16px;"><strong>Result:</strong> ${response.result.toUpperCase()}</p>
                        `,
                                icon: isPass ? 'success' : 'error',
                                confirmButtonText: isPass ? 'Celebrate 🎊' :
                                    'Close',
                                customClass: {
                                    popup: isPass ?
                                        'swal-popup-pass' // CSS class for pass design
                                        :
                                        'swal-popup-fail', // CSS class for fail design
                                },
                            });
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;

                        // Restore button to default state
                        $button.prop('disabled', false).html(defaultText);

                        if (errors) {
                            // Display validation errors
                            if (errors.dob) {
                                $('#dobError').text(errors.dob[0]);
                            }
                            if (errors.registration_number) {
                                $('#registrationError').text(errors.registration_number[0]);
                            }
                        } else {
                            // General error message
                            Swal.fire({
                                title: 'Error',
                                text: xhr.responseJSON.error ||
                                    'An error occurred. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    },
                });
            });
        });
    </script>
@endpush



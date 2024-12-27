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
                <form id="admitCardForm" action="{{ route('my-admit-card') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="border p-4 rounded-3 border-1" style="max-width: 600px;">
                        <div>
                            <label for="">Enter Date of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob">
                            <span id="dobError" class="text-danger"></span>
                        </div>
                        <div class="mt-3">
                            <label for="">Registration No.</label>
                            <input type="text" class="form-control" name="registration_number" id="registration_number"
                                placeholder="xxxxxx">
                            <span id="registrationError" class="text-danger"></span>
                        </div>
                        <div class="mt-3">
                            <button id="downloadBtn" class="btn btn-primary" type="submit"><i
                                    class="fa-solid fa-download"></i> Download</button>
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
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Disable the button
                $('#downloadBtn').prop('disabled', true).text('Downloading...');

                // Clear previous error messages
                $('#dobError').text('');
                $('#registrationError').text('');

                // Get form data
                var formData = {
                    dob: $('#dob').val(),
                    registration_number: $('#registration_number').val(),
                    _token: $('input[name="_token"]').val() // CSRF token
                };

                // Send the AJAX request
                $.ajax({
                    url: "{{ route('my-admit-card') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.downloadUrl) {
                            // Trigger the download using the URL returned from the server
                            var a = document.createElement('a');
                            a.href = response.downloadUrl;
                            a.download = ''; // You can set a filename here, if necessary
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Your admit card is being downloaded.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        // Re-enable the button and update the text to 'Download'
                        $('#downloadBtn').prop('disabled', false).text('Download');
                    },
                    error: function(xhr) {
                        // Handle validation or server-side errors
                        var errors = xhr.responseJSON.errors;

                        if (errors) {
                            if (errors.dob) {
                                $('#dobError').text(errors.dob[0]);
                            }
                            if (errors.registration_number) {
                                $('#registrationError').text(errors.registration_number[0]);
                            }
                        }

                        // If the error is "Admit card not found", display a custom message
                        if (xhr.responseJSON.error === 'Admit card not found.') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Admit card not found. Please check the registration number or DOB and try again.',
                            });
                        } else {
                            // Handle any other error (e.g., file not found)
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON.error ||
                                    'An error occurred. Please try again.',
                            });
                        }

                        // Re-enable the button and update the text to 'Download'
                        $('#downloadBtn').prop('disabled', false).text('Download');
                    }
                });
            });
        });
    </script>
@endpush

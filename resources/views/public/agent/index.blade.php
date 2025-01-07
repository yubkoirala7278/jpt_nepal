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
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Agent Registration
                        </h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500"> Lorem ipsum dolor sit amet
                            consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-5" data-aos="fade-right" data-aos-duration="1500">
        <div class="card shadow-sm rounded p-4">
            <h2 class="text-center mb-4">Agent Registration</h2>
            <form method="POST" enctype="multipart/form-data" id="consultancyForm">
                @csrf
                <input type="hidden" name="disabled_reason"
                    value="Your consultancy has been successfully created but is temporarily blocked. It will only become active once it has been approved and activated by the test center. Please await confirmation from the test center, after which you will be notified when your consultancy is fully activated and available for use. Thank you for your patience!" />

                <!-- Consultancy Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Consultancy Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter Consultancy Name" value="{{ old('name') }}">
                    <span class="text-danger" id="error-name"></span>
                </div>

                <!-- Owner/Proprietor Name -->
                <div class="mb-3">
                    <label for="owner_name" class="form-label">Owner/Proprietor Name</label>
                    <input type="text" class="form-control" id="owner_name" name="owner_name"
                        placeholder="Enter Proprietor Name" value="{{ old('owner_name') }}">
                    <span class="text-danger" id="error-owner_name"></span>
                </div>

                <!-- Phone Number -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone"
                        placeholder="Enter Phone Number" value="{{ old('phone') }}">
                    <span class="text-danger" id="error-phone"></span>
                </div>

                <!-- Mobile Number -->
                <div class="mb-3">
                    <label for="mobile_number" class="form-label">Mobile Number</label>
                    <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                        placeholder="Enter Mobile Number" value="{{ old('mobile_number') }}">
                    <span class="text-danger" id="error-mobile_number"></span>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address"
                        value="{{ old('address') }}">
                    <span class="text-danger" id="error-address"></span>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@agent.com"
                        value="{{ old('email') }}">
                    <span class="text-danger" id="error-email"></span>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter Password">
                    <span class="text-danger" id="error-password"></span>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm Password">
                    <span class="text-danger" id="error-password_confirmation"></span>
                </div>

                <!-- Logo Upload -->
                <div class="mb-3">
                    <label for="logo" class="form-label">Upload Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo"
                        accept="image/jpeg, image/png, image/jpg,image/gif,image/webp,image/svg">
                    <span class="text-danger" id="error-logo"></span>
                </div>

                <!-- Test Center -->
                <div class="mb-3">
                    <label for="test_center" class="form-label">Assign Test Center</label>
                    <select class="form-select" name="test_center">
                        <option selected disabled>Assign Test Center</option>
                        @foreach ($testCenters as $testCenter)
                            <option value="{{ $testCenter->user->id }}"
                                {{ old('test_center') == $testCenter->user->id ? 'selected' : '' }}>
                                {{ $testCenter->user->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="error-test_center"></span>
                </div>

                <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
            </form>
        </div>
    </section>
@endsection

@section('modal')
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Toggle visibility for password field
            $('#togglePassword').click(function() {
                var passwordField = $('#password');
                var icon = $(this).find('i');

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Toggle visibility for password confirmation field
            $('#togglePasswordConfirm').click(function() {
                var passwordFieldConfirm = $('#password_confirmation');
                var icon = $(this).find('i');

                if (passwordFieldConfirm.attr('type') === 'password') {
                    passwordFieldConfirm.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordFieldConfirm.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#consultancyForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Disable the submit button and show loading text
                $('#submitButton').prop('disabled', true).text('Submitting...');

                // Clear previous error messages
                $('.text-danger').text('');

                // Send the form data using AJAX
                $.ajax({
                    url: "{{ route('agent.store') }}", // Adjust route if needed
                    method: "POST",
                    data: new FormData(this), // Send form data (including file upload)
                    contentType: false, // Important for file uploads
                    processData: false, // Important for file uploads
                    success: function(response) {
                        // Enable submit button and reset text
                        $('#submitButton').prop('disabled', false).text('Submit');

                        // Show a success message (you can customize this)
                        Swal.fire({
                            icon: 'success',
                            title: 'Consultancy Created!',
                            text: response.message, // Customizable message
                        });
                    },
                    error: function(response) {
                        // Enable submit button and reset text
                        $('#submitButton').prop('disabled', false).text('Submit');

                        // Check if there are validation errors
                        if (response.responseJSON.errors) {
                            $.each(response.responseJSON.errors, function(key, value) {
                                // Display each error below the respective form field
                                $('#error-' + key).text(value[0]);
                            });
                        } else {
                            // Display a general error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.responseJSON.message ||
                                    'Something went wrong, please try again.',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush

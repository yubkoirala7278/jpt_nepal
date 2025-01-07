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
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Student Registration
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
            <h2 class="text-center mb-4">Student Registration</h2>
            <form id="registration-form" enctype="multipart/form-data">
                @csrf
                <!-- Exam Date -->
                <div class="mb-3">
                    <label for="exam_date" class="form-label">Upcoming Exam Date</label>
                    <select class="form-select" id="exam_date" name="exam_date">
                        <option selected disabled>Select Exam Date</option>
                        @foreach ($examDates as $examDate)
                            <option value="{{ $examDate->id }}" {{ old('exam_date') == $examDate->id ? 'selected' : '' }}>
                                {{ $examDate->exam_date }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text exam_date-error"></span>
                </div>

                <!-- Test Center -->
                <div class="mb-3">
                    <label for="test_center" class="form-label">Available Test Center</label>
                    <select class="form-select" id="test_center" name="test_center">
                        <option selected disabled>Select Test Center</option>
                        @foreach ($testCenters as $testCenter)
                            <option value="{{ $testCenter->id }}"
                                {{ old('test_center') == $testCenter->id ? 'selected' : '' }}>
                                {{ $testCenter->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text test_center-error"></span>
                </div>
                <!-- Applicant Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Student Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter your full name" value="{{ old('name') }}">
                    <span class="text-danger error-text name-error"></span>
                </div>

                <!-- Date of Birth -->
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
                    <span class="text-danger error-text dob-error"></span>
                </div>

                {{-- Nationality --}}
                <div class="mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <select class="form-select" id="nationality" name="nationality">
                        <option selected disabled>Select your nationality</option>
                        @foreach ($nationalities as $nationality)
                            <option value="{{ $nationality->name }}"
                                {{ old('nationality') == $nationality->name ? 'selected' : '' }}>
                                {{ $nationality->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text nationality-error"></span>
                </div>

                {{-- Gender --}}
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div class="d-flex align-items-center" style="column-gap: 20px;">
                        <div>
                            <input type="radio" id="gender_male" name="gender" value="male">
                            <label for="gender_male">Male</label>
                        </div>
                        <div>
                            <input type="radio" id="gender_female" name="gender" value="female">
                            <label for="gender_female">Female</label>
                        </div>
                        <div>
                            <input type="radio" id="gender_other" name="gender" value="other">
                            <label for="gender_other">Other</label>
                        </div>
                    </div>
                    <span class="text-danger error-text gender-error"></span>
                </div>


                <!-- Address -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address"
                        value="{{ old('address') }}">
                    <span class="text-danger error-text address-error"></span>
                </div>



                <!-- Phone Number -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        placeholder="Enter Phone Number" value="{{ old('phone') }}">
                    <span class="text-danger error-text phone-error"></span>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter Email Address" value="{{ old('email') }}">
                    <span class="text-danger error-text email-error"></span>
                </div>
                <!-- Applicant Profile -->
                <div class="mb-3">
                    <label for="profile" class="form-label">Student PP Size Photo</label>
                    <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
                    <span class="text-danger error-text profile-error"></span>
                </div>


                <!-- Citizenship/Passport -->
                <div class="mb-3">
                    <label for="citizenship" class="form-label">Upload Citizenship/Passport</label>
                    <input type="file" class="form-control" id="citizenship" name="citizenship"
                        accept="image/*,application/pdf">
                    <span class="text-danger error-text citizenship-error"></span>
                </div>

                <!-- Payment Option -->
                <div class="mb-3">
                    <label class="form-label">Payment Option</label>
                    <div class="d-flex align-items-center" style="column-gap: 20px">
                        <div>
                            <input type="radio" id="pay_now" name="payment_option" value="pay_now" checked>
                            <label for="pay_now">Pay Now</label>
                        </div>
                        <div>
                            <input type="radio" id="pay_later" name="payment_option" value="pay_later">
                            <label for="pay_later">Pay Later</label>
                        </div>
                    </div>
                </div>

                <!-- Account Details Section -->
                <div id="account_section" class="mb-3 p-4 rounded shadow-sm" style="display: none; background: #f8f9fa;">
                    <div class="text-center">
                        <img src="{{asset('frontend/img/qr.png')}}" alt="Account QR" loading="lazy" class="img-fluid mb-3 rounded" style="max-width: 200px;">
                    </div>
                    <div class="text-center">
                        <p class="fw-bold mb-1" style="font-size: 1.2rem;">Account Number:</p>
                        <p class="text-primary fs-5">9876543217728</p>
                        <p class="fw-bold mb-1" style="font-size: 1.2rem;">Account Name:</p>
                        <p class="text-secondary fs-5">Japanese Proficiency Test</p>
                    </div>
                </div>
                

                <!-- Receipt Section -->
                <div id="receipt_section" class="mb-3" style="display: none;">
                    <label for="receipt_image" class="form-label">Upload Receipt</label>
                    <input type="file" class="form-control" id="receipt_image" name="receipt_image"
                        accept="image/jpeg, image/png, image/jpg, image/gif, image/webp, image/svg" />
                    <span class="text-danger error-text receipt_image-error"></span>
                </div>

                <!-- Amount Section -->
                <div id="amount_section" class="mb-3" style="display: none;">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount"
                        placeholder="Enter Receipt Amount" value="{{ old('amount') }}">
                    <span class="text-danger error-text amount-error"></span>
                </div>
                <!-- Previous Exam -->
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_appeared_previously"
                            name="is_appeared_previously" value="1"
                            {{ old('is_appeared_previously') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_appeared_previously">
                            I have appeared for an exam previously.
                        </label>
                    </div>
                    <span class="text-danger error-text is_appeared_previously-error"></span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success" id="submit-btn">Next</button>
            </form>
        </div>
    </section>
@endsection

@section('modal')
    <div class="modal fade" id="confirmation-modal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Summary of form data will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirm-submit">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#registration-form').on('submit', function(e) {
                e.preventDefault();

                // Fetch the form and create FormData
                let form = $(this)[0];
                let formData = new FormData(form);

                // Proceed with actual submission
                $('#submit-btn').attr('disabled', true).text('Proceeding...');

                // First validation AJAX request
                $.ajax({
                    url: "{{ route('public.student.validate') }}", // Update this route to match your validation logic
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        // Display the form data in a confirmation modal
                        let summaryHtml = `
                    <ul>
                        <li><strong>Applicant Name:</strong> ${response.data.name}</li>
                        <li><strong>Address:</strong> ${response.data.address}</li>
                        <li><strong>Phone Number:</strong> ${response.data.phone}</li>
                        <li><strong>Date of Birth:</strong> ${response.data.dob}</li>
                        <li><strong>Email Address:</strong> ${response.data.email}</li>
                        <li><strong>Amount:</strong> ${response.data.amount}</li>
                        <li><strong>Exam Date:</strong> ${response.data.exam_date}</li>
                         <li><strong>Nationality:</strong> ${response.data.nationality}</li>
                         <li><strong>Gender:</strong> ${response.data.gender}</li>
                        <li><strong>Test Center:</strong> ${response.data.test_center}</li>
                        <li><strong>Previously Appeared:</strong> ${response.data.is_appeared_previously ? 'Yes' : 'No'}</li>
                    </ul>
                `;
                        $('#confirmation-modal .modal-body').html(summaryHtml);
                        $('#confirmation-modal').modal('show');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-text').text(''); // Clear all previous errors
                            for (let field in errors) {
                                $(`.${field}-error`).text(errors[field][0]);
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    },
                    complete: function() {
                        $('#submit-btn').attr('disabled', false).text('Proceed');
                    }
                });
            });

            // Confirm button in modal
            $('#confirm-submit').on('click', function() {
                let form = $('#registration-form')[0];
                let formData = new FormData(form);

                // Proceed with actual submission
                $('#confirm-submit').attr('disabled', true).text('Submitting...');

                $.ajax({
                    url: "{{ route('public.student.store') }}", // Actual submission route
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Registration successfully done!',
                            timer: 3000,
                            showConfirmButton: false,
                        });
                        $('#registration-form')[0].reset();
                        $('.error-text').text(''); // Clear all error messages
                        $('#confirmation-modal').modal('hide');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    },
                    complete: function() {
                        $('#confirm-submit').attr('disabled', false).text('Submit');
                    }
                });
            });
        });
    </script>
    <script>
        function updateVisibility() {
            const receiptSection = document.getElementById('receipt_section');
            const accountSection = document.getElementById('account_section');
            const amountSection = document.getElementById('amount_section');
            const selectedOption = document.querySelector('input[name="payment_option"]:checked').value;

            if (selectedOption === 'pay_now') {
                receiptSection.style.display = 'block';
                amountSection.style.display = 'block';
                accountSection.style.display = 'block';
            } else {
                // Hide sections
                receiptSection.style.display = 'none';
                amountSection.style.display = 'none';
                accountSection.style.display = 'none';

                // Reset values
                document.getElementById('amount').value = ''; // Reset amount
                document.getElementById('receipt_image').value = ''; // Reset receipt image
            }
        }

        // Add event listeners for changes in the radio buttons
        document.querySelectorAll('input[name="payment_option"]').forEach(radio => {
            radio.addEventListener('change', updateVisibility);
        });

        // Set the visibility on page load
        document.addEventListener('DOMContentLoaded', updateVisibility);
    </script>
@endpush

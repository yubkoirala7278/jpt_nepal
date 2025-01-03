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
                    <option value="{{ $examDate->id }}" {{ old('exam_date')==$examDate->id ? 'selected' : '' }}>
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
                    <option value="{{ $testCenter->id }}" {{ old('test_center')==$testCenter->id ? 'selected' : '' }}>
                        {{ $testCenter->name }}
                    </option>
                    @endforeach
                </select>
                <span class="text-danger error-text test_center-error"></span>
            </div>
            <!-- Applicant Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name"
                    value="{{ old('name') }}">
                <span class="text-danger error-text name-error"></span>
            </div>
            <!-- Date of Birth -->
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
                <span class="text-danger error-text dob-error"></span>
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
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                    value="{{ old('phone') }}">
                <span class="text-danger error-text phone-error"></span>
            </div>



            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address"
                    value="{{ old('email') }}">
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
                <label for="citizenship" class="form-label">Citizenship/Passport</label>
                <input type="file" class="form-control" id="citizenship" name="citizenship"
                    accept="image/*,application/pdf">
                <span class="text-danger error-text citizenship-error"></span>
            </div>
            
              <!-- Receipt -->
              <div class="mb-3">
                <label for="receipt_image" class="form-label">Upload Receipt</label>
                <input type="file" class="form-control" id="receipt_image" name="receipt_image" accept="image/*">
                <span class="text-danger error-text receipt_image-error"></span>
            </div>

            <!-- Amount -->
            <div class="mb-3">
                <label for="amount" class="form-label">Receipt Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Receipt Amount"
                    value="{{ old('amount') }}">
                <span class="text-danger error-text amount-error"></span>
            </div>

            <!-- Previous Exam -->
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_appeared_previously"
                        name="is_appeared_previously" value="1" {{ old('is_appeared_previously') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_appeared_previously">
                        I have appeared for an exam previously.
                    </label>
                </div>
                <span class="text-danger error-text is_appeared_previously-error"></span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success" id="submit-btn">Proceed</button>
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
@endpush
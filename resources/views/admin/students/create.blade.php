@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Add New Applicant</h2>
    <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exam_date" class="form-label">Select Exam Date</label>
            <select class="form-select" name="exam_date">
                <option selected disabled>Select Exam Date</option>
                @if (count($examDates) > 0)
                    @foreach ($examDates as $examDate)
                        <option value="{{ $examDate->id }}" {{ old('exam_date') == $examDate->id ? 'selected' : '' }}>
                            {{ $examDate->exam_date }}</option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('exam_date'))
                <span class="text-danger">{{ $errors->first('exam_date') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Student Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Applicant Name"
                value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter Applicant DOB"
                value="{{ old('dob') }}">
            @if ($errors->has('dob'))
                <span class="text-danger">{{ $errors->first('dob') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <select class="form-select" name="nationality">
                <option selected disabled>Select Nationality</option>
                @if (count($nationalities) > 0)
                    @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality->name }}" 
                            {{ old('nationality') == $nationality->name ? 'selected' : '' }}>
                            {{ $nationality->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('nationality'))
                <span class="text-danger">{{ $errors->first('nationality') }}</span>
            @endif
        </div>
        

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <div class="d-flex align-items-center" style="column-gap: 20px;">
                <div>
                    <input type="radio" id="gender_male" name="gender" value="male"
                        {{ old('gender') == 'male' ? 'checked' : '' }}>
                    <label for="gender_male">Male</label>
                </div>
                <div>
                    <input type="radio" id="gender_female" name="gender" value="female"
                        {{ old('gender') == 'female' ? 'checked' : '' }}>
                    <label for="gender_female">Female</label>
                </div>
                <div>
                    <input type="radio" id="gender_other" name="gender" value="other"
                        {{ old('gender') == 'other' ? 'checked' : '' }}>
                    <label for="gender_other">Other</label>
                </div>
            </div>
            @if ($errors->has('gender'))
                <span class="text-danger">{{ $errors->first('gender') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Examinee Category</label>
            <select class="form-select" name="examinee_category">
                <option selected disabled>Select Examinee Category</option>
                <option value="Student" {{ old('examinee_category') == 'Student' ? 'selected' : '' }}>Student</option>
                <option value="General" {{ old('examinee_category') == 'General' ? 'selected' : '' }}>General</option>
            </select>
            @if ($errors->has('examinee_category'))
                <span class="text-danger">{{ $errors->first('examinee_category') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Exam Category</label>
            <select class="form-select" name="exam_category">
                <option selected disabled>Select Exam Category</option>
                <option value="Regular period" {{ old('exam_category') == 'Regular period' ? 'selected' : '' }}>Regular period</option>
                <option value="Any time" {{ old('exam_category') == 'Any time' ? 'selected' : '' }}>Any time</option>
            </select>
            @if ($errors->has('exam_category'))
                <span class="text-danger">{{ $errors->first('exam_category') }}</span>
            @endif
        </div>


        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Student Address"
                value="{{ old('address') }}">
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>



        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone"
                placeholder="Enter Applicant Phone Number" value="{{ old('phone') }}">
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email"
                placeholder="Enter Applicant Email Address" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="profile" class="form-label">Upload Applicant Photo</label>
            <input type="file" class="form-control" id="profile" name="profile"
                accept="image/jpeg, image/png, image/jpg,image/gif,image/webp,image/svg" />
            @if ($errors->has('profile'))
                <span class="text-danger">{{ $errors->first('profile') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="citizenship" class="form-label">Upload Citizenship/Passport</label>
            <input type="file" class="form-control" id="citizenship" name="citizenship"
                accept="image/jpeg, image/png, image/jpg, image/gif, image/webp, image/svg+xml, application/pdf" />
            @if ($errors->has('citizenship'))
                <span class="text-danger">{{ $errors->first('citizenship') }}</span>
            @endif
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
        {{-- account details --}}
        @if($account)
        <div id="account_section"  class="mb-3 p-4 rounded shadow-sm" style="display: none; background: #f8f9fa;">

            <!-- Bank Information Section -->
            <div class="text-center mb-4">
                <p class="fw-bold mb-1" style="font-size: 1.5rem; color: #343a40;">Bank Name: <span class="text-primary">{{$account->bank_name}}</span></p>
                <p class="text-primary fs-4 mb-2">Account Name: <span class="fw-bold">{{$account->account_name}}</span></p>
                <p class="fw-bold mb-1" style="font-size: 1.5rem; color: #343a40;">Account Number: <span class="text-success">{{$account->account_number}}</span></p>
                <p class="text-secondary fs-5">Branch: <span class="fw-bold text-dark">{{$account->branch_name}}</span></p>
            </div>
        
            <!-- QR Code Section -->
            <div class="text-center">
                <img src="{{ asset($account->qr_code) }}" alt="Account QR" loading="lazy" class="img-fluid mb-3 rounded" style="max-width: 200px;">
            </div>
        </div>
        @endif
      

        <!-- Receipt Section -->
        <div id="receipt_section" class="mb-3" style="display: none;">
            <label for="receipt_image" class="form-label">Upload Receipt</label>
            <input type="file" class="form-control" id="receipt_image" name="receipt_image"
                accept="image/jpeg, image/png, image/jpg, image/gif, image/webp, image/svg" />
            @if ($errors->has('receipt_image'))
                <span class="text-danger">{{ $errors->first('receipt_image') }}</span>
            @endif
        </div>

        <!-- Amount Section -->
        {{-- <div id="amount_section" class="mb-3" style="display: none;">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Receipt Amount"
                value="{{ old('amount') }}">
            @if ($errors->has('amount'))
                <span class="text-danger">{{ $errors->first('amount') }}</span>
            @endif
        </div> --}}

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_appeared_previously"
                    name="is_appeared_previously" value="1" {{ old('is_appeared_previously') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_appeared_previously">
                    I have appeared for an exam previously.
                </label>
            </div>

            @if ($errors->has('is_appeared_previously'))
                <span class="text-danger">{{ $errors->first('is_appeared_previously') }}</span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('script')
    <script>
        function updateVisibility() {
            const receiptSection = document.getElementById('receipt_section');
            const accountSection = document.getElementById('account_section');
            const amountSection = document.getElementById('amount_section');
            const selectedOption = document.querySelector('input[name="payment_option"]:checked').value;

            if (selectedOption === 'pay_now') {
                receiptSection.style.display = 'block';
                accountSection.style.display = 'block';
                amountSection.style.display = 'block';
            } else {
                // Hide sections
                receiptSection.style.display = 'none';
                accountSection.style.display = 'none';
                amountSection.style.display = 'none';

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

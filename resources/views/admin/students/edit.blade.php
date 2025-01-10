@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Update Applicant</h2>
    <form action="{{ route('student.update', $student) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="exam_date" class="form-label">Select Exam Date</label>
            <select class="form-select" name="exam_date">
                <option selected disabled>Select Exam Date</option>
                @if (count($examDates) > 0)
                    @foreach ($examDates as $examDate)
                        <option value="{{ $examDate->id }}"
                            {{ old('exam_date', $student->exam_date_id) == $examDate->id ? 'selected' : '' }}>
                            {{ $examDate->exam_date }}
                        </option>
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
                value="{{ old('name', $student->name) }}">
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter Applicant DOB"
                value="{{ old('dob', $student->dob) }}">
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
                            {{ old('nationality', $student->nationality) == $nationality->name ? 'selected' : '' }}>
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
                        {{ old('gender', $student->gender) == 'male' ? 'checked' : '' }}>
                    <label for="gender_male">Male</label>
                </div>
                <div>
                    <input type="radio" id="gender_female" name="gender" value="female"
                        {{ old('gender', $student->gender) == 'female' ? 'checked' : '' }}>
                    <label for="gender_female">Female</label>
                </div>
                <div>
                    <input type="radio" id="gender_other" name="gender" value="other"
                        {{ old('gender', $student->gender) == 'other' ? 'checked' : '' }}>
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
                <option disabled {{ old('examinee_category', $student->examinee_category) ? '' : 'selected' }}>Select Examinee Category</option>
                <option value="Student" {{ old('examinee_category', $student->examinee_category) == 'Student' ? 'selected' : '' }}>Student</option>
                <option value="General" {{ old('examinee_category', $student->examinee_category) == 'General' ? 'selected' : '' }}>General</option>
            </select>
            @if ($errors->has('examinee_category'))
                <span class="text-danger">{{ $errors->first('examinee_category') }}</span>
            @endif
        </div>
        

        <div class="mb-3">
            <label class="form-label">Exam Category</label>
            <select class="form-select" name="exam_category">
                <option disabled {{ old('exam_category', $student->exam_category) ? '' : 'selected' }}>Select Exam Category</option>
                <option value="Regular period" {{ old('exam_category', $student->exam_category) == 'Regular period' ? 'selected' : '' }}>Regular period</option>
                <option value="Any time" {{ old('exam_category', $student->exam_category) == 'Any time' ? 'selected' : '' }}>Any time</option>
            </select>
            @if ($errors->has('exam_category'))
                <span class="text-danger">{{ $errors->first('exam_category') }}</span>
            @endif
        </div>
        
        
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Applicant Address"
                value="{{ old('address', $student->address) }}">
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone"
                placeholder="Enter Applicant Phone Number" value="{{ old('phone', $student->phone) }}">
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email"
                placeholder="Enter Applicant Email Address" value="{{ old('email', $student->email) }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="profile" class="form-label">Upload Applicant Profile</label>
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

        {{-- <!-- Payment Option -->
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
        </div> --}}

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
        <div id="amount_section" class="mb-3" style="display: none;">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Receipt Amount"
                value="{{ old('amount', $student->amount) }}">
            @if ($errors->has('amount'))
                <span class="text-danger">{{ $errors->first('amount') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_appeared_previously"
                    name="is_appeared_previously"
                    {{ old('is_appeared_previously', $student->is_appeared_previously) ? 'checked' : '' }}>
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
       // ======logic to tpggle pay now and pay later option========
        function updateVisibility() {
            const receiptSection = document.getElementById('receipt_section');
            const amountSection = document.getElementById('amount_section');
            const selectedOption = document.querySelector('input[name="payment_option"]:checked').value;

            if (selectedOption === 'pay_now') {
                receiptSection.style.display = 'block';
                amountSection.style.display = 'block';
            } else {
                receiptSection.style.display = 'none';
                amountSection.style.display = 'none';
            }
        }

        // Add event listeners for changes in the radio buttons
        document.querySelectorAll('input[name="payment_option"]').forEach(radio => {
            radio.addEventListener('change', updateVisibility);
        });

        // Set the visibility on page load
        document.addEventListener('DOMContentLoaded', updateVisibility);
          // ======end of logic to tpggle pay now and pay later option========
    </script>
@endpush

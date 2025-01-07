@extends('admin.layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2>Applicant Details</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('student.index') }}">Back</a>
    </div>

    <div class="row" style="row-gap: 20px">
        <!-- Left Column: Basic Information -->
        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-body">
                    <h5 class="card-title mark px-2 rounded-2">Student Information</h5>
                    <p><strong>Name:</strong> {{ $student->name }}</p>
                    <p><strong>Email:</strong> {{ $student->email }}</p>
                    <p><strong>Phone Number:</strong> {{ $student->phone }}</p>
                    <p><strong>Address:</strong> {{ $student->address }}</p>
                    <p><strong>Date of Birth:</strong> {{ $student->dob }}</p>
                    <p><strong>Is Appeared Previously:</strong> {{ $student->is_appeared_previously ? 'Yes' : 'No' }}</p>
                    <p class="mt-4"><strong>Registration Number:</strong> {{ $student->slug }}</p>
                    <p class="mt-4"><strong>Gender:</strong> {{ $student->gender }}</p>
                    <p class="mt-4"><strong>Nationality:</strong> {{ $student->nationality }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge {{ $student->status ? 'bg-success' : 'bg-danger' }}">
                            {{ $student->status ? 'Approved' : 'Pending' }}
                        </span>
                    </p>
                    @if (Auth::user()->hasRole('test_center_manager'))
                        <div class="mt-4">
                            <h6 class="mb-3 fw-bold">Change Status</h6>
                            <form method="POST" action="{{ route('update.status', $student->slug) }}">
                                @csrf
                                @method('PUT')
                                <div class="input-group mb-3">
                                    <select class="form-select" name="status" aria-label="Change Status">
                                        <option selected disabled>Select Status</option>
                                        <option value="1"
                                            {{ old('status') == '1' ? 'selected' : ($student->status == 1 ? 'selected' : '') }}>
                                            Approved</option>
                                        <option value="0"
                                            {{ old('status') == '0' ? 'selected' : ($student->status == 0 ? 'selected' : '') }}>
                                            Pending</option>
                                    </select>
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                                @if ($errors->has('status'))
                                    <div class="text-danger">{{ $errors->first('status') }}</div>
                                @endif
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-body">
                    <h5 class="card-title mark px-2 rounded-2">Documents</h5>

                    <div class="mb-3">
                        <strong>Profile Image:</strong>
                        <div class="text-center">
                            <img src="{{ asset($student->profile) }}" alt="Applicant Profile" class="img-fluid"
                                style="max-height: 300px; object-fit: cover;cursor:pointer" data-bs-toggle="modal"
                                data-bs-target="#imageModal" data-bs-image="{{ asset($student->profile) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Receipt Image:</strong>
                        <div class="text-center">
                            <img src="{{ asset($student->receipt_image) }}" alt="Not Available" class="img-fluid"
                                style="max-height: 300px; object-fit: cover;cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#imageModal" data-bs-image="{{ asset($student->receipt_image) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Citizenship/Passport</strong>
                        <div class="text-center">
                            @php
                                $fileExtension = pathinfo($student->citizenship, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp', 'svg']))
                                <img src="{{ asset($student->citizenship) }}" alt="Not Available" class="img-fluid"
                                    style="max-height: 300px; object-fit: cover;cursor: pointer;" data-bs-toggle="modal"
                                    data-bs-target="#imageModal" data-bs-image="{{ asset($student->citizenship) }}">
                            @elseif ($fileExtension === 'pdf')
                                <iframe src="{{ asset($student->citizenship) }}" style="width: 100%; height: 300px;"
                                    frameborder="0"></iframe>
                                <!-- Or display a download link -->
                                <a href="{{ asset($student->citizenship) }}" target="_blank"
                                    class="btn btn-primary mt-2">View PDF</a>
                            @else
                                <p>File not available</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-body">
                    <h5 class="card-title mark px-2  rounded-2">Exam Details</h5>
                    <p><strong>Exam Date:</strong> {{ $student->exam_date->exam_date }}</p>
                    <p><strong>Exam Duration:</strong>
                        {{ \Carbon\Carbon::parse($student->exam_date->exam_start_time)->format('h:i A') }} to
                        {{ \Carbon\Carbon::parse($student->exam_date->exam_end_time)->format('h:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3 h-100">
                <div class="card-body">
                    <h5 class="card-title mark px-2 rounded-2">Consultancy Information</h5>
                    <p><strong>Consultancy Name:</strong> {{ $student->user->name }}</p>
                    <p><strong>Consultancy Address:</strong> {{ $student->user->consultancy->address??$student->user->test_center->address }}</p>
                    <p><strong>Consultancy Email:</strong> {{ $student->user->email }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    {{-- modal to display receipt image or profile image --}}
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Not Available" class="img-fluid"
                        style="max-height: 500px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // JavaScript to handle the image change in the modal
        var modalImage = document.getElementById('modalImage');
        var imageElements = document.querySelectorAll('[data-bs-toggle="modal"]');

        imageElements.forEach(function(imgElement) {
            imgElement.addEventListener('click', function() {
                var imageUrl = this.getAttribute('data-bs-image');
                modalImage.src = imageUrl;
            });
        });
    </script>
@endpush

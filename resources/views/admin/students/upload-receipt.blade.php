@extends('admin.layouts.master')

@section('header-links')
    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .preview-wrapper {
            display: inline-block;
            position: relative;
        }

        .preview-wrapper img {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .remove-icon {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px !important;
            cursor: pointer;
            font-size: 20px !important;
            line-height: 14px;
            text-align: center;
            width: 20px;
            height: 20px;
        }
    </style>
@endsection

@section('content')
    <h2 class="mb-3">Upload Receipt</h2>
    <form action="{{ route('store.receipt') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- account details --}}
        @if ($account)
            <div id="account_section" class="mb-3 p-4 rounded shadow-sm" style=" background: #f8f9fa;">
                <!-- Bank Information Section -->
                <div class="text-center mb-4">
                    <p class="fw-bold mb-1" style="font-size: 1.5rem; color: #343a40;">Bank Name: <span
                            class="text-primary">{{$account->bank_name}}</span></p>
                    <p class="text-primary fs-4 mb-2">Account Name: <span class="fw-bold">{{$account->account_name}}</span>
                    </p>
                    <p class="fw-bold mb-1" style="font-size: 1.5rem; color: #343a40;">Account Number: <span
                            class="text-success">{{$account->account_number}}</span></p>
                    <p class="text-secondary fs-5">Branch: <span class="fw-bold text-dark">{{$account->branch_name}}</span></p>
                </div>

                <!-- QR Code Section -->
                <div class="text-center">
                    <img src="{{ asset('frontend/img/qr.png') }}" alt="Account QR" loading="lazy"
                        class="img-fluid mb-3 rounded" style="max-width: 200px;">
                </div>
            </div>
        @endif
        <div class="mb-3">
            <label for="receipt_image" class="form-label">Upload Receipt</label>
            <input type="file" class="form-control" id="receipt_image" name="receipt_image"
                accept="image/jpeg, image/png, image/jpg, image/webp, image/svg+xml" />
            @if ($errors->has('receipt_image'))
                <span class="text-danger">{{ $errors->first('receipt_image') }}</span>
            @endif
            <div id="image_preview" class="position-relative mt-3">
                <!-- Image preview and remove icon will appear here -->
            </div>
        </div>

        <div class="mb-3">
            <label for="students" class="form-label">Select Students</label>
            <select class="form-select" name="students[]" id="students" multiple>
                @if (count($students) > 0)
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}"
                            {{ is_array(old('students')) && in_array($student->id, old('students')) ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @if ($errors->has('students'))
                <span class="text-danger">{{ $errors->first('students') }}</span>
            @endif
        </div>

        <!-- Amount Section -->
        <div class="mb-3">
            <label for="amount" class="form-label">Total Receipt Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Receipt Amount"
                value="{{ old('amount') }}">
            @if ($errors->has('amount'))
                <span class="text-danger">{{ $errors->first('amount') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        $(document).ready(function() {
            // ==========display receipt image when uploaded============
            $('#receipt_image').on('change', function(event) {
                var imagePreviewContainer = $('#image_preview');
                var file = this.files[0];

                // Clear previous preview
                imagePreviewContainer.empty();

                if (file) {
                    // Validate that the file is an image
                    var fileType = file.type;
                    var validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif',
                        'image/webp', 'image/svg+xml'
                    ];
                    if ($.inArray(fileType, validImageTypes) < 0) {
                        // Invalid file type
                        imagePreviewContainer.append(
                            '<p class="text-danger">Please upload a valid image file.</p>');
                        return;
                    }

                    // Create a FileReader to read the file
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        // Create the preview container
                        var previewWrapper = $('<div>', {
                            class: 'preview-wrapper position-relative',
                            style: 'display: inline-block;'
                        });

                        // Create the image element
                        var img = $('<img>', {
                            src: e.target.result,
                            alt: 'Receipt Preview',
                            class: 'img-fluid',
                            style: 'max-width: 100%; max-height: 200px;'
                        });

                        // Create the remove button
                        var removeBtn = $('<span>', {
                            class: 'remove-icon position-absolute',
                            style: 'top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 5px; cursor: pointer; font-size: 14px;',
                            text: '×',
                            click: function() {
                                $('#receipt_image').val(''); // Clear the file input
                                imagePreviewContainer.empty(); // Remove the preview
                            }
                        });

                        // Append the image and the remove button to the preview wrapper
                        previewWrapper.append(img).append(removeBtn);

                        // Append the preview wrapper to the preview container
                        imagePreviewContainer.append(previewWrapper);
                    }

                    // Read the image file as a data URL
                    reader.readAsDataURL(file);
                }
            });
            // ==========end of displaying receipt image when uploaded=======

            // ========display selected students from select field=============
            $('#students').select2({
                placeholder: 'Select Students',
                allowClear: true,
                closeOnSelect: false
            });

            // Add "Select All" functionality
            var selectAllOption = new Option('Select All', 'select_all', false, false);
            $('#students').prepend(selectAllOption); // Prepend "Select All" option

            // Handle "Select All" functionality
            $('#students').on('select2:select', function(e) {
                if (e.params.data.id === 'select_all') {
                    $('#students > option').prop('selected', true);
                    $('#students').trigger('change');
                }
            });

            // Handle deselecting "Select All" functionality
            $('#students').on('select2:unselect', function(e) {
                if (e.params.data.id === 'select_all') {
                    $('#students > option').prop('selected', false);
                    $('#students').trigger('change');
                }
            });
            // =======end of displaying selected students from selected field===
        });
    </script>
@endpush

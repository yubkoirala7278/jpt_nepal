@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Add New Consultancy</h2>
    <form action="{{ route('consultancy.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Consultancy Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Consultancy Name"
                value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="owner_name" class="form-label">Owner/Proprietor Name</label>
            <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Enter Proprietor Name"
                value="{{ old('owner_name') }}">
            @if ($errors->has('owner_name'))
                <span class="text-danger">{{ $errors->first('owner_name') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                value="{{ old('phone') }}">
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="tel" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number"
                value="{{ old('mobile_number') }}">
            @if ($errors->has('mobile_number'))
                <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address"
                value="{{ old('address') }}">
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@user.com"
                value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"
                    autocomplete="new-password">
                <span class="input-group-text" id="togglePassword"><i class="fas fa-eye"></i></span>
            </div>
            @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Enter Password">
                <span class="input-group-text" id="togglePasswordConfirm"><i class="fas fa-eye"></i></span>
            </div>
            @if ($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Upload Logo</label>
            <input type="file" class="form-control" id="logo" name="logo"
                accept="image/jpeg, image/png, image/jpg,image/gif,image/webp,image/svg" />
            @if ($errors->has('logo'))
                <span class="text-danger">{{ $errors->first('logo') }}</span>
            @endif
        </div>
        @if (Auth::user()->hasRole('admin'))
            <div class="mb-3">
                <label for="logo" class="form-label">Assign Test Center</label>
                <select class="form-select" aria-label="Default select example" name="test_center">
                    <option selected disabled>Assign Test Center</option>
                    @if (count($testCenters) > 0)
                        @foreach ($testCenters as $testCenter)
                            <option value="{{ $testCenter->user->id }}"
                                {{ old('test_center') == $testCenter->user->id ? 'selected' : '' }}>
                                {{ $testCenter->user->name }}
                            </option>
                        @endforeach
                    @endif

                </select>
                @if ($errors->has('test_center'))
                    <span class="text-danger">{{ $errors->first('test_center') }}</span>
                @endif
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
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
@endpush

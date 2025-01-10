@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Add New Test Center</h2>
    <form action="{{route('test_center.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Test Center Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Test Center Name" value="{{old('name')}}">
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="test_venue" class="form-label">Test Venue</label>
            <input type="text" class="form-control" id="test_venue" name="test_venue" placeholder="Enter Test Venue" value="{{old('test_venue')}}">
            @if ($errors->has('test_venue'))
                <span class="text-danger">{{ $errors->first('test_venue') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="venue_code" class="form-label">Venue Code</label>
            <input type="text" class="form-control" id="venue_code" name="venue_code" placeholder="Enter Venue Code" value="{{old('venue_code')}}">
            @if ($errors->has('venue_code'))
                <span class="text-danger">{{ $errors->first('venue_code') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="{{old('phone')}}" >
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="{{old('address')}}" >
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@user.com" value="{{old('email')}}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" autocomplete="new-password">
                <span class="input-group-text" id="togglePassword"><i class="fas fa-eye"></i></span>
            </div>
            @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
        
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                <span class="input-group-text" id="togglePasswordConfirm"><i class="fas fa-eye"></i></span>
            </div>
            @if ($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
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

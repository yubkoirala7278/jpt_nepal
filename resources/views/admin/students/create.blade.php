@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Add New Applicant</h2>
    <form action="{{route('student.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Applicant Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Applicant Name" value="{{old('name')}}">
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Applicant Address" value="{{old('address')}}">
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>
      
        <div class="mb-3">
            <label for="profile" class="form-label">Upload Applicant Profile</label>
            <input type="file" class="form-control" id="profile" name="profile" accept="image/jpeg, image/png, image/jpg,image/gif,image/webp,image/svg"/>
            @if ($errors->has('profile'))
                <span class="text-danger">{{ $errors->first('profile') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Applicant Phone Number" value="{{old('phone')}}">
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter Applicant DOB" value="{{old('dob')}}">
            @if ($errors->has('dob'))
                <span class="text-danger">{{ $errors->first('dob') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Applicant Email Address" value="{{old('email')}}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="receipt_image" class="form-label">Upload Receipt</label>
            <input type="file" class="form-control" id="receipt_image" name="receipt_image" accept="image/jpeg, image/png, image/jpg,image/gif,image/webp,image/svg"/>
            @if ($errors->has('receipt_image'))
                <span class="text-danger">{{ $errors->first('receipt_image') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_appeared_previously" name="is_appeared_previously" value="1">
                <label class="form-check-label" for="is_appeared_previously">
                    I have appeared for an exam previously.
                </label>
            </div>
        
            @if ($errors->has('is_appeared_previously'))
                <div class="text-danger">{{ $errors->first('is_appeared_previously') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('script')

@endpush

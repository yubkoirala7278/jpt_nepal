@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Add New Footer</h2>
    <form action="{{ route('footer.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="location" class="form-label">Address</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter Address"
                value="{{ old('location') }}">
            @if ($errors->has('location'))
                <span class="text-danger">{{ $errors->first('location') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                value="{{ old('phone') }}">
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address"
                value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" placeholder="Description.." name="description">{{old('description')}}</textarea>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection


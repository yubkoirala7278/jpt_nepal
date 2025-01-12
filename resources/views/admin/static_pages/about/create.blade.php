@extends('admin.layouts.master')

@section('content')
    <h2 class="mb-3">Add New</h2>
    <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title"
                value="{{ old('title') }}">
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="sub_title" class="form-label">Sub Title</label>
            <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Enter Sub Title"
                value="{{ old('sub_title') }}">
            @if ($errors->has('sub_title'))
                <span class="text-danger">{{ $errors->first('sub_title') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" placeholder="Description.." name="description" rows="7">{{old('description')}}</textarea>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image"
                accept="image/jpeg, image/png, image/jpg,image/gif,image/webp,image/svg" />
            @if ($errors->has('image'))
                <span class="text-danger">{{ $errors->first('image') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection


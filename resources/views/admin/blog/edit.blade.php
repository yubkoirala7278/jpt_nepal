@extends('admin.layouts.master')
@section('header-links')
{{-- CKEditor CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
@endsection

@section('content')
    <h2 class="mb-3">Update Blog</h2>
    <form action="{{ route('blog.update',$blog->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Blog Title"
                value="{{ old('title',$blog->title) }}">
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" placeholder="Description" id="message" name="description">{{ old('description',$blog->description) }}</textarea>
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
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <div class="d-flex align-items-center" style="column-gap: 20px">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="active" value="active"
                        {{ old('status', $blog->status) === 'active' ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">
                        Active
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive"
                        {{ old('status', $blog->status) === 'inactive' ? 'checked' : '' }}>
                    <label class="form-check-label" for="inactive">
                        Inactive
                    </label>
                </div>
            </div>
            @if ($errors->has('status'))
                <span class="text-danger">{{ $errors->first('status') }}</span>
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#message'), {
                    removePlugins: ['Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload',
                        'Indent', 'ImageUpload', 'MediaEmbed'
                    ]
                });
        });
    </script>
@endpush

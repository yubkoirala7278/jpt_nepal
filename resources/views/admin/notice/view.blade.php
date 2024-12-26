@extends('admin.layouts.master')


@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2>Notice Details</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('notice.index') }}">Back</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h2 class="text-center text-primary mb-4">{{ $notice->title }}</h2>
                    <div class="text-center mb-4">
                        <img src="{{ asset($notice->image) }}" alt="Notice Image" class="img-fluid rounded-3">
                    </div>
                    <p class="text-muted">{!! $notice->description !!}</p>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection

@section('modal')


@endsection

@push('script')
@endpush

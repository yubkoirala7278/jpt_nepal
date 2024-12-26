@extends('admin.layouts.master')

@section('content')
    @if (Auth::user()->hasRole('admin'))
        <div class="container text-center">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="custom-test-card-title">Test Centers</h2>
                            <p class="custom-test-card-count">{{ $totalTestCenter ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="custom-test-card-title">Education Consultancy</h2>
                            <p class="custom-test-card-count">{{ $totalEducationConsultancy ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="custom-test-card-title">Applicants</h2>
                            <p class="custom-test-card-count">{{$totalApplicants}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="custom-test-card-title">News & Notices</h2>
                            <p class="custom-test-card-count">{{$totalNotice}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="custom-test-card-title">Admit Card</h2>
                            <p class="custom-test-card-count">9</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card custom-test-card shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="custom-test-card-title">Results</h2>
                            <p class="custom-test-card-count">19</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->hasRole('test_center_manager'))
    <div class="container text-center">
        This is consultancy manager page
    </div>
    @endif
@endsection

@push('script')
@endpush

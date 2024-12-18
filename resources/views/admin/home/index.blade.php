@extends('admin.layouts.master')

@section('content')
    <div class="container text-center">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card custom-test-card shadow-sm">
                    <div class="card-body text-center">
                        <h2 class="custom-test-card-title">Test Centers</h2>
                        <p class="custom-test-card-count">{{$totalTestCenter??'0'}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card custom-test-card shadow-sm">
                    <div class="card-body text-center">
                        <h2 class="custom-test-card-title">Education Consultancy</h2>
                        <p class="custom-test-card-count">{{$totalEducationConsultancy??'0'}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card custom-test-card shadow-sm">
                    <div class="card-body text-center">
                        <h2 class="custom-test-card-title">JPT Applicants</h2>
                        <p class="custom-test-card-count">32</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card custom-test-card shadow-sm">
                    <div class="card-body text-center">
                        <h2 class="custom-test-card-title">News & Notices</h2>
                        <p class="custom-test-card-count">17</p>
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
@endsection

@push('script')
@endpush

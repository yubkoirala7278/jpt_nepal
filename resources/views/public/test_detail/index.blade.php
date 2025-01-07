@extends('public.layouts.master')

@section('content')
    <section class="secondary-banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner slider-body">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/img/slider/japan-2.jpg') }}" class="slide-image d-block w-100"
                        alt="Blog Image">
                    <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Test Centers</h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500"> Lorem ipsum dolor sit amet
                            consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container">
        <div class="section-title mb-4">
            <span><i class="fa-solid fa-angles-right"></i> Test Centers</span>
            <h2>Test Center Details</h2>
        </div>
        <div class="">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Test Center Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Address</th>
                        <th scope="col">Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($testCenters)>0)
                        @foreach ($testCenters as $key=>$testCenter)
                        <tr class="table-active">
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$testCenter->name}}</td>
                            <td>{{$testCenter->email}}</td>
                            <td>{{$testCenter->test_center->address}}</td>
                            <td>{{$testCenter->test_center->phone}}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection

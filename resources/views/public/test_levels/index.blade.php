@extends('public.layouts.master')

@section('content')
    <section class="secondary-banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner slider-body">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/img/slider/japan-2.jpg') }}" class="slide-image d-block w-100"
                        alt="Blog Image">
                    <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Test Levels</h1>
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
            <span><i class="fa-solid fa-angles-right"></i> Test Levels</span>
            <h2>Test Levels</h2>
        </div>
        <div class="">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Test Date</th>
                        <th scope="col">Test Location</th>
                        <th scope="col">Test Levels</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-active">
                        <th scope="row">1</th>
                        <td>Dec 29, 2024</td>
                        <td>Kathmandu, Nepal</td>
                        <td>N1</td>
                    </tr>
                    <tr class="table-active">
                        <th scope="row">2</th>
                        <td>Dec 29, 2024</td>
                        <td>Kathmandu, Nepal</td>
                        <td>N2</td>
                    </tr>
                    <tr class="table-active">
                        <th scope="row">3</th>
                        <td>Dec 29, 2024</td>
                        <td>Kathmandu, Nepal</td>
                        <td>N5</td>
                    </tr>
                    <tr class="table-active">
                        <th scope="row">4</th>
                        <td>Jan 29, 2025</td>
                        <td>Kathmandu, Nepal</td>
                        <td>N4</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- <div class="main-pagination mt-5" data-aos="flip-right" data-aos-duration="1500">
            <ul class="d-flex flex-wrap gap-3 justify-content-center ">
                <li class="pagination-link">
                    <a class="link active" href=""><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li class="pagination-link">
                    <a class="link" href="">1</a>
                </li>
                <li class="pagination-link">
                    <a class="link" href="">2</a>
                </li>
                <li class="pagination-link">
                    <a class="link" href="">...</a>
                </li>
                <li class="pagination-link">
                    <a class="link" href="">10</a>
                </li>
                <li class="pagination-link">
                    <a class="link" href="">11</a>
                </li>
                <li class="pagination-link">
                    <a class="link" href=""><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div> --}}

    </section>
@endsection

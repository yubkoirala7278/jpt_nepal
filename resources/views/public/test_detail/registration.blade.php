@extends('public.layouts.master')
@section('content')
    <section class="secondary-banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner slider-body">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/img/slider/japan-2.jpg') }}" class="slide-image d-block w-100"
                        alt="Japan Image" loading="lazy">
                    <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                        <h1 class="display-5 fw-bold text-start" data-aos="fade-right" data-aos-duration="1500">Registration
                        </h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500"> Lorem ipsum dolor sit amet
                            consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container">
        <div class="row">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500">
                <div class="section-title">
                    <span><i class="fa-solid fa-angles-right"></i> Register</span>
                    <h2>Registration Form</h2>
                </div>
                <form action="" class="mt-4">
                    <div class=" row g-3 border p-4 rounded-3 border-1">
                        <div class="col-md-6">
                            <label for="">Name</label>
                            <input type="Text" class="form-control" placeholder="Name">
                        </div>

                        <div class="col-md-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" placeholder="Email">
                        </div>

                        <div class="col-md-6">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" placeholder="Phone">
                        </div>

                        <div class="col-md-6">
                            <label for="">Birth Date</label>
                            <input type="date" class="form-control" placeholder="Date of Birth">
                        </div>

                        <div class="d-flex justify-content-center ">
                            <button class="btn btn-primary" type="submit"><i class="fa-regular fa-circle-check"></i>
                                Submit</button>
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-duration="1500">
                <img src="{{ asset('frontend/img/exam-results.png') }}" class="w-100 image-fluid"
                    style="max-height:350px;object-fit: contain;" alt="Result Image" loading="lazy">
            </div>
        </div>


    </section>
@endsection

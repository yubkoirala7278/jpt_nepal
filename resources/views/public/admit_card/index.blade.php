@extends('public.layouts.master')
@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Japan Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">JPT Nepal</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left" data-aos-duration="1500">Lorem ipsum dolor sit amet
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
                <span><i class="fa-solid fa-angles-right"></i> Download</span>
                <h2>Download Your Admit Card</h2>
            </div>
            <form action="" class="mt-4">
                <div class="border p-4 rounded-3 border-1" style="max-width: 600px;">
                    <div>
                        <label for="">Enter Date of Birth</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label for="">Registration No.</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-download"></i>
                            Download</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6" data-aos="fade-left" data-aos-duration="1500">
            <img src="{{asset('frontend/img/download.jpg')}}" class="w-100 image-fluid" alt="Admit Card" loading="lazy">
        </div>
    </div>
</section>
@endsection
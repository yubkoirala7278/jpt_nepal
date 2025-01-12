@extends('public.layouts.master')
@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">

        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Japan Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">About Us</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left" data-aos-duration="1500"> The JPT evaluates proficiency across multiple levels, from beginners to experts. </p>
                </div>
            </div>
        </div>
    </div>
</section>


@if (count($abouts) > 0)
<section class="container">
    <div class="row gy-4">
        @foreach ($abouts as $index => $about)
            <div class="col-md-6 {{ $index == 0 ? 'order-md-0 order-1' : 'order-md-1 order-0' }}"
                data-aos="fade-{{ $index == 0 ? 'right' : 'left' }}" data-aos-duration="1500">
                <div class="d-flex flex-column justify-content-center h-100">
                    <div class="section-title">
                        <span><i class="fa-solid fa-angles-right"></i> {{ $about->sub_title }}</span>
                        <h2>{{ $about->title }}</h2>
                    </div>
                    <p>{{ $about->description }}</p>
                </div>
            </div>

            <div class="col-md-6 {{ $index == 0 ? 'order-md-1 order-0' : 'order-md-0 order-1' }}"
                data-aos="fade-{{ $index == 0 ? 'left' : 'right' }}" data-aos-duration="1500">
                <img class="w-100 image-fluid rounded" src="{{ asset($about->image) }}" alt="{{ $about->title }}"
                    loading="lazy">
            </div>
        @endforeach
    </div>
</section>
@endif

@endsection
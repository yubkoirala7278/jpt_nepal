@extends('public.layouts.master')

@section('content')
    <section class="secondary-banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">

            <div class="carousel-inner slider-body">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/img/slider/japan-2.jpg') }}" class="slide-image d-block w-100"
                        alt="Japan Image" loading="lazy">
                    <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Blog Detail</h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500"> Lorem ipsum dolor sit amet
                            consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container blog-detail">

        <div class="row gy-4 gx-4">
            <div class="col-xl-8" data-aos="fade-right" data-aos-duration="1500">
                <img src="{{ asset($blog->image) }}" class="w-100" alt="Blog Image" loading="lazy">
                <div class="section-title blog-title mx-1 mt-3 mb-2">
                    <h2>{{ $blog->title }}</h2>
                </div>
                <div class="post-info ">
                    <p><i class="fa-regular fa-calendar"></i> {{ $blog->created_at->format('F j, Y') }}</p>
                </div>
                <div class="blog-description">
                    <p>{!! $blog->description !!}</p>
                </div>
            </div>

            <div class="col-xl-4" data-aos="fade-left" data-aos-duration="1500">
                <div class="recent-news">
                    <h2 class="border-bottom border-3 border-warning ">Recent Blogs</h2>
                    @if (count($latestBlogs) > 0)
                        @foreach ($latestBlogs as $latestBlog)
                            <div class="card mb-3 mt-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-sm-3">
                                        <img src="{{ asset($latestBlog->image) }}"
                                            class="img-fluid rounded-start w-100 h-100" alt="About Image" loading="lazy">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="card-body">
                                            <a href="{{route('blog-detail',$latestBlog->slug)}}">
                                                <h5 class="card-title">{{ $latestBlog->title }}</h5>
                                                <small
                                                    class="card-text">{{ $latestBlog->created_at->format('F j, Y') }}</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>


    </section>

@endsection

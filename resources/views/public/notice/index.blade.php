@extends('public.layouts.master')

@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Notice Image">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">News & Notice</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left" data-aos-duration="1500">Stay updated with news and notices on Japanese proficiency tests.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="container">
    <div class="section-title mb-4">
        <span><i class="fa-solid fa-angles-right"></i> Notices</span>
        <h2>Latest Notice</h2>
    </div>
    <div class="row gy-4 gx-4">
        @if(count($notices)>0)
            @foreach ($notices as $notice)
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
                <div class="card blog-card" style="width: 100%;">
                    <div class="blog-card-head">
                        <img src="{{asset($notice->image)}}" class="card-img-top" alt="About Image" loading="lazy">
                        <div class="create-date">
                            <p class="m-0 fw-normal text-white">{{ $notice->created_at->format('d') }}</p>
                            <p class="m-0 fw-normal text-white">{{ $notice->created_at->format('M') }}</p>
                            <p class="m-0 fw-normal text-white">{{ $notice->created_at->format('Y') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title fw-bold">{{$notice->title}}</h5>
                      <p class="card-text">{!! \Illuminate\Support\Str::limit(strip_tags($notice->description), 60) !!}</p>
                      <a href="{{route('notice.detail',$notice->slug)}}" class="btn text-primary">Read More</a>
                    </div>
                  </div>
            </div>
            @endforeach
            {{$notices->links('pagination::bootstrap-5')}}
        @else
        <p>No Notice to display..</p>
        @endif
    </div>
</section>
@endsection
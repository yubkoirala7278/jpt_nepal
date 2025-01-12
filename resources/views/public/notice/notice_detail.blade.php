@extends('public.layouts.master')

@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">

        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Japan Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">News & Notice</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left" data-aos-duration="1500">Stay updated with news and notices on Japanese proficiency tests.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="container blog-detail">

    <div class="row gy-4 gx-4">
        <div class="col-xl-8" data-aos="fade-right" data-aos-duration="1500">
            <img src="{{asset($notice->image)}}" class="w-100" alt="About Image" loading="lazy">
            <div class="section-title blog-title mx-1 mt-3 mb-2">
                <h2>{{$notice->title}}</h2>
            </div>
            <div class="post-info ">
               <p><i class="fa-regular fa-calendar"></i> {{ $notice->created_at->format('F d, Y') }}</p>
                {{-- <p><i class="fa-regular fa-user"></i> John Doe</p> --}}
            </div>
            <div class="blog-description">
                <p>{!!$notice->description!!}</p>
            </div>


        </div>

        <div class="col-xl-4" data-aos="fade-left" data-aos-duration="1500">
            <div class="recent-news">
                <h2 class="border-bottom border-3 border-warning " >Recent News & Notice</h2>
                @if(count($latestNotices)>0)
                    @foreach ($latestNotices as $latestNotice)
                    <div class="card mb-3 mt-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-sm-3">
                                <img src="{{asset($latestNotice->image)}}" class="img-fluid rounded-start w-100 h-100" alt="About Image" loading="lazy">
                            </div>
                            <div class="col-sm-9">
                                <div class="card-body">
                                    <a href="{{route('notice.detail',$latestNotice->slug)}}">
                                        <h5 class="card-title">{{$latestNotice->title}}</h5>
                                        <small class="card-text">{{ $latestNotice->created_at->format('F j, Y') }}</small>
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
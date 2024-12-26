@extends('public.layouts.master')

@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Blog Image">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Blog Listing</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left" data-aos-duration="1500"> Lorem ipsum dolor sit amet
                        consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="container">
    <div class="section-title mb-4">
        <span><i class="fa-solid fa-angles-right"></i> Blogs Listing</span>
        <h2>Our Latest Blog</h2>
    </div>
    <div class="row gy-4 gx-4">
        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="card blog-card" style="width: 100%;">
                <div class="blog-card-head">
                    <img src="{{asset('frontend/img/about/about-1.png')}}" class="card-img-top" alt="About Image" loading="lazy">
                    <div class="create-date">
                        <p class="m-0 fw-normal text-white" >12</p>
                        <p class="m-0 fw-normal text-white">Dec</p>
                        <p class="m-0 fw-normal text-white">2024</p>
                    </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold">Blog title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                  <a href="{{route('blog-detail','khdud')}}" class="btn text-primary">Read More</a>
                </div>
              </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="card blog-card" style="width: 100%;">
                <div class="blog-card-head">
                    <img src="{{asset('frontend/img/about/about-1.png')}}" class="card-img-top" alt="About Image" loading="lazy">
                    <div class="create-date">
                        <p class="m-0 fw-normal text-white" >12</p>
                        <p class="m-0 fw-normal text-white">Dec</p>
                        <p class="m-0 fw-normal text-white">2024</p>
                    </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold">Blog title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                  <a href="blog-detail.html" class="btn text-primary">Read More</a>
                </div>
              </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="card blog-card" style="width: 100%;">
                <div class="blog-card-head">
                    <img src="{{asset('frontend/img/about/about-1.png')}}" class="card-img-top" alt="About Image" loading="lazy">
                    <div class="create-date">
                        <p class="m-0 fw-normal text-white" >12</p>
                        <p class="m-0 fw-normal text-white">Dec</p>
                        <p class="m-0 fw-normal text-white">2024</p>
                    </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold">Blog title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                  <a href="blog-detail.html" class="btn text-primary">Read More</a>
                </div>
              </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="card blog-card" style="width: 100%;">
                <div class="blog-card-head">
                    <img src="{{asset('frontend/img/about/about-1.png')}}" class="card-img-top" alt="About Image" loading="lazy">
                    <div class="create-date">
                        <p class="m-0 fw-normal text-white" >12</p>
                        <p class="m-0 fw-normal text-white">Dec</p>
                        <p class="m-0 fw-normal text-white">2024</p>
                    </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold">Blog title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                  <a href="blog-detail.html" class="btn text-primary">Read More</a>
                </div>
              </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="card blog-card" style="width: 100%;">
                <div class="blog-card-head">
                    <img src="{{asset('frontend/img/about/about-1.png')}}" class="card-img-top" alt="About Image" loading="lazy">
                    <div class="create-date">
                        <p class="m-0 fw-normal text-white" >12</p>
                        <p class="m-0 fw-normal text-white">Dec</p>
                        <p class="m-0 fw-normal text-white">2024</p>
                    </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold">Blog title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                  <a href="blog-detail.html" class="btn text-primary">Read More</a>
                </div>
              </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="card blog-card" style="width: 100%;">
                <div class="blog-card-head">
                    <img src="{{asset('frontend/img/about/about-1.png')}}" class="card-img-top" alt="About Image" loading="lazy">
                    <div class="create-date">
                        <p class="m-0 fw-normal text-white" >12</p>
                        <p class="m-0 fw-normal text-white">Dec</p>
                        <p class="m-0 fw-normal text-white">2024</p>
                    </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold">Blog title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                  <a href="blog-detail.html" class="btn text-primary">Read More</a>
                </div>
              </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="card blog-card" style="width: 100%;">
                <div class="blog-card-head">
                    <img src="{{asset('frontend/img/about/about-1.png')}}" class="card-img-top" alt="About Image" loading="lazy">
                    <div class="create-date">
                        <p class="m-0 fw-normal text-white" >12</p>
                        <p class="m-0 fw-normal text-white">Dec</p>
                        <p class="m-0 fw-normal text-white">2024</p>
                    </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title fw-bold">Blog title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                  <a href="blog-detail.html" class="btn text-primary">Read More</a>
                </div>
              </div>
        </div>

    </div>
     
    <div class="main-pagination mt-5" data-aos="flip-right" data-aos-duration="1500">
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
    </div>

</section>
@endsection
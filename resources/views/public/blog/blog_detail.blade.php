@extends('public.layouts.master')

@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">

        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Japan Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Blog Detail</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left" data-aos-duration="1500"> Lorem ipsum dolor sit amet
                        consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


<section class="container blog-detail">

    <div class="row gy-4 gx-4">
        <div class="col-xl-8" data-aos="fade-right" data-aos-duration="1500">
            <img src="{{asset('frontend/img/about/about-1.png')}}" class="w-100" alt="About Image" loading="lazy">
            <div class="section-title blog-title mx-1 mt-3 mb-2">
                <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, commodi.</h2>
            </div>
            <div class="post-info ">
                <p><i class="fa-regular fa-calendar"></i> December, 11, 2024</p>
                <p><i class="fa-regular fa-user"></i> John Doe</p>
            </div>
            <div class="blog-description">
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quidem fugit suscipit porro earum
                    itaque soluta maiores, similique doloremque sapiente, numquam odit obcaecati rerum tempore unde
                    veniam ipsum non quisquam in tenetur molestiae aliquid? Libero provident optio excepturi a nemo,
                    facere tempore at placeat magnam quisquam rem recusandae eveniet labore. Modi vero, deleniti
                    tempora doloribus deserunt voluptatum incidunt tempore fugit expedita voluptates error
                    recusandae! Nesciunt illum voluptatem quidem debitis possimus. Omnis quae quas rem! Veniam
                    accusantium, necessitatibus inventore ratione quas cum. </p>
            </div>


        </div>

        <div class="col-xl-4" data-aos="fade-left" data-aos-duration="1500">
            <div class="recent-news">
                <h2 class="border-bottom border-3 border-warning " >Recent News</h2>

                <div class="card mb-3 mt-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-sm-3">
                            <img src="{{asset('frontend/img/about/about-2.jpg')}}" class="img-fluid rounded-start w-100 h-100" alt="About Image" loading="lazy">
                        </div>
                        <div class="col-sm-9">
                            <div class="card-body">
                                <a href="blog-detail.html">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur.</h5>
                                    <small class="card-text">December, 6, 2023</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 mt-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-sm-3">
                            <img src="{{asset('frontend/img/about/about-1.png')}}" class="img-fluid rounded-start w-100 h-100" alt="About Image" loading="lazy">
                        </div>
                        <div class="col-sm-9">
                            <div class="card-body">
                                <a href="blog-detail.html">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur.</h5>
                                    <small class="card-text">December, 6, 2023</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 mt-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-sm-3">
                            <img src="{{asset('frontend/img/about/about-2.jpg')}}" class="img-fluid rounded-start w-100 h-100" alt="About Image" loading="lazy">
                        </div>
                        <div class="col-sm-9">
                            <div class="card-body">
                                <a href="blog-detail.html">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet consectetur.</h5>
                                    <small class="card-text">December, 6, 2023</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


</section>

@endsection
@extends('public.layouts.master')

@section('content')
<section class="banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Carousel Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold " data-aos="fade-left" data-aos-duration="2000">First slide label
                    </h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-right"
                        data-aos-duration="2000">Some representative placeholder
                        content
                        for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('frontend/img/slider/japan-1.jpg')}}" class="slide-image d-block w-100" alt="Carousel Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold">Second slide label</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;">Some representative placeholder
                        content
                        for the first slide.</p>
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


<section class="my-news-slider mt-0">
    <div class="row align-items-center">
        <!-- <div class="col-md-2 news-bar-slider-name">
            <p class="fw-bold m-1 text-center">News Sidebar</p>
        </div> -->
        <div class="col-md-12">
            <div id="top-bar-slider">
                <div class="top-blog-slider">
                    <div>
                        <a class="link fs-5" href="">News One Lorem, ipsum dolor.</a>
                    </div>
                    <div>
                        <a class="link fs-5" href="">News Two Lorem, ipsum dolor.</a>
                    </div>
                    <div>
                        <a class="link fs-5" href="">News Three Lorem, ipsum dolor.</a>
                    </div>
                    <div>
                        <a class="link fs-5" href="">News Four Lorem, ipsum dolor.</a>
                    </div>
                    <div>
                        <a class="link fs-5" href="">News Five Lorem, ipsum dolor.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="row justify-content-center gy-4">
        <div class="col-md-4">
            <a href="" class="btn btn-primary px-4 py-3 w-100" data-aos="fade-right" data-aos-duration="1500">Apply For
                Test</a>
        </div>
        <div class="col-md-4">
            <a href="{{route('admit-card')}}" class="btn btn-primary px-4 py-3 w-100" data-aos="fade-up"
                data-aos-duration="1500">Download Your Admit Card</a>
        </div>
        <div class="col-md-4">
            <a href="{{route('applicant-result')}}" class="btn btn-primary px-4 py-3 w-100" data-aos="fade-left"
                data-aos-duration="1500">Check Your Result</a>
        </div>


    </div>
</section>


<section class="container">
    <div class="row gy-4">
        <div class="col-md-6 order-md-0 order-1" data-aos="fade-right" data-aos-duration="1500">
            <div class="d-flex flex-column justify-content-center h-100">
                <div class="section-title">
                    <span><i class="fa-solid fa-angles-right"></i> Know About Our Cources</span>
                    <h2>About Japan</h2>
                </div>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, incidunt officia et impedit
                    dolores maiores modi reiciendis, ut numquam iusto perferendis laudantium earum libero qui. Magni
                    repellat nisi, natus quas exercitationem inventore voluptate quaerat earum delectus provident
                    corrupti aut voluptas</p>
                <p>
                    labore. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eligendi eius exercitationem
                    et sapiente numquam hic architecto, nulla maiores maxime voluptatem porro reprehenderit
                    voluptate quod dolorem ex placeat.</p>
                <div class="">
                    <a href="about.html" class="btn btn-outline-primary">Learn More</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 order-md-1 order-0" data-aos="fade-left" data-aos-duration="1500">
            <img class="w-100 image-fluid rounded" src="{{asset('frontend/img/about/about-1.png')}}" alt="About Japan" loading="lazy">
        </div>
    </div>
</section>


<section class="container">
    <div class="row gy-4">
        <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500">
            <img class="w-100 image-fluid rounded" src="{{asset('frontend/img/about/about-2.jpg')}}" alt="About Image" loading="lazy">
        </div>

        <div class="col-md-6" data-aos="fade-left" data-aos-duration="1500">
            <div class="d-flex flex-column justify-content-center h-100">
                <div class="section-title">
                    <span><i class="fa-solid fa-angles-right"></i> Know About Our Cources</span>
                    <h2>About Japan</h2>
                </div>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, incidunt officia et impedit
                    dolores maiores modi reiciendis, ut numquam iusto perferendis laudantium earum libero qui. Magni
                    repellat nisi, natus quas exercitationem inventore voluptate quaerat earum delectus provident
                    corrupti aut voluptas</p>
                <p>
                    labore. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eligendi eius exercitationem
                    et sapiente numquam hic architecto, nulla maiores maxime voluptatem porro reprehenderit
                    voluptate quod dolorem ex placeat.</p>
                <div class="">
                    <a href="about.html" class="btn btn-outline-primary">Learn More</a>
                </div>
            </div>
        </div>

    </div>
</section>


<section class="container">
    <div class="section-title">
        <span><i class="fa-solid fa-angles-right"></i> Exam Center</span>
        <h2>Available Exam Center</h2>
    </div>
    <div class="section-body mt-5">

        <div class="row gy-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                <label for="">Location</label>
                <select name="" id="" class="form-select form-select-lg">
                    <option value="">Kathmandu</option>
                    <option value="">Lalitpur</option>
                    <option value="">Bhaktpur</option>
                </select>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                <label for="">Date</label>
                <input class="form-control form-control-lg" type="date" name="" id="" placeholder="Date">
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
                <label for=""></label>
                <button class="btn btn-lg btn-primary w-100">Find Now</button>
            </div>
        </div>

        <div class="search-data mt-4" data-aos="fade-right" data-aos-duration="1500">
            <h3>Search Data</h3>
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam, ab? Ab mollitia temporibus nisi
                quod aut tenetur exercitationem maxime quia vitae sapiente veritatis dolore, laudantium nostrum,
                voluptatem, commodi beatae cupiditate!
            </p>
        </div>

    </div>
</section>


<section class="container">
    <div class="row gy-4">
        <div class="col-md-6" data-aos="flip-right" data-aos-duration="1500">
            <div class="section-title">
                <span><i class="fa-solid fa-angles-right"></i> Upcoming Test</span>
                <h2>Upcoming Test</h2>
            </div>
            <ul class="mt-4 list-group">
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0">12/13/2025</p>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0">12/13/2025</p>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0">12/13/2025</p>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0">12/13/2025</p>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-md-6" data-aos="flip-left" data-aos-duration="1500">
            <div class="section-title">
                <span><i class="fa-solid fa-angles-right"></i> Latest News</span>
                <h2>News & Notice</h2>
            </div>
            <ul class="mt-4 list-group">
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0"> Lorem, ipsum dolor sit </p>
                        </div>
                        <div class="col-md-3">
                            <a href="blog-detail.html" class="btn btn-primary">
                                View Detail
                            </a>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0"> Lorem ipsum dolor, sit </p>
                        </div>
                        <div class="col-md-3">
                            <a href="blog-detail.html" class="btn btn-primary">
                                View Detail
                            </a>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0"> Lorem ipsum dolor, sit </p>
                        </div>
                        <div class="col-md-3">
                            <a href="blog-detail.html" class="btn btn-primary">
                                View Detail
                            </a>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-9">
                            <p class="fs-6 m-0">Lorem ipsum dolor, sit </p>
                        </div>
                        <div class="col-md-3">
                            <a href="blog-detail.html" class="btn btn-primary">
                                View Detail
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="container" data-aos="fade-right" data-aos-duration="1500">
    <div class="section-title mb-5">
        <span><i class="fa-solid fa-angles-right"></i> Clint Opinion</span>
        <h2>Testominal</h2>
    </div>
    <div id="testominal">


        <div class="testominal-slider">

            <div class="col-md-4">
                <div class="card testominal-item" style="width: 95%">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">Sam Smith</h5>
                        <p class="card-text text-center fst-italic">"Some quick example text to build on the
                            card title and make up the
                            bulk
                            of the card's content. Lorem ipsum dolor sit amet consectetur adipisicing elit. "
                        </p>
                        <div class="hr"></div>
                        <p class="text-center fst-italic mt-2 mb-0"> <small>Good Experience</small> </p>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card testominal-item" style="width: 95%">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">Sam Smith</h5>
                        <p class="card-text text-center fst-italic">"Some quick example text to build on the
                            card title and make up the
                            bulk
                            of the card's content. Lorem ipsum dolor sit amet consectetur adipisicing elit. "
                        </p>
                        <div class="hr"></div>
                        <p class="text-center fst-italic mt-2 mb-0"> <small>Good Experience</small> </p>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card testominal-item" style="width: 95%">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">Sam Smith</h5>
                        <p class="card-text text-center fst-italic">"Some quick example text to build on the
                            card title and make up the
                            bulk
                            of the card's content. Lorem ipsum dolor sit amet consectetur adipisicing elit. "
                        </p>
                        <div class="hr"></div>
                        <p class="text-center fst-italic mt-2 mb-0"> <small>Good Experience</small> </p>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card testominal-item" style="width: 95%">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">Sam Smith</h5>
                        <p class="card-text text-center fst-italic">"Some quick example text to build on the
                            card title and make up the
                            bulk
                            of the card's content. Lorem ipsum dolor sit amet consectetur adipisicing elit. "
                        </p>
                        <div class="hr"></div>
                        <p class="text-center fst-italic mt-2 mb-0"> <small>Good Experience</small> </p>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@extends('public.layouts.master')
@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">

        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100" alt="Japan Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">About Us</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left" data-aos-duration="1500"> Lorem ipsum dolor sit amet
                        consectetur adipisicing elit.</p>
                </div>
            </div>
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

            </div>
        </div>

        <div class="col-md-6 order-md-1 order-0" data-aos="fade-left" data-aos-duration="1500">
            <img class="w-100 image-fluid rounded" src="{{asset('frontend/img/about/about-1.png')}}" alt="About Image" loading="lazy">
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

            </div>
        </div>

    </div>
</section>

@endsection
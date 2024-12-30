@extends('public.layouts.master')

@section('content')
<section class="secondary-banner mt-0">
    <div id="carouselExampleCaptions" class="carousel slide">

        <div class="carousel-inner slider-body">
            <div class="carousel-item active">
                <img src="{{asset('frontend/img/slider/japan-2.jpg')}}" class="slide-image d-block w-100"
                    alt="Japan Image" loading="lazy">
                <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                    <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Contact Us</h1>
                    <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                        data-aos-duration="1500"> Lorem ipsum dolor sit amet
                        consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container contact-detail">
    <div class="section-title mb-4">
        <span><i class="fa-solid fa-angles-right"></i> Our Info</span>
        <h2>Contact Us</h2>
    </div>
    <div class="row gy-3 contact-info">
        <div class="col-md-4" data-aos="fade-right" data-aos-duration="1500">
            <div class="shadow p-3 rounded-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="">
                        <i class="fa-solid fa-location-dot display-5"></i>
                    </div>
                    <div class="">
                        <h2 class="fs-4 fw-bold">Address</h2>
                        <p>
                            Kathmandu, Nepal
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-duration="1500">
            <div class="shadow p-3 rounded-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="">
                        <i class="fa-solid fa-phone-volume display-5"></i>
                    </div>
                    <div class="">
                        <h2 class="fs-4 fw-bold">Phone</h2>
                        <p>
                            +977 9876543210
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-left" data-aos-duration="1500">
            <div class="shadow p-3 rounded-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="">
                        <i class="fa-solid fa-envelope display-5"></i>
                    </div>
                    <div class="">
                        <h2 class="fs-4 fw-bold">Email</h2>
                        <p>
                            info@example.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="container">
    <div class="section-title mb-4">
        <span><i class="fa-solid fa-angles-right"></i> Contact</span>
        <h2>Get in Touch</h2>
    </div>
    <div class="row gy-4">

        <div class="col-md-6 order-md-0 order-1" data-aos="fade-right" data-aos-duration="1500">
            <div class="mapouter">
                <div class="gmap_canvas"><iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=University of Oxford&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a
                        href="https://sprunkin.com/">Sprunki</a></div>
                <style>
                    .mapouter {
                        position: relative;
                        text-align: right;
                        width: 100%;
                        height: 100%;
                    }

                    .gmap_canvas {
                        overflow: hidden;
                        background: none !important;
                        width: 100%;
                        height: 100%;
                    }

                    .gmap_iframe {
                        width: 100% !important;
                        height: 100% !important;
                    }
                </style>
            </div>
        </div>

        <div class="col-md-6 order-md-1 order-0" data-aos="fade-left" data-aos-duration="1500">
            <form action="">
                <div class="contact-form row gy-3">
                    <div class="">

                        <input type="text" class="form-control" placeholder="Full Name">
                    </div>
                    <div class="">
                        <input type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="">
                        <input type="number" class="form-control" placeholder="Phone">
                    </div>
                    <div class="">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Message..."></textarea>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>


    </div>
</section>


<section class="container faqs">
    <div class="section-title mb-4">
        <span><i class="fa-solid fa-angles-right"></i> FAQs</span>
        <h2>Frequently Asked Questions</h2>
    </div>
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="{{asset('frontend/img/faq.png')}}" class="w-100" alt="">
        </div>
        <div class="col-md-6">

            <div class="accordion" id="accordionExample">

                <div class="accordion-item mt-1 border-0 border-bottom">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Question No 1
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo voluptate voluptas corrupti
                            recusandae eligendi dolorum dolor ducimus quis quisquam id.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mt-1 border-0 border-bottom">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Question no 2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Saepe placeat libero ipsam
                            similique aliquam fugit sequi labore laboriosam illum totam?
                        </div>
                    </div>
                </div>

                <div class="accordion-item mt-1 border-0 border-bottom">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Question No 3
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius consectetur incidunt facilis
                            dolores accusantium expedita asperiores, accusamus eaque est rem tenetur, voluptatem a
                            corrupti voluptate odit sapiente explicabo! Illum, molestiae?
                        </div>
                    </div>
                </div>

                <div class="accordion-item mt-1 border-0 border-bottom">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Question No 4
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque reiciendis inventore
                            voluptatibus necessitatibus velit in a sequi omnis qui numquam esse illo incidunt, ea harum?
                        </div>
                    </div>
                </div>


                <div class="accordion-item mt-1 border-0 border-bottom">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Question No 5
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Neque, delectus nam ab consectetur
                            iure, ad nulla a totam at est officia odio voluptatem. Eum illum qui libero labore officiis
                            quaerat vero repudiandae voluptates laboriosam tenetur? Architecto voluptas aut sunt
                            eveniet.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>




@endsection
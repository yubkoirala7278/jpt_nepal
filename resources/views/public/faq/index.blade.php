@extends('public.layouts.master')

@section('content')
    <section class="secondary-banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">

            <div class="carousel-inner slider-body">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/img/slider/japan-2.jpg') }}" class="slide-image d-block w-100"
                        alt="Japan Image" loading="lazy">
                    <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Faq's</h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500">Here are common questions to help you get started with the Japanese Proficiency Test.</p>
                    </div>
                </div>
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
                <img src="{{ asset('frontend/img/faq.png') }}" class="w-100" alt="">
            </div>
            <div class="col-md-6">

                <div class="accordion" id="accordionExample">
                    @if(count($faqs) > 0)
                    @foreach ($faqs as $key => $faq)
                        <div class="accordion-item mt-1 border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}" aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ $key }}">
                                    {{$faq->question}}
                                </button>
                            </h2>
                            <div id="collapse{{ $key }}" class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{$faq->answer}}
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



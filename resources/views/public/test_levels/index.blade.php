@extends('public.layouts.master')

@section('content')
    <section class="secondary-banner mt-0">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner slider-body">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/img/slider/japan-2.jpg') }}" class="slide-image d-block w-100"
                        alt="Blog Image">
                    <div class="carousel-caption d-flex flex-column h-100 align-items-start justify-content-center ">
                        <h1 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="1500">Test Levels</h1>
                        <p class="fs-4 text-start text-white " style="max-width: 600px;" data-aos="fade-left"
                            data-aos-duration="1500">The Japanese Proficiency Test measures language skills at various levels.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container">
        <div class="section-title">
            <span><i class="fa-solid fa-angles-right"></i> Test Levels</span>
            <h2>Test Levels</h2>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Beginner Level (N5):</strong> Gain foundational skills in reading and writing basic Japanese characters (Hiragana, Katakana, and Kanji). Learn simple phrases for everyday conversations.
                        </li>
                        <li class="list-group-item">
                            <strong>Elementary Level (N4):</strong> Build upon your knowledge of basic grammar and vocabulary. Understand and use expressions in more diverse contexts, such as travel and shopping.
                        </li>
                        <li class="list-group-item">
                            <strong>Intermediate Level (N3):</strong> Develop the ability to comprehend moderately complex texts and conversations. Engage in discussions on common topics like culture and daily activities.
                        </li>
                        <li class="list-group-item">
                            <strong>Advanced Level (N2):</strong> Demonstrate fluency in professional settings. Understand and interpret complex writings and discussions related to news, work, or education.
                        </li>
                        <li class="list-group-item">
                            <strong>Proficient Level (N1):</strong> Achieve mastery of the Japanese language. Exhibit excellent comprehension of nuanced topics and participate in high-level professional and academic discourse.
                        </li>
                    </ul>
                </div>
            </div>
        

        {{-- <div class="main-pagination mt-5" data-aos="flip-right" data-aos-duration="1500">
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
        </div> --}}

    </section>
@endsection

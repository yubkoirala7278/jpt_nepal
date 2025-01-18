<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Japanese Proficiency Test</title>
    {{-- Bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- tiny slider --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
     {{-- toastify css --}}
     @toastifyCss
    {{-- aos animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    @yield('header-links')
</head>

<body>
    {{-- header --}}
    <header>
        <div class="top-nab-bar py-2">
            <div class="container">
                <div class="d-flex justify-content-center justify-content-sm-between">
                    <div class="d-flex gap-4 align-items-center justify-content-center">
                        <div class="phone">
                            <span><i class="fa-solid fa-phone"></i> {{$footerContent ->phone??'xxxxxxxx'}}</span>
                        </div>
                        <div class="email">
                            <span><i class="fa-regular fa-envelope"></i> {{$footerContent ->email??'xxxxxxxx'}}</span>
                        </div>
                        <div class="location d-none d-sm-block">
                            <span><i class="fa-solid fa-location-dot"></i> {{$footerContent ->location??'xxxxxxxx'}}</span>
                        </div>
                    </div>
                    <div class="d-flex d-none d-md-block">
                        <a href="{{route('agent.register')}}" class="btn btn-warning btn-sm me-2">Become an Agent</a>
                        <a href="{{ route('login') }}" class="btn btn-warning btn-sm">Agent Login</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="logo"></div> -->


        <div class="my-navbar">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid px-0">
                        <div class="">
                            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                        </div>
                        <div class="top-logo d-block d-lg-none ">
                            <a href="{{ route('home') }}" class="text-decoration-none"><span
                                    class="top-logo-text">JPT</span></a>
                        </div>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <div
                                class="d-flex justify-content-center justify-content-lg-between align-items-center  w-100">
                                <div class="top-logo d-none d-lg-block ">
                                    <a href="{{ route('home') }}" class="text-decoration-none"><span
                                            class="top-logo-text">JPT</span></a>
                                </div>

                                <div class="d-none d-lg-block"></div>

                                <ul class="navbar-nav d-flex align-items-center gap-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('about') }}">About JPT</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('test-levels')}}">Test Levels</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('test.detail') }}">Test Center</a>
                                    </li>

                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="{{route('admit-card')}}">Admit Card</a>
                                    </li> --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="{{route('applicant-result')}}">Check Result</a>
                                    </li> --}}


                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="event.html">Event</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('faq')}}">FAQ's</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('student.register') }}"
                                            class="login-btn text-decoration-none bg-dark bg-gradient text-white rounded-2">Student
                                            Registration</a>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

    </header>
    {{-- end of header --}}

    {{-- content --}}
    @yield('content')
    @yield('modal')
    {{-- end content --}}

    {{-- footer --}}
    <footer class="mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6">
                    <img src="{{ asset('frontend/img/logo.jpg') }}" style="max-height: 200px;" alt="">
                    <p class="text-justify mt-4 text-white">{{$footerContent->description??"xxxxx"}}</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h2 class="fs-5 text-white">Get in Touch</h2>
                    <p class="my-2 text-white">
                        <i class="fa-solid fa-location-dot me-2"></i>
                       {{$footerContent->location??"xxxxxxxxx"}}
                    </p>
                    <p class="my-2 text-white">
                        <i class="fa-solid fa-phone me-2"></i>
                        {{$footerContent->phone??'xxxxxxxxxx'}}
                    </p>
                    <p class="my-2 text-white">
                        <i class="fa-regular fa-envelope me-2"></i>
                        {{$footerContent->email??'xxxxxxxxxx'}}
                    </p>

                  
                </div>
                <div class="col-lg-3 col-md-6">
                    <h2 class="fs-5">Useful Links</h2>
                    <p class="my-2"><a class="footer-link text-white text-decoration-none"
                            href="{{ route('about') }}">
                            <i class="fa-solid fa-angle-right me-2"></i>
                            About JPT</a></p>
                    {{-- <p class="my-2"><a class="footer-link text-white text-decoration-none" href="">
                            <i class="fa-solid fa-angle-right me-2"></i>
                            Practice Materials</a></p>
                    <p class="my-2"><a class="footer-link text-white text-decoration-none" href="">
                            <i class="fa-solid fa-angle-right me-2"></i>
                            Resources</a></p> --}}
                    <p class="my-2"><a class="footer-link text-white text-decoration-none"
                            href="{{ route('blog') }}">
                            <i class="fa-solid fa-angle-right me-2"></i>
                            Blog</a></p>
                            <p class="my-2"><a class="footer-link text-white text-decoration-none"
                                href="{{ route('notice') }}">
                                <i class="fa-solid fa-angle-right me-2"></i>
                                Notice</a></p>
                    {{-- <p class="my-2"><a class="footer-link text-white text-decoration-none" href="">
                            <i class="fa-solid fa-angle-right me-2"></i>
                            Terms & Conditions</a></p> --}}
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="social-media">
                        <h2 class="fs-5 ">Follow Us:</h2>
                        <div class="d-flex gap-3 mt-3">
                            <a href="{{$footerContent->facebook_link??''}}" target="_blank">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="{{$footerContent->twitter_link??''}}" target="_blank">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            <a href="{{$footerContent->whatsapp_link??''}}" target="_blank">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
            <hr>
            <div class="copyright text-center">
                <p class="m-0 text-white">© 2024 JPT Nepal. All Right Reserved.</p>
            </div>
        </div>
    </footer>
    {{-- end footer --}}

    {{-- bootstrap script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- tiny slider --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    {{-- aos animation --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>

    {{-- toastify --}}
    @if (session()->has('success') || session()->has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session()->has('success'))
                    toastify().success({!! json_encode(session('success')) !!});
                @endif
                @if (session()->has('error'))
                    toastify().error({!! json_encode(session('error')) !!});
                @endif
            });
        </script>
    @endif

    {{-- toastify js --}}
    @toastifyJs

    {{-- custom script --}}
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    {{-- custom script --}}
    @stack('script')
</body>

</html>

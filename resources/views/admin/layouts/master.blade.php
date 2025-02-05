<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Japanese Proficiency Test</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('logo.png') }}" rel="icon">
    <link href="{{ asset('logo.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    {{-- Jquery CDN --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- csrf token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- sweet alert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- data table css link --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('header-links')
    {{-- toastify css --}}
    @toastifyCss

    <!-- Customm css -->
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center">
                <img src="{{ asset('logo.png') }}" alt="">
                <span class="d-none d-lg-block">JPTNepal</span>
            </a>
            <i class="fas fa-bars toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        {{-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="fas fa-search"></i></button>
            </form>
        </div><!-- End Search Bar --> --}}

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                {{-- <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="fas fa-search"></i>
                    </a>
                </li><!-- End Search Icon--> --}}


                {{-- <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="fas fa-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="fas fa-times-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="fas fa-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav --> --}}

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user-tie bg-success p-2 rounded-circle text-white"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            @if (Auth::user()->getRoleNames()->first() == 'admin')
                                <h6>Admin</h6>
                            @elseif(Auth::user()->getRoleNames()->first() == 'consultancy_manager')
                                <h6>Consultancy Manager</h6>
                            @elseif(Auth::user()->getRoleNames()->first() == 'test_center_manager')
                                <h6>Test Center Manager</h6>
                            @endif
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        {{-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li> --}}
                        {{-- <li>
                            <hr class="dropdown-divider">
                        </li> --}}

                        {{-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li> --}}
                        {{-- <li>
                            <hr class="dropdown-divider">
                        </li> --}}

                        {{-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li> --}}
                        {{-- <li>
                            <hr class="dropdown-divider">
                        </li> --}}

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        
                        
                    </ul><!-- End Profile Dropdown Items -->
                </li>

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.home') ? '' : 'collapsed' }}"
                    href="{{ route('admin.home') }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            @if (
                (Auth::user()->consultancy && Auth::user()->consultancy->status == 'active') ||
                    (Auth::user()->test_center && Auth::user()->test_center->status == 'active') ||
                    Auth::user()->hasRole('admin'))
                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('exam_date.index') ? '' : 'collapsed' }}"
                            href="{{ route('exam_date.index') }}">
                            <i class="fa-solid fa-calendar"></i>
                            <span>Exam Dates</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('test_center.create') || request()->routeIs('test_center.index') ? '' : 'collapsed' }}"
                            data-bs-target="#icons-nav" data-bs-toggle="collapse" href="{{route('test_center.index')}}">
                            <i class="fa-solid fa-building-columns"></i><span>Test Centers</span><i
                                class="fas fa-chevron-down ms-auto"></i>
                        </a>
                        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{ route('test_center.create') }}">
                                    <i class="fas fa-circle"></i><span>Add New</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('test_center.index') }}">
                                    <i class="fas fa-circle"></i><span>List All</span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- End Icons Nav -->
                @endif

                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('test_center_manager'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('consultancy.create') || request()->routeIs('consultancy.index') ? '' : 'collapsed' }}"
                            data-bs-target="#icons-nav-second" data-bs-toggle="collapse" href="#">
                            <i class="fa-solid fa-user-graduate"></i><span>Education Consultancy</span><i
                                class="fas fa-chevron-down ms-auto"></i>
                        </a>
                        <ul id="icons-nav-second" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{ route('consultancy.create') }}">
                                    <i class="fas fa-circle"></i><span>Add New</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('consultancy.index') }}">
                                    <i class="fas fa-circle"></i><span>List All</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pending.consultancy') }}">
                                    <i class="fas fa-circle"></i><span>Pending</span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- End Icons Nav -->
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.index') || request()->routeIs('student.create') ? '' : 'collapsed' }}"
                        data-bs-target="#icons-nav-third" data-bs-toggle="collapse" href="#">
                        <i class="fa-solid fa-laptop-file"></i><span>Students/Applicants</span><i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <ul id="icons-nav-third" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                        @if (Auth::user()->hasRole('consultancy_manager'))
                            <li>
                                <a href="{{ route('student.create') }}">
                                    <i class="fas fa-circle"></i><span>Add New</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('student.index') }}">
                                <i class="fas fa-circle"></i><span>List All</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.pending') }}">
                                <i class="fas fa-circle"></i><span>Pending</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student.approved') }}">
                                <i class="fas fa-circle"></i><span>Approved</span>
                            </a>
                        </li>
                        @if (Auth::user()->hasRole('consultancy_manager') || Auth::user()->hasRole('test_center_manager'))
                            <li>
                                <a href="{{ route('upload.receipt') }}">
                                    <i class="fas fa-circle"></i><span>Upload Receipt</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li><!-- End Icons Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('admin.admit-card') }}">
                        <i class="fa-solid fa-ticket"></i>
                        <span>Admit Card</span>
                    </a>
                </li><!-- End Profile Page Nav -->

                @if (Auth::user()->hasRole('consultancy_manager') || Auth::user()->hasRole('admin'))
                   
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('admin.applicant-result') }}">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Results</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                @endif

                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('transaction') }}">
                            <i class="fa-solid fa-sack-dollar"></i>
                            <span>Transaction</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('account.index') }}">
                            <i class="fa-solid fa-building-columns"></i>
                            <span>Accounts</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('admin.contact') }}">
                            <i class="fa-solid fa-address-book"></i>
                            <span>Contact</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                @endif
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#icons-nav-fourth" data-bs-toggle="collapse"
                        href="#">
                        <i class="fa-solid fa-newspaper"></i><span>News & Notice</span><i
                            class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <ul id="icons-nav-fourth" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        @if (Auth::user()->hasRole('admin'))
                            <li>
                                <a href="{{ route('notice.create') }}">
                                    <i class="fas fa-circle"></i><span>Add New</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('notice.index') }}">
                                <i class="fas fa-circle"></i><span>List All</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Icons Nav -->


              


                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('testimonial.index') }}">
                            <i class="fas fa-comment"></i>
                            <span>Testimonial</span>
                        </a>
                    </li><!-- End Profile Page Nav -->


                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('blog.index') }}">
                            <i class="fa-solid fa-blog"></i>
                            <span>Blogs</span>
                        </a>
                    </li><!-- End Profile Page Nav -->

                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#icons-nav-fifth" data-bs-toggle="collapse"
                            href="#">
                            <i class="fa-solid fa-file"></i><span>Static Pages</span><i
                                class="fas fa-chevron-down ms-auto"></i>
                        </a>
                        <ul id="icons-nav-fifth" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{route('header.index')}}">
                                    <i class="fas fa-circle"></i><span>Header</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('about.index')}}">
                                    <i class="fas fa-circle"></i><span>About</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('faq.index')}}">
                                    <i class="fas fa-circle"></i><span>Faq's</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('footer.index')}}">
                                    <i class="fas fa-circle"></i><span>Footer</span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- End Icons Nav -->
                @endif
            @endif

            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="nav-link collapsed" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li><!-- End Logout Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card">
                        <div class="card-body profile-card pt-4">
                            @yield('content')
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>JPT Nepal</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- custom js -->
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

    {{-- modal --}}
    @yield('modal')

    {{-- custom js --}}
    @stack('script')

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

    {{-- data table cdn --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    {{-- toastify js --}}
    @toastifyJs

</body>

</html>

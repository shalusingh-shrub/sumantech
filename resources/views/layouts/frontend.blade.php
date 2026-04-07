<!DOCTYPE html>
{{-- File: resources/views/layouts/frontend.blade.php --}}
{{-- Updated Design: Suman Tech - Making You Future Ready --}}
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Suman Tech – Making You Future Ready | Muzaffarpur')</title>
    <meta name="description" content="@yield('meta_description', 'Suman Tech is Muzaffarpur\'s best computer institute offering DCA, ADCA, Tally Prime, Digital Marketing, Web Design courses. ISO 9001:2015 & 21001:2018 Certified.')">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <style>
        :root {
            --navy:   #0B1F3A;
            --blue:   #1557B0;
            --sky:    #2C9CDB;
            --gold:   #F0A500;
            --gold2:  #FFD166;
            --white:  #FFFFFF;
            --off:    #F4F7FC;
            --text:   #1A2840;
            --muted:  #6B7A99;
            --radius: 12px;
            --shadow: 0 8px 32px rgba(11,31,58,.12);
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; color: var(--text); background: var(--white); overflow-x: hidden; margin: 0; padding: 0; }

        /* ── TOP BAR ── */
        .top-bar {
            background: var(--navy);
            padding: 7px 0;
            color: rgba(255,255,255,.75);
            font-size: .78rem;
        }
        .top-bar a { color: var(--gold2); text-decoration: none; transition: color .2s; }
        .top-bar a:hover { color: #fff; }
        .top-bar .tb-item { display: inline-flex; align-items: center; gap: 6px; }

        /* ── SITE HEADER ── */
        .site-header {
            background: #fff;
            padding: 12px 0;
            border-bottom: 3px solid var(--gold);
            box-shadow: 0 2px 12px rgba(11,31,58,.07);
        }
        .logo-icon-wrap {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, var(--navy), var(--blue));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden; flex-shrink: 0;
        }
        .logo-icon-wrap::after {
            content: '';
            position: absolute;
            width: 22px; height: 22px;
            background: var(--gold); border-radius: 50%;
            top: -5px; right: -5px; opacity: .6;
        }
        .logo-icon-wrap i { color: white; font-size: 1.3rem; position: relative; z-index: 1; }
        .logo-text-wrap strong {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem; font-weight: 900;
            color: var(--navy); letter-spacing: -.01em; line-height: 1.1;
        }
        .logo-text-wrap span {
            font-size: .68rem; font-weight: 600;
            color: var(--muted); letter-spacing: .07em; text-transform: uppercase;
        }
        .header-contact { font-size: .82rem; color: var(--muted); }
        .header-contact a { color: var(--navy); font-weight: 600; text-decoration: none; }
        .header-contact a:hover { color: var(--blue); }
        .header-enroll {
            background: linear-gradient(135deg, var(--gold), #E8950A);
            color: var(--navy) !important; font-weight: 700; font-size: .82rem;
            padding: 9px 22px; border-radius: 50px; text-decoration: none;
            box-shadow: 0 4px 16px rgba(240,165,0,.35);
            transition: transform .2s, box-shadow .2s; white-space: nowrap;
        }
        .header-enroll:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(240,165,0,.45); color: var(--navy) !important; }

        /* ── MAIN NAV ── */
        .main-nav {
            background: linear-gradient(135deg, var(--navy) 0%, #163970 100%);
            position: sticky; top: 0; z-index: 1000;
            box-shadow: 0 3px 16px rgba(11,31,58,.25);
        }
        .main-nav .navbar { padding: 0; }
        .main-nav .navbar-nav .nav-link {
            color: rgba(255,255,255,.9) !important;
            font-size: .86rem; font-weight: 500;
            padding: 15px 13px !important;
            transition: background .18s, color .18s;
        }
        .main-nav .navbar-nav .nav-link:hover,
        .main-nav .navbar-nav .nav-item.active .nav-link {
            color: var(--gold) !important;
            background: rgba(255,255,255,.07);
        }
        .main-nav .navbar-nav .nav-link.nav-cta-pill {
            background: var(--gold);
            color: var(--navy) !important;
            border-radius: 50px;
            padding: 8px 18px !important;
            margin: 8px 6px;
            font-weight: 700;
        }
        .main-nav .navbar-nav .nav-link.nav-cta-pill:hover {
            background: var(--gold2); color: var(--navy) !important;
        }
        .main-nav .dropdown-menu {
            background: var(--navy);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: var(--radius);
            padding: 6px 0;
            box-shadow: 0 12px 36px rgba(0,0,0,.3);
            min-width: 200px;
        }
        .main-nav .dropdown-item {
            color: rgba(255,255,255,.8);
            font-size: .84rem;
            padding: 9px 18px;
            transition: all .18s;
        }
        .main-nav .dropdown-item:hover {
            background: rgba(255,255,255,.08);
            color: var(--gold);
            padding-left: 22px;
        }

        /* ── TOP FLASH ── */
        .top-flash {
            background: var(--off);
            border-bottom: 2px solid var(--gold);
            padding: 7px 0;
            font-size: .82rem;
        }
        .top-flash .flash-label {
            background: var(--gold);
            color: var(--navy);
            padding: 3px 14px;
            font-weight: 700;
            border-radius: 4px;
            white-space: nowrap;
            font-size: .75rem;
            letter-spacing: .04em;
        }
        .top-flash marquee a { color: var(--navy); text-decoration: none; margin: 0 18px; font-weight: 500; }
        .top-flash marquee a:hover { color: var(--blue); text-decoration: underline; }

        /* ── PAGE BANNER ── */
        .page-banner {
            background: linear-gradient(135deg, var(--navy) 0%, #163970 100%);
            color: #fff; padding: 44px 0;
            position: relative; overflow: hidden;
        }
        .page-banner::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        .page-banner h1 { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 900; margin: 0; position: relative; }
        .page-banner .breadcrumb { background: transparent; padding: 0; margin: 10px 0 0; position: relative; }
        .page-banner .breadcrumb-item a { color: rgba(255,255,255,.65); text-decoration: none; font-size: .85rem; }
        .page-banner .breadcrumb-item.active { color: var(--gold); font-size: .85rem; }
        .page-banner .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,.4); }

        /* ── SECTION HELPERS ── */
        .section-label {
            font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            color: var(--sky); margin-bottom: 8px; display: block;
        }
        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3.5vw, 2.3rem);
            font-weight: 900; color: var(--navy);
            line-height: 1.2; letter-spacing: -.02em; margin-bottom: 0;
        }
        .section-heading em { font-style: normal; color: var(--blue); }
        .section-sub { color: var(--muted); font-size: .97rem; line-height: 1.75; margin-top: 12px; }

        /* ── CARDS COMMON ── */
        .st-card {
            background: #fff;
            border: 1.5px solid rgba(11,31,58,.07);
            border-radius: var(--radius);
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
        }
        .st-card:hover { transform: translateY(-5px); box-shadow: var(--shadow); }

        /* ── NEWS CARDS ── */
        .news-card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,.08); border-radius: var(--radius); height: 100%; transition: all .25s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: var(--shadow); }
        .news-card .card-img-top { height: 185px; object-fit: cover; }

        /* ── TEAM CARDS ── */
        .team-card {
            border: none; box-shadow: 0 2px 10px rgba(0,0,0,.08);
            border-radius: var(--radius); text-align: center;
            padding: 24px 16px; transition: all .25s; height: 100%;
        }
        .team-card:hover { transform: translateY(-5px); box-shadow: var(--shadow); }
        .team-card .team-photo {
            width: 110px; height: 110px; border-radius: 50%;
            object-fit: cover; border: 4px solid var(--gold);
            margin: 0 auto 14px;
        }
        .team-card .team-name { font-size: 1rem; font-weight: 700; color: var(--navy); }
        .team-card .team-designation { font-size: .8rem; color: var(--muted); }

        /* ── TESTIMONIAL CARDS ── */
        .testimonial-card {
            background: var(--off);
            border-left: 4px solid var(--gold);
            border-radius: 0 var(--radius) var(--radius) 0;
            padding: 22px; height: 100%;
        }
        .testimonial-card .stars { color: var(--gold); font-size: .9rem; }
        .testimonial-card .quote-icon { font-size: 2.8rem; line-height: .8; color: var(--gold); font-family: Georgia, serif; margin-bottom: 10px; }

        /* ── PUB CARDS ── */
        .pub-card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,.08); border-radius: var(--radius); transition: all .3s; }
        .pub-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
        .pub-card .pub-cover { height: 200px; object-fit: cover; width: 100%; }

        /* ── SOCIAL SHARE SIDEBAR ── */
        .social-share {
            position: fixed; right: 0; top: 50%; transform: translateY(-50%);
            z-index: 999; display: flex; flex-direction: column;
        }
        .social-share a {
            display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; color: #fff; font-size: 16px;
            margin-bottom: 2px; text-decoration: none; transition: width .2s;
        }
        .social-share a:hover { width: 46px; }
        .social-share .ss-linkedin { background: #0077b5; }
        .social-share .ss-whatsapp { background: #25d366; }
        .social-share .ss-twitter  { background: #000; }
        .social-share .ss-share    { background: var(--gold); }
        .social-share .ss-facebook { background: #3b5998; }
        .social-share .ss-telegram { background: #0088cc; }

        /* ── FOOTER ── */
        .site-footer {
            background: var(--navy); color: rgba(255,255,255,.7);
            padding: 60px 0 0; margin-top: 0;
        }
        .site-footer .f-logo strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; color: #fff; display: block;
        }
        .site-footer .f-logo span { font-size: .65rem; color: rgba(255,255,255,.4); letter-spacing: .08em; text-transform: uppercase; }
        .site-footer h5 { color: var(--gold); font-weight: 700; font-size: .85rem; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 16px; }
        .site-footer a { color: rgba(255,255,255,.65); text-decoration: none; display: block; margin-bottom: 8px; font-size: .87rem; transition: color .2s, padding-left .2s; }
        .site-footer a:hover { color: var(--gold); padding-left: 4px; }
        .site-footer .footer-bottom {
            background: rgba(0,0,0,.25);
            padding: 14px 0; margin-top: 48px;
            font-size: .78rem; text-align: center;
            color: rgba(255,255,255,.4);
        }
        .site-footer .footer-bottom a { display: inline; color: var(--gold2); padding: 0; margin: 0; }
        .site-footer .social-icons a {
            display: inline-flex; align-items: center; justify-content: center;
            width: 34px; height: 34px;
            background: rgba(255,255,255,.08); border-radius: 8px;
            margin: 2px; color: #fff; font-size: .9rem;
            padding: 0;
        }
        .site-footer .social-icons a:hover { background: var(--gold); color: var(--navy); padding-left: 0; }

        /* ── TEAM MODAL ── */
        .team-modal .modal-header {
            background: linear-gradient(135deg, var(--navy), var(--blue));
            color: #fff;
        }
        .team-modal .member-photo {
            width: 110px; height: 130px;
            object-fit: cover; border: 3px solid var(--gold);
            border-radius: 8px;
        }

        /* ── BUTTONS ── */
        .btn-st-primary {
            background: linear-gradient(135deg, var(--blue), var(--sky));
            color: white; font-weight: 700; border: none; border-radius: 50px;
            padding: 10px 26px; transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 16px rgba(21,87,176,.3);
        }
        .btn-st-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(21,87,176,.4); color: white; }
        .btn-st-gold {
            background: linear-gradient(135deg, var(--gold), #E8950A);
            color: var(--navy); font-weight: 700; border: none; border-radius: 50px;
            padding: 10px 26px; transition: transform .2s, box-shadow .2s;
        }
        .btn-st-gold:hover { transform: translateY(-2px); color: var(--navy); }
        .btn-st-outline {
            border: 2px solid var(--blue); color: var(--blue);
            font-weight: 600; border-radius: 50px; padding: 9px 24px;
            background: transparent; transition: all .2s;
        }
        .btn-st-outline:hover { background: var(--blue); color: white; }

        /* ── REVEAL ANIMATION ── */
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity .55s ease, transform .55s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 991px) {
            .header-contact { display: none; }
            .social-share { display: none; }
        }
        @media (max-width: 768px) {
            .top-bar .tb-left { display: none; }
            .main-nav .navbar-nav .nav-link { border-bottom: 1px solid rgba(255,255,255,.08); }
            .page-banner h1 { font-size: 1.5rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ══ TOP BAR ══ --}}
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="tb-left d-none d-md-flex gap-3">
                <span class="tb-item"><i class="far fa-clock me-1"></i>Mon–Sat: 08:00am – 07:00pm</span>
                <span class="tb-item"><i class="fas fa-map-marker-alt me-1"></i>Muzaffarpur, Bihar</span>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <span class="tb-item"><i class="fas fa-phone me-1"></i><a href="tel:+918920779218">+91 89207 79218</a></span>
                <span class="tb-item"><i class="fas fa-envelope me-1"></i><a href="mailto:thesumantech@gmail.com">thesumantech@gmail.com</a></span>
                @guest
                    <a href="{{ route('login') }}" style="color:var(--gold2);font-weight:600;"><i class="fas fa-user me-1"></i>Login</a>
                @else
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown" style="color:var(--gold2);font-weight:600;">
                            <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#1a2a6c,#6b3a1f);display:flex;align-items:center;justify-content:center;color:#ffd700;font-weight:700;font-size:12px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span style="font-size:.82rem;">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width:200px;border-radius:12px;margin-top:8px;background:#0f2044;padding:8px;">
                            <li>
                                <a class="dropdown-item py-2" href="{{ auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin') ? route('admin.dashboard') : '#' }}" style="color:#F0A500;font-weight:600;border-radius:8px;">
                                    <i class="fas fa-th-large me-2" style="color:#F0A500;"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('portal.personal') }}" style="color:#F0A500;font-weight:600;border-radius:8px;">
                                    <i class="fas fa-user me-2" style="color:#F0A500;"></i> Profile
                                </a>
                            </li>                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>

{{-- ══ SITE HEADER ══ --}}
<div class="site-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                <div class="logo-icon-wrap">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text-wrap">
                    <strong>Suman Tech</strong>
                    <span>Making You Future Ready</span>
                </div>
            </a>
            <div class="header-contact d-none d-lg-flex gap-4">
                <div>
                    <div style="font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;">Call Us</div>
                    <a href="tel:+918920779218" style="font-size:.95rem;"><i class="fas fa-phone text-primary me-1"></i>+91 89207 79218</a>
                </div>
                <div>
                    <div style="font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;">Email Us</div>
                    <a href="mailto:thesumantech@gmail.com" style="font-size:.95rem;"><i class="fas fa-envelope text-primary me-1"></i>thesumantech@gmail.com</a>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="header-enroll d-none d-md-inline-flex align-items-center gap-2">
                <i class="fas fa-rocket"></i> Enroll Now
            </a>
            <a href="{{ route('student.login') }}" class="d-none d-md-inline-flex align-items-center gap-2 ms-2" style="background:#F0A500;color:#0B1F3A;padding:10px 20px;border-radius:50px;font-weight:700;font-size:.88rem;text-decoration:none;">
                <i class="fas fa-user-graduate"></i> Student Login
            </a>
        </div>
    </div>
</div>

{{-- ══ MAIN NAV ══ --}}
<nav class="main-nav navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="fas fa-bars" style="color:#fff;font-size:1.2rem;"></i>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-1 d-lg-none"></i>Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">About Us</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('about') }}"><i class="fas fa-info-circle me-2"></i>About Suman Tech</a></li>
                        <li><a class="dropdown-item" href="{{ route('team') }}"><i class="fas fa-users me-2"></i>Our Team</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ '#' ?? '#' }}" data-bs-toggle="dropdown">Courses</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ '#' ?? '#' }}"><i class="fas fa-th-large me-2"></i>All Courses</a></li>
                        <li><hr class="dropdown-divider" style="border-color:rgba(255,255,255,.1)"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-desktop me-2"></i>DCA</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-laptop me-2"></i>ADCA</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-calculator me-2"></i>Tally Prime</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice-dollar me-2"></i>DIGITA</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-code me-2"></i>Web Design</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bullhorn me-2"></i>Digital Marketing</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://lms.sumantech.in/" target="_blank"><i class="fas fa-book-open me-1"></i>LMS</a>
                </li>
                <li class="nav-item {{ request()->is('certificate*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('certificate') }}"><i class="fas fa-certificate me-1"></i>Certificate</a>
                </li>
                <li class="nav-item {{ request()->is('news*') || request()->is('blog*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('news-events') ?? '#' }}">Blog</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Gallery</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('image-gallery') ?? '#' }}"><i class="fas fa-images me-2"></i>Image Gallery</a></li>
                        <li><a class="dropdown-item" href="{{ route('video-gallery') ?? '#' }}"><i class="fas fa-video me-2"></i>Video Gallery</a></li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->is('testimonials*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('testimonials') ?? '#' }}">Testimonials</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link nav-cta-pill" href="{{ route('contact') }}">
                        <i class="fas fa-phone-alt me-1"></i>Contact Us
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- ══ TOP FLASH MARQUEE ══ --}}
@php $topFlashes = App\Models\TopFlash::where('is_active', true)->orderBy('sort_order')->get(); @endphp
@if($topFlashes->count() > 0)
<div class="top-flash">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <span class="flash-label">🔔 Flash News</span>
            <marquee behavior="scroll" direction="left" scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
                @foreach($topFlashes as $flash)
                    @if($flash->is_new)
                        <img src="{{ asset('images/new-badge.gif') }}" alt="new" width="22" style="vertical-align:middle;margin-right:4px;" onerror="this.style.display='none'">
                    @endif
                    <a href="{{ $flash->link ?: '#' }}" target="{{ $flash->link && $flash->link !== '#' ? '_blank' : '_self' }}">{{ $flash->title }}</a>
                    &nbsp;&nbsp;◆&nbsp;&nbsp;
                @endforeach
            </marquee>
        </div>
    </div>
</div>
@endif

{{-- ══ SOCIAL SHARE SIDEBAR ══ --}}
<div class="social-share" id="socialShareBar">
    <a href="#" class="ss-linkedin" title="LinkedIn" id="shareLinkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="ss-whatsapp" title="WhatsApp" id="shareWhatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
    <a href="#" class="ss-twitter" title="Twitter / X" id="shareTwitter" target="_blank"><i class="fab fa-x-twitter"></i></a>
    <a href="#" class="ss-share" title="Copy Link" id="shareCopyLink" onclick="copyPageLink(event)"><i class="fas fa-link"></i></a>
    <a href="#" class="ss-facebook" title="Facebook" id="shareFacebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="ss-telegram" title="Telegram" id="shareTelegram" target="_blank"><i class="fab fa-telegram-plane"></i></a>
</div>
<script>
(function() {
    var u = encodeURIComponent(window.location.href);
    var t = encodeURIComponent(document.title);
    document.getElementById('shareLinkedin').href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + u;
    document.getElementById('shareWhatsapp').href = 'https://wa.me/?text=' + t + '%20' + u;
    document.getElementById('shareTwitter').href = 'https://twitter.com/intent/tweet?url=' + u + '&text=' + t;
    document.getElementById('shareFacebook').href = 'https://www.facebook.com/sharer/sharer.php?u=' + u;
    document.getElementById('shareTelegram').href = 'https://t.me/share/url?url=' + u + '&text=' + t;
})();
function copyPageLink(e) {
    e.preventDefault();
    navigator.clipboard.writeText(window.location.href).then(function() {
        var btn = document.getElementById('shareCopyLink');
        btn.style.background = '#2d8c4e';
        setTimeout(function() { btn.style.background = ''; }, 2000);
    });
}
</script>

{{-- ══ PAGE CONTENT ══ --}}
@yield('content')

{{-- ══ FOOTER ══ --}}
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="d-flex align-items-center gap-3 text-decoration-none mb-3">
                    <div class="logo-icon-wrap">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="f-logo">
                        <strong>Suman Tech</strong>
                        <span>Making You Future Ready</span>
                    </div>
                </a>
                <p style="font-size:.88rem;line-height:1.75;">We offer the best computer courses in Muzaffarpur from basic to advanced levels. ISO 9001:2015 & 21001:2018 Certified. Est. 2022.</p>
                <div class="social-icons mt-3">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
                    <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Menu</h5>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('team') }}">Our Teachers</a>
                <a href="{{ '#' ?? '#' }}">Courses</a>
                <a href="{{ route('news-events') ?? '#' }}">Blog</a>
                <a href="{{ route('contact') }}">Contact Us</a>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Important Links</h5>
                <a href="https://lms.sumantech.in/" target="_blank">LMS Portal</a>
                <a href="{{ '#' ?? '#' }}">Verify Certificate</a>
                <a href="{{ route('testimonials') ?? '#' }}">Testimonials</a>
                <a href="http://bepclots.bihar.gov.in/" target="_blank">e-Lots Bihar</a>
                <a href="http://biharboardonline.bihar.gov.in/" target="_blank">Bihar Board</a>
                <a href="https://www.ncs.gov.in/" target="_blank">NCS Portal</a>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5>Contact Us</h5>
                <p style="font-size:.87rem;line-height:1.8;color:rgba(255,255,255,.65);">
                    <i class="fas fa-map-marker-alt me-2" style="color:var(--gold);"></i>Ward No. 26, Pankha Toli, Kalambagh Rd, Muzaffarpur, Bihar 842001<br>
                    <i class="fas fa-phone me-2 mt-2" style="color:var(--gold);"></i><a href="tel:+918920779218">+91 89207 79218</a><br>
                    <i class="fas fa-phone me-2" style="color:var(--gold);"></i><a href="tel:+919755938443">+91 97559 38443</a><br>
                    <i class="fas fa-envelope me-2" style="color:var(--gold);"></i><a href="mailto:thesumantech@gmail.com">thesumantech@gmail.com</a><br>
                    <i class="far fa-clock me-2" style="color:var(--gold);"></i>Mon–Sat: 08:00am – 07:00pm
                </p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            &copy; {{ date('Y') }} Suman Tech. All Rights Reserved. &nbsp;|&nbsp; <i class="fas fa-eye me-1"></i> Visitor Count: {{ \App\Models\VisitorLog::count() }} &nbsp;|&nbsp; Developed by <a href="https://www.shrubtechnology.com" target="_blank">Shrub Technology</a>
        </div>
    </div>
</footer>

{{-- Team Modal --}}
<div class="modal fade team-modal" id="teamMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-tie me-2"></i>Teacher Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <img id="memberPhoto" src="{{ asset('images/default-avatar.png') }}" alt="Photo" class="member-photo img-fluid">
                    </div>
                    <div class="col-md-9">
                        <p class="fw-bold fs-5 mb-1" id="memberName"></p>
                        <p class="text-muted mb-3" id="memberDesignation"></p>
                        <p class="mb-2"><strong>Department:</strong> <span id="memberDepartment"></span> &nbsp; <strong>Mobile:</strong> <span id="memberPhone"></span></p>
                        <p class="mb-2"><strong>Email:</strong> <span id="memberEmail"></span></p>
                        <div><strong>About:</strong><br><span id="memberAbout"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<!-- Owl Carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
// Scroll Reveal
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('visible'), i * 70);
        }
    });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// Team Modal
function showMemberDetail(id) {
    fetch('/team/member/' + id)
        .then(r => r.json())
        .then(data => {
            document.getElementById('memberName').textContent = data.name;
            document.getElementById('memberDesignation').textContent = data.designation || '';
            document.getElementById('memberDepartment').textContent = data.department || '-';
            document.getElementById('memberPhone').textContent = data.phone || '-';
            document.getElementById('memberEmail').textContent = data.email || '-';
            document.getElementById('memberAbout').textContent = data.about || '-';
            const photo = document.getElementById('memberPhoto');
            photo.src = data.photo ? '/storage/team/' + data.photo : '{{ asset("images/default-avatar.png") }}';
            photo.onerror = function() { this.src = '{{ asset("images/default-avatar.png") }}'; };
            new bootstrap.Modal(document.getElementById('teamMemberModal')).show();
        });
}
</script>

@stack('scripts')
</body>
</html>





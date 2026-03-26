<!DOCTYPE html>
{{-- File: resources/views/layouts/frontend.blade.php --}}
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teachers of Bihar - The Change Makers')</title>
    <meta name="description" content="@yield('meta_description', 'Teachers of Bihar - A voluntary organization of government school teachers working to improve education quality in Bihar.')">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Noto+Sans+Devanagari:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <style>
        :root {
            --tob-dark-blue: #1a2a6c;
            --tob-brown: #6b3a1f;
            --tob-green: #2d8c4e;
            --tob-light-green: #5cb85c;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; margin: 0; padding: 0; }
        .hindi-text { font-family: 'Noto Sans Devanagari', sans-serif; }

        /* Top Bar */
        .top-bar {
            background: var(--tob-dark-blue);
            padding: 6px 0;
            color: #fff;
            font-size: 13px;
        }
        .top-bar a { color: #fff; text-decoration: none; }
        .top-bar a:hover { color: #ffd700; }

        /* Header */
        .site-header {
            background: #fff;
            border-bottom: 3px solid var(--tob-green);
            padding: 10px 0;
        }
        .site-header .logo-text h1 {
            color: var(--tob-dark-blue);
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        .site-header .logo-text p {
            color: var(--tob-brown);
            margin: 0;
            font-size: 13px;
        }

        /* Navigation */
        .main-nav {
            background: linear-gradient(135deg, var(--tob-dark-blue), var(--tob-brown));
            padding: 0;
        }
        .main-nav .navbar { padding: 0; }
        .main-nav .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 13.5px;
            padding: 14px 12px !important;
            font-weight: 500;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        .main-nav .navbar-nav .nav-link:hover,
        .main-nav .navbar-nav .nav-item.active .nav-link {
            background: rgba(255,255,255,0.15);
            color: #ffd700 !important;
        }
        .main-nav .dropdown-menu {
            background: #1a2a6c;
            border: none;
            border-radius: 0;
            min-width: 220px;
            padding: 5px 0;
        }
        .main-nav .dropdown-item {
            color: #fff;
            font-size: 13px;
            padding: 8px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .main-nav .dropdown-item:hover { background: rgba(255,255,255,0.2); color: #ffd700; }
        .main-nav .new-badge {
            display: inline-block;
            width: 16px; height: 16px;
            background: url('/images/new-badge.gif') no-repeat center center;
            background-size: contain;
            vertical-align: middle;
            margin-right: 4px;
        }

        /* Mega Dropdown */
        .mega-dropdown { position: static !important; }
        .mega-menu {
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            background: #1a2a6c;
            border-top: 3px solid #ffd700;
            border-radius: 0;
            padding: 25px 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            z-index: 9999;
        }
        .mega-menu .mega-col-title {
            color: #ffd700;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .mega-menu .mega-link {
            display: block;
            color: rgba(255,255,255,0.85);
            font-size: 13px;
            padding: 5px 0;
            text-decoration: none;
            border: none;
            background: none;
        }
        .mega-menu .mega-link:hover { color: #ffd700; padding-left: 5px; transition: all 0.2s; }
            display: inline-block;
            width: 16px;
            height: 16px;
            background: url('/images/new-badge.gif') no-repeat center center;
            background-size: contain;
            vertical-align: middle;
            margin-right: 4px;
        }

        /* Top Flash Marquee */
        .top-flash {
            background: #f8f9fa;
            border-bottom: 2px solid var(--tob-green);
            padding: 8px 0;
            font-size: 13px;
        }
        .top-flash .flash-label {
            background: var(--tob-green);
            color: #fff;
            padding: 4px 12px;
            font-weight: 700;
            white-space: nowrap;
            margin-right: 10px;
        }
        .top-flash marquee a { color: var(--tob-dark-blue); text-decoration: none; margin: 0 20px; }
        .top-flash marquee a:hover { color: var(--tob-brown); text-decoration: underline; }
        .top-flash .new-gif { width: 28px; vertical-align: middle; }

        /* Slider */
        .hero-slider { position: relative; }
        .hero-slider .owl-item img { width: 100%; max-height: 480px; object-fit: cover; }
        .hero-slider .slide-caption {
            position: absolute;
            bottom: 30px;
            left: 30px;
            background: rgba(26,42,108,0.8);
            color: #fff;
            padding: 12px 20px;
            border-left: 4px solid #ffd700;
        }
        .hero-slider .slide-caption a { color: #ffd700; text-decoration: none; font-size: 14px; }

        /* Section Titles */
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--tob-dark-blue);
            border-left: 4px solid var(--tob-green);
            padding-left: 12px;
            margin-bottom: 20px;
        }
        .section-title-bar {
            background: linear-gradient(135deg, var(--tob-dark-blue), var(--tob-brown));
            color: #fff;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* News Cards */
        .news-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        .news-card:hover { transform: translateY(-4px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .news-card .card-img-top { height: 180px; object-fit: cover; }
        .news-card .card-title { font-size: 15px; font-weight: 600; }
        .news-card .badge { font-size: 11px; }

        /* Team Cards */
        .team-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            padding: 20px 15px;
            transition: all 0.3s;
            cursor: pointer;
            height: 100%;
        }
        .team-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .team-card .team-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--tob-green);
            margin: 0 auto 15px;
        }
        .team-card .team-name { font-size: 16px; font-weight: 700; color: var(--tob-dark-blue); }
        .team-card .team-designation { font-size: 13px; color: #666; }
        .team-card .team-dept { font-size: 12px; color: var(--tob-brown); }

        /* Team Modal */
        .team-modal .modal-header {
            background: linear-gradient(135deg, var(--tob-dark-blue), var(--tob-brown));
            color: #fff;
        }
        .team-modal .member-photo {
            width: 120px;
            height: 140px;
            object-fit: cover;
            border: 3px solid var(--tob-green);
        }
        .team-modal .member-name { font-size: 22px; font-weight: 700; color: var(--tob-dark-blue); }
        .team-modal .info-label { font-weight: 700; min-width: 100px; display: inline-block; }

        /* Page Banner */
        .page-banner {
            background: linear-gradient(135deg, var(--tob-dark-blue), var(--tob-brown));
            color: #fff;
            padding: 40px 0;
        }
        .page-banner h1 { font-size: 28px; font-weight: 700; margin: 0; }
        .page-banner .breadcrumb { background: transparent; padding: 0; margin: 8px 0 0; }
        .page-banner .breadcrumb-item a { color: rgba(255,255,255,0.7); text-decoration: none; }
        .page-banner .breadcrumb-item.active { color: #ffd700; }
        .page-banner .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.7); }

        /* Social Share Buttons (right side) */
        .social-share {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 999;
            display: flex;
            flex-direction: column;
        }
        .social-share a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: #fff;
            font-size: 18px;
            margin-bottom: 2px;
            text-decoration: none;
        }
        .social-share .linkedin { background: #0077b5; }
        .social-share .whatsapp { background: #25d366; }
        .social-share .twitter { background: #000; }
        .social-share .sharethis { background: #f26522; }
        .social-share .facebook { background: #3b5998; }
        .social-share .telegram { background: #0088cc; }

        /* Footer */
        .site-footer {
            background: var(--tob-dark-blue);
            color: #fff;
            padding: 40px 0 0;
            margin-top: 60px;
        }
        .site-footer h5 { color: #ffd700; font-weight: 700; margin-bottom: 15px; }
        .site-footer a { color: rgba(255,255,255,0.8); text-decoration: none; display: block; margin-bottom: 5px; font-size: 13px; }
        .site-footer a:hover { color: #ffd700; }
        .site-footer .footer-bottom {
            background: rgba(0,0,0,0.3);
            padding: 12px 0;
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
        }
        .site-footer .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin: 3px;
            color: #fff;
            font-size: 16px;
        }
        .site-footer .social-icons a:hover { background: var(--tob-green); }

        /* Publication Cards */
        .pub-card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; }
        .pub-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .pub-card .pub-cover { height: 220px; object-fit: cover; width: 100%; }

        /* Testimonial */
        .testimonial-card { background: #f8f9fa; border-left: 4px solid var(--tob-green); padding: 20px; border-radius: 4px; }
        .testimonial-card .stars { color: #ffc107; }

        @media (max-width: 768px) {
            .hero-slider .owl-item img { max-height: 250px; }
            .social-share { display: none; }
            .main-nav .navbar-nav .nav-link { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.15); }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <span class="hindi-text">शिक्षा बदलेगी, बिहार बदलेगा</span>
            <div>
                @guest
                    <a href="{{ route('login') }}"><i class="fas fa-user me-1"></i>User Login</a>
                @else
                    <a href="{{ auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin') ? route('admin.dashboard') : '#' }}" class="me-3"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 text-white" style="font-size:13px;"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="site-header">
    <div class="container">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Teachers of Bihar" height="70" class="me-3" onerror="this.style.display='none'">
            <div class="logo-text">
                <h1>Teachers of Bihar</h1>
                <p>The Change Makers</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation -->
<nav class="main-nav navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span style="color:#fff;font-size:20px;"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">About Us</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('about') }}">About ToB</a></li>
                        <li><a class="dropdown-item" href="{{ route('team') }}">Our Team</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Our Ideas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('bagless-saturday') }}">Bagless Saturday</a></li>
                        <li><a class="dropdown-item" href="{{ route('lets-talk') }}">Let's Talk</a></li>
                        <li><a class="dropdown-item" href="{{ route('shiksha-shriti') }}" class="hindi-text">Shiksha Shruti</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Publication</a>
                    <div class="dropdown-menu mega-menu">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mega-col-title">Science & Research</div>
                                <a class="mega-link hindi-text" href="{{ route('science-corner') }}">विज्ञान कार्नर</a>
                                <a class="mega-link hindi-text" href="{{ route('anusandhaanam') }}">अनुसंधानम्</a>
                                <a class="mega-link" href="{{ route('tlm') }}">TLM</a>
                                <a class="mega-link" href="{{ route('eresources') }}">e-Resources</a>
                            </div>
                            <div class="col-md-3">
                                <div class="mega-col-title">Magazines</div>
                                <a class="mega-link hindi-text" href="{{ route('emagazine') }}">ई-मैगजीन</a>
                                <a class="mega-link hindi-text" href="{{ route('abhimat') }}">अभिमत</a>
                                <a class="mega-link hindi-text" href="{{ route('karmana') }}">कर्मणा</a>
                            </div>
                            <div class="col-md-3">
                                <div class="mega-col-title">For Students</div>
                                <a class="mega-link hindi-text" href="{{ route('balman') }}">बाल मन</a>
                                <a class="mega-link hindi-text" href="{{ route('suvichar') }}">सुविचार</a>
                            </div>
                            <div class="col-md-3">
                                <div class="mega-col-title">Online</div>
                                <a class="mega-link" href="https://teachersofbihar.blogspot.com/" target="_blank">Blog</a>
                                <a class="mega-link" href="{{ route('shiksha-shriti') }}">Shiksha Shruti</a>
                                <a class="mega-link" href="{{ route('podcast') }}">Podcast</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('project-shikshak-sathi') }}">
                        <img src="{{ asset('images/new-badge.gif') }}" alt="new" width="18" onerror="this.style.display='none'">
                        Project Shikshak Sathi
                    </a>
                </li>

                <li class="nav-item"><a class="nav-link" href="{{ route('news-events') }}">News &amp; Events</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('eip') }}">EIP</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('competition') }}">Competition</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('award') }}">Award</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Gallery</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('image-gallery') }}">Image Gallery</a></li>
                        <li><a class="dropdown-item" href="{{ route('video-gallery') }}">Video Gallery</a></li>
                        <li><a class="dropdown-item" href="{{ route('media') }}">Media</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="{{ route('testimonials') }}">Testimonial</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Contact</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('contact') }}">Contact</a></li>
                        <li><a class="dropdown-item" href="{{ route('suggestion-box') }}">
                            <img src="{{ asset('images/new-badge.gif') }}" alt="new" width="18" onerror="this.style.display='none'">
                            Suggestion Box</a></li>
                        <li><a class="dropdown-item" href="{{ route('your-opinion') }}">Your Opinion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Top Flash Marquee -->
@php $topFlashes = App\Models\TopFlash::where('is_active', true)->orderBy('sort_order')->get(); @endphp
@if($topFlashes->count() > 0)
<div class="top-flash">
    <div class="container">
        <div class="d-flex align-items-center">
            <span class="flash-label">Flash News</span>
            <marquee behavior="scroll" direction="left" scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
                @foreach($topFlashes as $flash)
                    @if($flash->is_new)
                        <img src="{{ asset('images/new-badge.gif') }}" alt="new" class="new-gif" onerror="this.style.display='none'">
                    @endif
                    <a href="{{ $flash->link ?: '#' }}" target="{{ $flash->link && $flash->link !== '#' ? '_blank' : '_self' }}">{{ $flash->title }}</a>
                    &nbsp;|&nbsp;
                @endforeach
            </marquee>
        </div>
    </div>
</div>
@endif

<!-- Social Share Sidebar -->
<div class="social-share" id="socialShareBar">
    <a href="#" class="linkedin" title="Share on LinkedIn" id="shareLinkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="whatsapp" title="Share on WhatsApp" id="shareWhatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
    <a href="#" class="twitter" title="Share on X/Twitter" id="shareTwitter" target="_blank"><i class="fab fa-x-twitter"></i></a>
    <a href="#" class="sharethis" title="Copy Link" id="shareCopyLink" onclick="copyPageLink(event)"><i class="fas fa-share-alt"></i></a>
    <a href="#" class="facebook" title="Share on Facebook" id="shareFacebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="telegram" title="Share on Telegram" id="shareTelegram" target="_blank"><i class="fab fa-telegram-plane"></i></a>
</div>
<script>
(function() {
    var pageUrl = encodeURIComponent(window.location.href);
    var pageTitle = encodeURIComponent(document.title);
    document.getElementById('shareLinkedin').href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + pageUrl;
    document.getElementById('shareWhatsapp').href = 'https://wa.me/?text=' + pageTitle + '%20' + pageUrl;
    document.getElementById('shareTwitter').href = 'https://twitter.com/intent/tweet?url=' + pageUrl + '&text=' + pageTitle;
    document.getElementById('shareFacebook').href = 'https://www.facebook.com/sharer/sharer.php?u=' + pageUrl;
    document.getElementById('shareTelegram').href = 'https://t.me/share/url?url=' + pageUrl + '&text=' + pageTitle;
})();
function copyPageLink(e) {
    e.preventDefault();
    navigator.clipboard.writeText(window.location.href).then(function() {
        var btn = document.getElementById('shareCopyLink');
        btn.style.background = '#2d8c4e';
        btn.title = 'Link Copied!';
        setTimeout(function() { btn.style.background = '#f26522'; btn.title = 'Copy Link'; }, 2000);
    });
}
</script>

<!-- Page Content -->
@yield('content')

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Teachers of Bihar</h5>
                <p style="color:rgba(255,255,255,0.8);font-size:13px;">
                    Teachers of Bihar (ToB) is a voluntary organization of government school teachers of Bihar, working to improve the quality of education.
                </p>
                <div class="social-icons mt-3">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('team') }}">Our Team</a>
                <a href="{{ route('news-events') }}">News & Events</a>
                <a href="{{ route('testimonials') }}">Testimonials</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Publications</h5>
                <a href="{{ route('science-corner') }}" class="hindi-text">विज्ञान कार्नर</a>
                <a href="{{ route('tlm') }}">TLM</a>
                <a href="{{ route('emagazine') }}" class="hindi-text">ई-मैगजीन</a>
                <a href="{{ route('balman') }}" class="hindi-text">बाल मन</a>
                <a href="{{ route('suvichar') }}" class="hindi-text">सुविचार</a>
                <a href="{{ route('eresources') }}">e-Resources</a>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contact Info</h5>
                <p style="color:rgba(255,255,255,0.8);font-size:13px;">
                    <i class="fas fa-map-marker-alt me-2"></i>Bihar, India<br>
                    <i class="fas fa-envelope me-2 mt-2"></i>info@teachersofbihar.org<br>
                    <i class="fab fa-whatsapp me-2 mt-2"></i>WhatsApp Group
                </p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            &copy; {{ date('Y') }} Teachers of Bihar - The Change Makers. All Rights Reserved.
        </div>
    </div>
</footer>

<!-- Team Member Modal -->
<div class="modal fade team-modal" id="teamMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lecturer Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <img id="memberPhoto" src="{{ asset('images/default-avatar.png') }}" alt="Member Photo" class="member-photo img-fluid">
                    </div>
                    <div class="col-md-9">
                        <p class="member-name mb-1" id="memberName"></p>
                        <p class="text-muted mb-3" id="memberDesignation"></p>
                        <p class="mb-2">
                            <span class="info-label"><strong>Department:</strong></span>
                            <span id="memberDepartment"></span>
                            &nbsp;&nbsp;
                            <strong>Mobile:</strong> <span id="memberPhone"></span>
                        </p>
                        <p class="mb-2"><span class="info-label"><strong>Email:</strong></span> <span id="memberEmail"></span></p>
                        <div>
                            <strong>About:</strong><br>
                            <span id="memberAbout"></span>
                        </div>
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
// Team Member Modal
function showMemberDetail(id) {
    fetch('/team/member/' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('memberName').textContent = data.name;
            document.getElementById('memberDesignation').textContent = data.designation || '';
            document.getElementById('memberDepartment').textContent = data.department || '-';
            document.getElementById('memberPhone').textContent = data.phone || '-';
            document.getElementById('memberEmail').textContent = data.email || '-';
            document.getElementById('memberAbout').textContent = data.about || '-';

            const photo = document.getElementById('memberPhoto');
            if (data.photo) {
                photo.src = '/storage/team/' + data.photo;
            } else {
                photo.src = '/images/default-avatar.png';
            }
            photo.onerror = function() { this.src = '/images/default-avatar.png'; };

            new bootstrap.Modal(document.getElementById('teamMemberModal')).show();
        });
}
</script>

@stack('scripts')
</body>
</html>

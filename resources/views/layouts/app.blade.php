<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Suman Tech')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; margin: 0; padding: 0; }
        /* TOP LOGO BAR */
        .top-logo-bar { background: #1a2a5e; padding: 10px 0; }
        .top-logo-bar img { width: 55px; height: 55px; border-radius: 50%; }
        .top-logo-bar h1 { color: white; font-size: 22px; margin: 0; font-weight: 700; }
        .top-logo-bar p { color: #ccc; font-size: 13px; margin: 0; }
        /* MAIN NAV */
        .main-navbar { background: #7B3F00; padding: 0; }
        .main-navbar .navbar-nav .nav-link { color: white !important; font-weight: 500; padding: 14px 16px; font-size: 14px; border-bottom: 3px solid transparent; transition: all 0.3s; }
        .main-navbar .navbar-nav .nav-link:hover, .main-navbar .navbar-nav .nav-link.active { background: rgba(255,255,255,0.15); border-bottom-color: white; }
        .main-navbar .dropdown-menu { background: #7B3F00; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.3); border-radius: 0 0 8px 8px; min-width: 200px; }
        .main-navbar .dropdown-item { color: white !important; padding: 10px 20px; font-size: 13px; transition: all 0.2s; }
        .main-navbar .dropdown-item:hover { background: rgba(255,255,255,0.2); padding-left: 25px; }
        .main-navbar .dropdown-toggle::after { vertical-align: middle; }
        /* SOCIAL SIDEBAR */
        .social-sidebar { position: fixed; right: 0; top: 50%; transform: translateY(-50%); z-index: 9999; display: flex; flex-direction: column; }
        .social-sidebar a { display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; color: white; font-size: 18px; text-decoration: none; transition: width 0.3s; }
        .social-sidebar a:hover { width: 55px; }
        .s-li { background: #0077b5; }
        .s-wa { background: #25D366; }
        .s-tw { background: #000000; }
        .s-sh { background: #95D03A; }
        .s-fb { background: #1877f2; }
        .s-tg { background: #0088cc; }
        /* PAGE HEADER */
        .page-header { background: #f0f2f5; padding: 25px 0; border-bottom: 1px solid #ddd; }
        .page-header h2 { font-size: 28px; color: #333; margin: 0; }
        .breadcrumb { background: transparent; padding: 0; margin: 0; justify-content: flex-end; }
        .breadcrumb-item a { color: #7B3F00; text-decoration: none; }
        .breadcrumb-item.active { color: #555; }
        .breadcrumb-item+.breadcrumb-item::before { color: #999; }
        /* CATEGORY HEADER */
        .category-title { text-align: center; margin: 50px 0 30px; }
        .category-title h3 { display: inline-block; color: #4a3580; font-size: 26px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; border-bottom: 4px solid #4a3580; padding-bottom: 8px; text-shadow: 1px 1px 3px rgba(0,0,0,0.1); }
        /* TEAM CARD */
        .team-card { background: white; border-radius: 10px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); margin-bottom: 30px; overflow: hidden; transition: all 0.3s; }
        .team-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .team-card img { width: 100%; height: 270px; object-fit: cover; border-bottom: 3px solid #4a3580; }
        .team-card-body { padding: 20px; }
        .team-name { font-size: 18px; font-weight: 700; color: #2c3e50; margin-bottom: 5px; }
        .team-role { color: #7f8c8d; font-size: 13px; margin-bottom: 8px; }
        .team-badge { background: #4a3580; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; display: inline-block; margin-bottom: 10px; }
        .team-info { background: #f8f9fa; padding: 10px; border-radius: 6px; margin-top: 10px; border-left: 3px solid #4a3580; }
        .team-info p { margin: 3px 0; font-size: 13px; color: #555; }
        .team-info p span { font-weight: 600; color: #333; }
        /* NO IMAGE */
        .no-image { width: 100%; height: 270px; background: linear-gradient(135deg, #4a3580, #7B3F00); display: flex; align-items: center; justify-content: center; color: white; font-size: 60px; font-weight: 700; }
        /* VIEW ALL BTN */
        .view-all-btn { text-align: right; margin-bottom: 20px; }
        .view-all-btn a { background: #4a3580; color: white; padding: 8px 20px; border-radius: 5px; text-decoration: none; font-size: 14px; transition: all 0.3s; }
        .view-all-btn a:hover { background: #7B3F00; }
        /* FOOTER */
        .site-footer { background: #1a2a5e; color: white; padding: 50px 0 20px; margin-top: 60px; }
        .site-footer h5 { font-weight: 700; margin-bottom: 20px; color: #fff; border-bottom: 2px solid #7B3F00; padding-bottom: 10px; display: inline-block; }
        .site-footer ul { list-style: none; padding: 0; }
        .site-footer ul li { margin-bottom: 8px; }
        .site-footer ul li a { color: #bdc3c7; text-decoration: none; font-size: 14px; transition: all 0.3s; }
        .site-footer ul li a:hover { color: white; padding-left: 5px; }
        .footer-bottom { border-top: 1px solid #2c3e50; margin-top: 30px; padding-top: 20px; text-align: center; color: #bdc3c7; font-size: 13px; }
        /* ALERT */
        .alert { border-radius: 8px; }
        @media(max-width: 768px) { .social-sidebar { display: none; } .team-card img { height: 220px; } }
    </style>
    @yield('styles')
</head>
<body>

<!-- TOP LOGO BAR -->
<div class="top-logo-bar">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <img src="https://www.teachersofbihar.org/public/web/images/logo-1.png" alt="ToB Logo" onerror="this.onerror=null;this.style.opacity='0.3'">
            <div>
                <h1>Suman Tech</h1>
                <p>The Learning Platform</p>
            </div>
        </div>
    </div>
</div>

<!-- MAIN NAVIGATION -->
<nav class="navbar navbar-expand-lg main-navbar sticky-top">
    <div class="container-fluid px-3">
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" style="color:white;">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') || request()->is('team') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">About Us</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">About ToB</a></li>
                        <li><a class="dropdown-item" href="{{ route('team.index') }}">Our Team</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Our Ideas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Bagless Saturday</a></li>
                        <li><a class="dropdown-item" href="#">Lets Talk</a></li>
                        <li><a class="dropdown-item" href="#">Shiksha Shruti</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Publication</a>
                    <ul class="dropdown-menu" style="max-height:400px;overflow-y:auto;">
                        <li><a class="dropdown-item" href="#">विज्ञान कार्नर</a></li>
                        <li><a class="dropdown-item" href="#">TLM</a></li>
                        <li><a class="dropdown-item" href="#">अनुसंधानम्</a></li>
                        <li><a class="dropdown-item" href="#">अभिमत</a></li>
                        <li><a class="dropdown-item" href="#">ई-मैगजीन</a></li>
                        <li><a class="dropdown-item" href="#">कर्मणा</a></li>
                        <li><a class="dropdown-item" href="#">गद्य गुँजन</a></li>
                        <li><a class="dropdown-item" href="#">e-Resources</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Online Publication</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://www.teachersofbihar.org/blog" target="_blank">Blog</a></li>
                        <li><a class="dropdown-item" href="https://padyapankaj.teachersofbihar.org/" target="_blank">Padya Pankaj</a></li>
                        <li><a class="dropdown-item" href="https://gadyagunjan.teachersofbihar.org/" target="_blank">Gadya Gunjan</a></li>
                        <li><a class="dropdown-item" href="#">Shiksha Shruti</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <img src="https://www.teachersofbihar.org/public/web/images/newCircle.gif" style="width:13px;vertical-align:middle;margin-right:3px;" onerror="this.style.display='none'">
                        Project Shikshak Sathi
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">News & Events</a></li>
                <li class="nav-item"><a class="nav-link" href="#">EIP</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Competition</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Award</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Gallery</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Image Gallery</a></li>
                        <li><a class="dropdown-item" href="#">Video Gallery</a></li>
                        <li><a class="dropdown-item" href="#">Media</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">Testimonial</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Contact</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Contact Us</a></li>
                        <li><a class="dropdown-item" href="#">Suggestion Box</a></li>
                        <li><a class="dropdown-item" href="#">Your Opinion</a></li>
                    </ul>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}" style="background:rgba(255,255,255,0.2);border-radius:5px;margin:5px;">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}" style="background:rgba(255,255,255,0.2);border-radius:5px;margin:5px;">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- SOCIAL SIDEBAR -->
<div class="social-sidebar">
    <a href="https://www.linkedin.com/in/teachersofbihar" target="_blank" class="s-li" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://wa.me/917250818080" target="_blank" class="s-wa" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
    <a href="https://twitter.com/teachersofbihar" target="_blank" class="s-tw" title="Twitter/X"><i class="fab fa-x-twitter"></i></a>
    <a href="#" class="s-sh" title="Share"><i class="fas fa-share-alt"></i></a>
    <a href="https://www.facebook.com/teachersofbihar" target="_blank" class="s-fb" title="Facebook"><i class="fab fa-facebook-f"></i></a>
    <a href="https://t.me/teachersofbihar" target="_blank" class="s-tg" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
</div>

@yield('content')

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Suman Tech</h5>
                <p style="color:#bdc3c7;font-size:14px;">Bihar's largest teachers community working for quality education.</p>
                <p style="color:#bdc3c7;font-size:14px;"><i class="fas fa-phone me-2"></i>+91 7250 8180 80</p>
                <p style="color:#bdc3c7;font-size:14px;"><i class="fas fa-envelope me-2"></i>teachersofbihar@gmail.com</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Useful Links</h5>
                <ul>
                    <li><a href="https://diksha.gov.in/" target="_blank"><i class="fas fa-chevron-right me-1"></i>DIKSHA</a></li>
                    <li><a href="http://bepclots.bihar.gov.in/" target="_blank"><i class="fas fa-chevron-right me-1"></i>e-LOTS</a></li>
                    <li><a href="https://scert.bihar.gov.in/" target="_blank"><i class="fas fa-chevron-right me-1"></i>SCERT Bihar</a></li>
                    <li><a href="https://www.education.gov.in/" target="_blank"><i class="fas fa-chevron-right me-1"></i>MHRD</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Our Websites</h5>
                <ul>
                    <li><a href="https://gadyagunjan.teachersofbihar.org/" target="_blank"><i class="fas fa-chevron-right me-1"></i>Gadya Gunjan</a></li>
                    <li><a href="https://padyapankaj.teachersofbihar.org/" target="_blank"><i class="fas fa-chevron-right me-1"></i>Padya Pankaj</a></li>
                    <li><a href="#" target="_blank"><i class="fas fa-chevron-right me-1"></i>School on Mobile</a></li>
                    <li><a href="#" target="_blank"><i class="fas fa-chevron-right me-1"></i>Contest</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} <strong>Suman Tech</strong>. All Rights Reserved.</p>
            <p>Developed & Maintained by Shivendra Suman</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>



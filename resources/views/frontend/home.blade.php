{{-- File: resources/views/frontend/home.blade.php --}}
{{-- Updated Design: Suman Tech Homepage --}}
@extends('layouts.frontend')

@section('title', 'Suman Tech – Best Computer Institute in Muzaffarpur | Making You Future Ready')
@section('meta_description', 'Suman Tech Muzaffarpur – ISO Certified computer institute offering DCA, ADCA, Tally Prime, DIGITA, Web Design courses. Est. 2022 by Er. Rashmi Jaiswal.')

@section('content')

{{-- ══ HERO SECTION ══ --}}
<section class="hero-section position-relative overflow-hidden" style="background:linear-gradient(135deg,#0B1F3A 0%,#0E2D5A 60%,#163970 100%);min-height:88vh;display:flex;align-items:center;">
    {{-- Background dots --}}
    <div class="position-absolute inset-0 w-100 h-100" style="background-image:radial-gradient(circle,rgba(255,255,255,.05) 1px,transparent 1px);background-size:34px 34px;"></div>
    <div class="position-absolute" style="inset:0;background:radial-gradient(ellipse 800px 500px at 80% 50%,rgba(44,156,219,.15) 0%,transparent 70%);"></div>

    <div class="container py-5 position-relative">
        <div class="row align-items-center g-5">
            {{-- Left Content --}}
            <div class="col-lg-6">
                <div class="d-inline-flex align-items-center gap-2 mb-4 px-3 py-2 rounded-pill" style="background:rgba(240,165,0,.12);border:1px solid rgba(240,165,0,.3);">
                    <span style="width:7px;height:7px;background:var(--gold);border-radius:50%;animation:pulse 1.5s infinite;"></span>
                    <span style="color:var(--gold2);font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">🏆 ISO 9001:2015 & 21001:2018 Certified</span>
                </div>

                <h1 class="mb-3" style="font-family:'Playfair Display',serif;font-size:clamp(2.2rem,5vw,3.6rem);font-weight:900;color:#fff;line-height:1.1;letter-spacing:-.02em;">
                    Making You<br>
                    <em style="font-style:normal;color:var(--gold);">Future Ready</em><br>
                    <span style="font-size:75%;">Since 2022</span>
                </h1>

                <p style="color:rgba(255,255,255,.72);font-size:1.05rem;line-height:1.75;max-width:480px;" class="mb-4">
                    Muzaffarpur's most trusted computer institute — offering job-ready courses in DCA, ADCA, Tally Prime, Digital Marketing, Web Design &amp; more.
                </p>

                <div class="d-flex gap-3 flex-wrap mb-5">
                    <a href="{{ route('home') ?? '#' }}" class="btn-st-gold d-inline-flex align-items-center gap-2" style="padding:13px 30px;border-radius:50px;font-weight:700;font-size:.95rem;background:linear-gradient(135deg,var(--gold),#E8950A);color:var(--navy);text-decoration:none;box-shadow:0 8px 24px rgba(240,165,0,.4);">
                        <i class="fas fa-arrow-right"></i> Explore Courses
                    </a>
                    <a href="{{ '#' ?? '#' }}" class="d-inline-flex align-items-center gap-2" style="padding:12px 26px;border-radius:50px;font-weight:600;font-size:.95rem;border:2px solid rgba(255,255,255,.3);color:#fff;text-decoration:none;backdrop-filter:blur(8px);background:rgba(255,255,255,.06);transition:all .2s;">
                        🎓 Verify Certificate
                    </a>
                </div>

                {{-- Stats --}}
                <div class="d-flex gap-4 flex-wrap pt-4" style="border-top:1px solid rgba(255,255,255,.12);">
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:900;color:var(--gold);">2000+</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.06em;">Students Trained</div>
                    </div>
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:900;color:var(--gold);">15+</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.06em;">Courses Offered</div>
                    </div>
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:900;color:var(--gold);">3+</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.06em;">Years Experience</div>
                    </div>
                    <div>
                        <div style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:900;color:var(--gold);">ISO</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.06em;">Certified</div>
                    </div>
                </div>
            </div>

            {{-- Right: Slider --}}
            <div class="col-lg-6 d-none d-lg-block">
                <div style="border-radius:20px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,.4);">
                    <div class="owl-carousel owl-theme" id="heroCarousel">
                        @if(isset($sliders) && $sliders->count() > 0)
                            @foreach($sliders as $slider)
                            <div class="item">
                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" style="width:100%;height:380px;object-fit:cover;">
                            </div>
                            @endforeach
                        @else
                            <div class="item">
                                <img src="{{ asset('images/slider1.jpg') }}" alt="Students Learning" style="width:100%;height:380px;object-fit:cover;">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/slider2.jpg') }}" alt="Computer Lab" style="width:100%;height:380px;object-fit:cover;">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/slider3.jpg') }}" alt="Students Group" style="width:100%;height:380px;object-fit:cover;">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/slider1.jpg') }}" alt="Computer Training" style="width:100%;height:380px;object-fit:cover;">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Floating badges --}}
                <div class="d-flex gap-3 mt-3">
                    <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow" style="background:#fff;flex:1;">
                        <span style="font-size:1.4rem;">🎯</span>
                        <div>
                            <div style="font-size:.7rem;color:var(--muted);">Placement Support</div>
                            <div style="font-size:.85rem;font-weight:700;color:var(--navy);">100% Assured</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow" style="background:#fff;flex:1;">
                        <span style="font-size:1.4rem;">📚</span>
                        <div>
                            <div style="font-size:.7rem;color:var(--muted);">Lab Practice</div>
                            <div style="font-size:.85rem;font-weight:700;color:var(--navy);">No Time Limit</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>@keyframes pulse{0%,100%{opacity:1}50%{opacity:.3}}</style>
</section>

{{-- ══ MARQUEE STRIP ══ --}}
<div style="background:var(--navy);padding:14px 0;overflow:hidden;">
    <div style="display:flex;gap:48px;animation:scroll 20s linear infinite;width:max-content;">
        @foreach(['DCA','ADCA','Tally Prime','DIGITA','Digital Marketing','Web Designing','ISO Certified','Muzaffarpur #1 Institute','Placement Support','DCA','ADCA','Tally Prime','DIGITA','Digital Marketing','Web Designing','ISO Certified','Muzaffarpur #1 Institute','Placement Support'] as $item)
        <span style="color:rgba(255,255,255,.55);font-size:.85rem;font-weight:600;white-space:nowrap;display:flex;align-items:center;gap:8px;">
            <span style="color:var(--gold);font-size:.55rem;">◆</span> {{ $item }}
        </span>
        @endforeach
    </div>
</div>
<style>@keyframes scroll{from{transform:translateX(0)}to{transform:translateX(-50%)}}</style>

{{-- ══ ABOUT SECTION ══ --}}
<section class="py-5" style="background:var(--off);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-5 reveal">
                <div class="position-relative" style="height:420px;border-radius:20px;overflow:hidden;background:linear-gradient(135deg,var(--blue),var(--sky));">
                    <img src="{{ asset('public/website/images/about-img.png') }}" alt="About Suman Tech" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none'">
                    <div class="position-absolute bottom-0 start-0 m-3 d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow" style="background:#fff;">
                        <div style="width:42px;height:42px;background:linear-gradient(135deg,var(--blue),var(--sky));border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-school" style="color:white;font-size:.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;color:var(--navy);font-size:.9rem;">Est. 2022</div>
                            <div style="font-size:.72rem;color:var(--muted);">Muzaffarpur, Bihar</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 reveal">
                <span class="section-label">About Us</span>
                <h2 class="section-heading">An Institution That Gives<br>a <em>New Path to Life</em></h2>
                <p class="section-sub">Suman Tech is one of the best computer institutes in Muzaffarpur, established in February 2022 by <strong>Er. Rashmi Jaiswal</strong>. We offer job-ready training from basic to advanced level, empowering every student with practical skills.</p>

                <div class="row g-2 my-3">
                    @foreach(['No lab time restrictions','Expert teachers per course','ISO certified institute','Placement assistance','LMS Online Portal','Verified certificates'] as $feat)
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2" style="font-size:.88rem;color:var(--muted);">
                            <span style="width:18px;height:18px;background:rgba(21,87,176,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-check" style="font-size:.55rem;color:var(--blue);"></i>
                            </span>
                            {{ $feat }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('about') }}" class="btn-st-primary mt-2" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;">
                    <i class="fas fa-arrow-right"></i> Read More About Us
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══ COURSES SECTION ══ --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-label">Our Courses</span>
            <h2 class="section-heading">We Are Offering You Courses For<br><em>Learning & Developing</em> Your Skills</h2>
        </div>

        @php
        $staticCourses = [
            ['title'=>'DCA – Diploma in Computer Application','desc'=>'Foundational computer skills. Covers MS Office, Internet, and basic programming.','tag'=>'Popular','duration'=>'2 Months','color'=>'#0B3D8C','icon'=>'fa-desktop'],
            ['title'=>'ADCA – Advanced Diploma in Computer Application','desc'=>'Advanced skills from basic to expert. Best course for complete computer knowledge.','tag'=>'Bestseller','duration'=>'4 Months','color'=>'#1557B0','icon'=>'fa-laptop'],
            ['title'=>'Tally Prime – E-Accounting','desc'=>'Master Tally Prime for GST filing, accounting and financial management.','tag'=>'Job Ready','duration'=>'3 Months','color'=>'#0E6B50','icon'=>'fa-calculator'],
            ['title'=>'DIGITA – Diploma in GST, Income Tax & Accounting','desc'=>'Complete diploma covering GST, Income Tax, Tally, and Accounting.','tag'=>'New','duration'=>'6 Months','color'=>'#6B1F3A','icon'=>'fa-file-invoice-dollar'],
            ['title'=>'HTML – Web Development','desc'=>'Build beautiful websites using HTML, CSS and JavaScript from scratch.','tag'=>null,'duration'=>'2 Months','color'=>'#0B4D6C','icon'=>'fa-code'],
            ['title'=>'Digital Marketing','desc'=>'Learn SEO, Social Media, Google Ads and grow businesses online.','tag'=>null,'duration'=>'3 Months','color'=>'#3D1F6B','icon'=>'fa-bullhorn'],
        ];
        @endphp

        <div class="row g-4">
            @foreach($staticCourses as $course)
            <div class="col-md-4 col-sm-6 reveal">
                <div class="st-card h-100">
                    <div style="height:150px;background:linear-gradient(135deg,{{ $course['color'] }},rgba(0,0,0,.3) 150%);display:flex;align-items:center;justify-content:center;position:relative;">
                        <i class="fas {{ $course['icon'] }}" style="font-size:2.5rem;color:rgba(255,255,255,.25);"></i>
                        @if($course['tag'])
                        <span class="position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill" style="background:var(--gold);color:var(--navy);font-size:.68rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;">{{ $course['tag'] }}</span>
                        @endif
                    </div>
                    <div class="p-3">
                        <h5 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:8px;">{{ $course['title'] }}</h5>
                        <p style="font-size:.85rem;color:var(--muted);line-height:1.65;margin-bottom:14px;">{{ $course['desc'] }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size:.78rem;color:var(--muted);"><i class="far fa-clock me-1"></i>{{ $course['duration'] }}</span>
                            <a href="{{ route('home') ?? '#' }}" style="font-size:.82rem;font-weight:700;color:var(--blue);text-decoration:none;">View Details →</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('home') ?? '#' }}" class="btn-st-primary" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;">
                <i class="fas fa-th-large"></i> View All Courses
            </a>
        </div>
    </div>
</section>

{{-- ══ LATEST NEWS ══ --}}
@if(isset($latestNews) && $latestNews->count() > 0)
<section class="py-5" style="background:var(--off);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 reveal">
            <div>
                <span class="section-label">Latest Updates</span>
                <h2 class="section-heading">News &amp; <em>Events</em></h2>
            </div>
            <a href="{{ route('news-events') ?? '#' }}" class="btn-st-outline" style="text-decoration:none;font-size:.85rem;padding:8px 20px;">View All</a>
        </div>
        <div class="row g-4">
            @foreach($latestNews as $item)
            <div class="col-md-4 reveal">
                <div class="news-card card h-100">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="card-img-top" style="height:180px;object-fit:cover;" onerror="this.onerror=null;this.src='{{ asset('images/news-placeholder.jpg') }}'">
                    <div class="card-body">
                        <span class="badge mb-2 px-3 py-1 rounded-pill" style="background:{{ $item->category === 'event' ? 'rgba(240,165,0,.15)' : 'rgba(21,87,176,.1)' }};color:{{ $item->category === 'event' ? 'var(--gold)' : 'var(--blue)' }};font-size:.72rem;font-weight:700;">{{ ucfirst($item->category) }}</span>
                        <h6 class="card-title fw-bold" style="color:var(--navy);">{{ Str::limit($item->title, 70) }}</h6>
                        <p class="card-text" style="font-size:.85rem;color:var(--muted);">{{ Str::limit($item->short_description, 100) }}</p>
                        <a href="{{ route('news.show', $item->slug) }}" class="btn-st-primary" style="display:inline-flex;align-items:center;gap:6px;text-decoration:none;font-size:.82rem;padding:7px 18px;">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══ TEACHERS SECTION ══ --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-label">Our Teachers</span>
            <h2 class="section-heading">Expert Faculty For <em>Every Course</em></h2>
        </div>
        @if(isset($teamMembers) && $teamMembers->count() > 0)
        <div class="row g-4">
            @foreach($teamMembers->take(4) as $member)
            <div class="col-lg-3 col-md-6 reveal">
                <div class="card team-card" onclick="showMemberDetail({{ $member->id }})">
                    <img src="{{ $member->photo_url ?? asset('images/default-avatar.png') }}" alt="{{ $member->name }}" class="team-photo" onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                    <div class="team-name">{{ $member->name }}</div>
                    <div class="team-designation">{{ $member->designation }}</div>
                    @if($member->department)
                    <div class="team-dept mt-1" style="font-size:.78rem;color:var(--muted);">{{ $member->department }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Static fallback --}}
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 reveal">
                <div class="card team-card">
                    <img src="{{ asset('public/uploads/teacher/c9e718b55a6c67ecca067a2dff76639f.png') }}" alt="Er Rashmi Jaiswal" class="team-photo" onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                    <div class="team-name">Er. Rashmi Jaiswal</div>
                    <div class="team-designation">Founder & CEO</div>
                    <p class="text-muted mt-2" style="font-size:.82rem;">Professional Engineer, 10+ years experience. MBA in IT & Marketing.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 reveal">
                <div class="card team-card">
                    <div class="team-photo d-flex align-items-center justify-content-center" style="width:110px;height:110px;background:var(--off);margin:0 auto 14px;">
                        <i class="fas fa-user" style="font-size:2.5rem;color:var(--muted);"></i>
                    </div>
                    <div class="team-name">Tally Faculty</div>
                    <div class="team-designation">Tally & Accounting Expert</div>
                    <p class="text-muted mt-2" style="font-size:.82rem;">Specialized in Tally Prime, GST filing, and e-accounting.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 reveal">
                <div class="card team-card">
                    <div class="team-photo d-flex align-items-center justify-content-center" style="width:110px;height:110px;background:var(--off);margin:0 auto 14px;">
                        <i class="fas fa-user" style="font-size:2.5rem;color:var(--muted);"></i>
                    </div>
                    <div class="team-name">Web Design Faculty</div>
                    <div class="team-designation">Web Development</div>
                    <p class="text-muted mt-2" style="font-size:.82rem;">Teaches HTML, CSS, JavaScript and modern web design.</p>
                </div>
            </div>
        </div>
        @endif
        <div class="text-center mt-4">
            <a href="{{ route('team') }}" class="btn-st-outline" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;">Meet All Teachers</a>
        </div>
    </div>
</section>

{{-- ══ TESTIMONIALS ══ --}}
@if(isset($testimonials) && $testimonials->count() > 0)
<section class="py-5" style="background:var(--off);">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-label">Testimonials</span>
            <h2 class="section-heading">Love From Our <em>Students & Parents</em></h2>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-4 reveal">
                <div class="testimonial-card h-100">
                    <div class="quote-icon">"</div>
                    <div class="stars mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= ($testimonial->rating ?? 5) ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <p style="font-size:.92rem;color:var(--muted);line-height:1.75;margin-bottom:18px;">{{ $testimonial->content }}</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" width="44" height="44" class="rounded-circle" style="object-fit:cover;border:2px solid var(--gold);" onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}'">
                        <div>
                            <div style="font-weight:700;font-size:.92rem;color:var(--navy);">{{ $testimonial->name }}</div>
                            <div style="font-size:.78rem;color:var(--muted);">{{ $testimonial->designation }} @if($testimonial->organization) – {{ $testimonial->organization }} @endif</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('testimonials') }}" class="btn-st-outline" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;">View All Testimonials</a>
        </div>
    </div>
</section>
@endif

{{-- ══ ISO CERTIFICATIONS ══ --}}
<section class="py-5" style="background:linear-gradient(135deg,var(--navy) 0%,#163970 100%);">
    <div class="container">
        <div class="row align-items-center g-5 reveal">
            <div class="col-md-6">
                <span class="section-label" style="color:var(--sky);">Certifications</span>
                <h2 class="section-heading" style="color:#fff;">Certified By <em>ISO Standards</em></h2>
                <p class="section-sub" style="color:rgba(255,255,255,.6);">Suman Tech is independently certified to meet international standards of educational excellence and quality management.</p>
            </div>
            <div class="col-md-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-center p-4 rounded-3" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);">
                            <div style="font-size:2rem;margin-bottom:10px;">🏅</div>
                            <div style="color:var(--gold);font-family:'Playfair Display',serif;font-weight:700;margin-bottom:6px;">ISO 9001:2015</div>
                            <div style="font-size:.8rem;color:rgba(255,255,255,.5);">Quality Management System</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-4 rounded-3" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);">
                            <div style="font-size:2rem;margin-bottom:10px;">🎓</div>
                            <div style="color:var(--gold);font-family:'Playfair Display',serif;font-weight:700;margin-bottom:6px;">ISO 21001:2018</div>
                            <div style="font-size:.8rem;color:rgba(255,255,255,.5);">Educational Organizations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ CTA BANNER ══ --}}
<section style="background:var(--off);padding:70px 0 80px;">
    <div class="container">
        <div class="reveal p-5 rounded-4 d-flex flex-wrap align-items-center justify-content-between gap-4" style="background:linear-gradient(135deg,var(--gold) 0%,#E8950A 100%);box-shadow:0 20px 60px rgba(240,165,0,.35);">
            <div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:900;color:var(--navy);margin-bottom:8px;">Ready to Start Your Tech Journey? 🚀</h2>
                <p style="color:rgba(11,31,58,.65);margin:0;">Enroll today and take the first step towards a brighter career.</p>
            </div>
            <a href="{{ route('contact') }}" style="background:var(--navy);color:#fff;font-weight:700;padding:14px 36px;border-radius:50px;text-decoration:none;box-shadow:0 8px 24px rgba(11,31,58,.3);white-space:nowrap;transition:transform .2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''">
                Enroll Now
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#heroCarousel').owlCarousel({
        items: 1, loop: true, autoplay: true,
        autoplayTimeout: 5000, autoplayHoverPause: true,
        nav: true, dots: true,
        navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
    })
        .catch(error => {
            console.error(error);
        });
})
        .catch(error => {
            console.error(error);
        });
</script>
@endpush








<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team - Teachers of Bihar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        /* TOP HEADER */
        .top-header { background: #1b2a4a; padding: 10px 0; }
        .top-header .site-title { color: #fff; font-size: 22px; font-weight: 700; }
        .top-header .site-tagline { color: #aab8d4; font-size: 12px; margin-top: 2px; }
        .top-header .logo-img { width: 55px; height: 55px; border-radius: 50%; border: 2px solid #aab8d4; object-fit: cover; }
        .auth-btn { background: transparent; border: 1px solid #aab8d4; color: #aab8d4; padding: 5px 14px; border-radius: 4px; font-size: 12px; text-decoration: none; }
        .auth-btn:hover { background: #aab8d4; color: #1b2a4a; }
        /* MAIN NAV */
        .main-nav { background: #7a3f10; padding: 0; }
        .main-nav .nav-link { color: #f0e0d0 !important; font-size: 13px; padding: 12px 14px !important; border-right: 1px solid rgba(255,255,255,0.12); white-space: nowrap; }
        .main-nav .nav-link:first-child { border-left: 1px solid rgba(255,255,255,0.12); }
        .main-nav .nav-link:hover, .main-nav .nav-link.active { background: rgba(255,255,255,0.15); color: #fff !important; }
        .main-nav .dropdown-menu { background: #8b4a1e; border: none; border-radius: 0 0 4px 4px; min-width: 160px; }
        .main-nav .dropdown-item { color: #f0e0d0; font-size: 13px; padding: 8px 16px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .main-nav .dropdown-item:hover { background: rgba(255,255,255,0.15); color: white; }
        .dashboard-btn { background: #c0392b; color: white !important; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; font-size: 9px; text-align: center; text-decoration: none; margin: 5px 10px; flex-shrink: 0; line-height: 1.1; }
        .dashboard-btn:hover { background: #a93226; }
        /* BREADCRUMB */
        .breadcrumb-area { background: white; border-bottom: 1px solid #e5e5e5; padding: 10px 0; }
        .breadcrumb-area h2 { font-size: 20px; font-weight: 700; color: #333; }
        .breadcrumb { margin: 0; background: none; padding: 0; }
        .breadcrumb-item a { color: #7a3f10; text-decoration: none; font-size: 13px; }
        .breadcrumb-item.active { color: #777; font-size: 13px; }
        /* SOCIAL SIDEBAR */
        .social-sidebar { position: fixed; right: 0; top: 40%; z-index: 999; display: flex; flex-direction: column; }
        .social-sidebar a { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; text-decoration: none; margin-bottom: 1px; transition: transform 0.2s; }
        .social-sidebar a:hover { transform: translateX(-5px); }
        .s-li { background: #0077b5; } .s-wa { background: #25d366; } .s-sh { background: #555; } .s-fb { background: #3b5998; } .s-tg { background: #0088cc; }
        /* CONTENT */
        .content-wrap { background: #f0f0f0; background-image: repeating-linear-gradient(0deg,transparent,transparent 19px,rgba(180,210,190,0.3) 20px), repeating-linear-gradient(90deg,transparent,transparent 19px,rgba(180,210,190,0.3) 20px); min-height: 400px; padding: 20px 0 50px; }
        .cat-heading { text-align: center; margin: 25px 0 15px; }
        .cat-heading h3 { display: inline-block; font-size: 15px; font-weight: 700; color: #1b2a4a; letter-spacing: 2px; text-transform: uppercase; border-bottom: 3px solid #7a3f10; padding-bottom: 6px; }
        /* TEAM CARD */
        .team-card { background: white; border-radius: 4px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; cursor: pointer; height: 100%; text-align: center; }
        .team-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .card-img-area { width: 100%; aspect-ratio: 1; background: linear-gradient(135deg,#1b2a4a 0%,#7a3f10 100%); display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: 700; color: white; position: relative; overflow: hidden; }
        .card-img-area img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
        .card-info-area { padding: 10px 8px; border-top: 2px solid #7a3f10; }
        .card-member-name { font-size: 13px; font-weight: 600; color: #222; margin-bottom: 2px; }
        .card-member-role { font-size: 11px; color: #777; }
        .card-member-loc { font-size: 11px; color: #999; margin-top: 2px; }
        /* CATEGORY TABS */
        .cat-tabs { background: white; border-bottom: 1px solid #ddd; padding: 8px 0; overflow-x: auto; white-space: nowrap; scrollbar-width: none; }
        .cat-tabs::-webkit-scrollbar { display: none; }
        .cat-tab { display: inline-block; padding: 5px 14px; margin: 0 3px; border: 1px solid #ccc; border-radius: 20px; font-size: 12px; color: #555; text-decoration: none; cursor: pointer; transition: all 0.2s; }
        .cat-tab:hover, .cat-tab.active { background: #7a3f10; border-color: #7a3f10; color: white; }
        /* SEARCH */
        .search-input { padding: 7px 15px 7px 35px; border: 1px solid #ccc; border-radius: 3px; font-size: 13px; width: 260px; outline: none; }
        .search-input:focus { border-color: #7a3f10; }
        .search-wrap { position: relative; display: inline-block; }
        .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #999; font-size: 13px; }
        /* MODAL */
        .member-modal .modal-content { border-radius: 8px; overflow: hidden; border: none; }
        .member-modal .modal-header { background: #1b2a4a; color: white; border: none; }
        .member-modal .btn-close { filter: brightness(0) invert(1); }
        .detail-avatar { width: 100px; height: 100px; border-radius: 8px; background: linear-gradient(135deg,#1b2a4a,#7a3f10); display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 700; color: white; flex-shrink: 0; overflow: hidden; }
        .detail-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 15px; }
        .detail-item { background: #f8f5f0; border-radius: 6px; padding: 10px 12px; border-left: 3px solid #7a3f10; }
        .detail-item .lbl { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #7a3f10; font-weight: 600; }
        .detail-item .val { font-size: 13px; color: #333; font-weight: 500; margin-top: 2px; }
        @media(max-width:768px){ .social-sidebar{display:none;} .detail-grid{grid-template-columns:1fr;} }
    </style>
</head>
<body>

<!-- SOCIAL SIDEBAR -->
<div class="social-sidebar">
    <a href="#" class="s-li"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="s-wa"><i class="fab fa-whatsapp"></i></a>
    <a href="#" class="s-sh"><i class="fas fa-share-alt"></i></a>
    <a href="#" class="s-fb"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="s-tg"><i class="fab fa-telegram-plane"></i></a>
</div>

<!-- TOP HEADER -->
<div class="top-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <img src="https://www.teachersofbihar.org/public/web/images/logo-1.png" alt="Logo" class="logo-img"
                     onerror="this.onerror=null;this.style.opacity='0.3'">
                <div>
                    <div class="site-title">Teachers of Bihar</div>
                    <div class="site-tagline">The Change Makers</div>
                </div>
            </div>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="auth-btn"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="auth-btn"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
            @endauth
        </div>
    </div>
</div>

<!-- MAIN NAV -->
<div class="main-nav">
    <div class="container">
        <div class="d-flex align-items-center flex-wrap">
            <a href="{{ route('team.index') }}" class="nav-link active">Home</a>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">About Us</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Who We Are</a></li>
                    <li><a class="dropdown-item" href="#">Our Mission</a></li>
                    <li><a class="dropdown-item" href="{{ route('team.index') }}">Our Team</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Our Ideas</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Initiatives</a></li>
                    <li><a class="dropdown-item" href="#">Projects</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Publication</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Books</a></li>
                    <li><a class="dropdown-item" href="#">Reports</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Online Publication</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Articles</a></li>
                </ul>
            </div>
            <a href="#" class="nav-link">🚩 Project Shikshak Sathi</a>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">News & Events</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">News</a></li>
                    <li><a class="dropdown-item" href="#">Events</a></li>
                </ul>
            </div>
            <a href="#" class="nav-link">EIP</a>
            <a href="#" class="nav-link">Competition</a>
            <a href="#" class="nav-link">Award</a>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Gallery</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Photos</a></li>
                    <li><a class="dropdown-item" href="#">Videos</a></li>
                </ul>
            </div>
            <a href="#" class="nav-link">Testimonial</a>
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Contact</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Contact Us</a></li>
                </ul>
            </div>
            @auth
            <a href="{{ route('admin.dashboard') }}" class="dashboard-btn">Dash<br>board</a>
            @endauth
        </div>
    </div>
</div>

<!-- BREADCRUMB -->
<div class="breadcrumb-area">
    <div class="container d-flex justify-content-between align-items-center">
        <h2>Our Team</h2>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('team.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">About Us</a></li>
                <li class="breadcrumb-item active">Our Team</li>
            </ol>
        </nav>
    </div>
</div>

<!-- CATEGORY TABS -->
<div class="cat-tabs">
    <div class="container">
        <a class="cat-tab active" onclick="filterAll(this);return false;" href="#">All</a>
        @foreach($categories as $cat => $members)
            <a class="cat-tab" onclick="scrollToCat('{{ Str::slug($cat) }}',this);return false;" href="#">
                {{ $cat }} ({{ $members->count() }})
            </a>
        @endforeach
    </div>
</div>

<!-- CONTENT -->
<div class="content-wrap">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center pt-2 pb-1">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Search name, district..." oninput="doSearch(this.value)">
            </div>
            <small class="text-muted">Members: <strong id="countDisplay">{{ collect($categories)->flatten()->count() }}</strong></small>
        </div>

        @foreach($categories as $cat => $members)
        <div class="category-section" id="{{ Str::slug($cat) }}">
            <div class="cat-heading"><h3>{{ $cat }}</h3></div>
            <div class="row g-3">
                @foreach($members as $member)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 team-item"
                     data-name="{{ strtolower($member->name) }}"
                     data-district="{{ strtolower($member->district ?? '') }}"
                     data-cat="{{ strtolower($cat) }}">
                    <div class="team-card" onclick="openModal({{ $member->id }})">
                        <div class="card-img-area">
                            @if($member->image && file_exists(public_path('uploads/user/'.$member->image)))
                                <img src="{{ asset('uploads/user/'.$member->image) }}" alt="{{ $member->name }}">
                            @else
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="card-info-area">
                            <div class="card-member-name">{{ $member->name }}</div>
                            @if($member->role)<div class="card-member-role">{{ $member->role }}</div>@endif
                            @if($member->district)<div class="card-member-loc"><i class="fas fa-map-marker-alt" style="font-size:10px;color:#7a3f10;"></i> {{ $member->district }}</div>@endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- MODAL -->
<div class="modal fade member-modal" id="memberModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:580px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user me-2"></i>Member Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="modalBody"><div class="text-center py-4"><div class="spinner-border" style="color:#1b2a4a;"></div></div></div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div style="background:#1b2a4a;color:rgba(255,255,255,0.7);text-align:center;padding:18px;font-size:12px;">
    &copy; {{ date('Y') }} Teachers of Bihar &middot; The Change Makers
</div>

<!-- Hidden Data -->
<div id="memberData" style="display:none;">
@foreach($categories as $cat => $members)
@foreach($members as $member)
<div data-id="{{ $member->id }}"
     data-name="{{ $member->name }}"
     data-role="{{ $member->role ?? '' }}"
     data-cat="{{ $cat }}"
     data-designation="{{ $member->designation ?? '' }}"
     data-school="{{ $member->school ?? '' }}"
     data-block="{{ $member->block ?? '' }}"
     data-district="{{ $member->district ?? '' }}"
     data-contribution="{{ $member->contribution ?? '' }}"
     data-description="{{ $member->description ?? '' }}"
     data-image="{{ ($member->image && file_exists(public_path('uploads/user/'.$member->image))) ? asset('uploads/user/'.$member->image) : '' }}">
</div>
@endforeach
@endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openModal(id){
    var el=document.querySelector('#memberData [data-id="'+id+'"]');
    if(!el)return;
    var d=el.dataset;
    var av=d.image?'<div class="detail-avatar"><img src="'+d.image+'" alt="'+d.name+'"></div>':'<div class="detail-avatar">'+d.name.charAt(0).toUpperCase()+'</div>';
    var fields=[{l:'Category',v:d.cat},{l:'Role',v:d.role},{l:'Designation',v:d.designation},{l:'School',v:d.school},{l:'Block',v:d.block},{l:'District',v:d.district},{l:'Contribution',v:d.contribution}].filter(f=>f.v);
    document.getElementById('modalBody').innerHTML='<div style="padding:20px;display:flex;gap:18px;align-items:flex-start;">'+av+'<div><h4 style="color:#1b2a4a;font-family:serif;margin-bottom:4px;">'+d.name+'</h4><div style="color:#888;font-size:13px;margin-bottom:8px;">'+(d.role||'Teacher')+'</div><span style="background:#7a3f10;color:white;font-size:11px;padding:3px 12px;border-radius:20px;">'+d.cat+'</span></div></div><div class="detail-grid">'+fields.map(f=>'<div class="detail-item"><div class="lbl">'+f.l+'</div><div class="val">'+f.v+'</div></div>').join('')+'</div>'+(d.description?'<div style="padding:0 15px 15px;"><div style="background:#f8f5f0;border-left:4px solid #1b2a4a;padding:12px;border-radius:4px;font-size:13px;color:#555;">'+d.description+'</div></div>':'');
    new bootstrap.Modal(document.getElementById('memberModal')).show();
}
function doSearch(q){
    q=q.toLowerCase().trim();var n=0;
    document.querySelectorAll('.team-item').forEach(function(el){var s=!q||el.dataset.name.includes(q)||el.dataset.district.includes(q);el.style.display=s?'':'none';if(s)n++;});
    document.getElementById('countDisplay').textContent=n;
    document.querySelectorAll('.category-section').forEach(function(s){s.style.display=[...s.querySelectorAll('.team-item')].some(e=>e.style.display!='none')?'':'none';});
}
function scrollToCat(id,btn){
    document.querySelectorAll('.cat-tab').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    var el=document.getElementById(id);
    if(el)el.scrollIntoView({behavior:'smooth',block:'start'});
}
function filterAll(btn){
    document.querySelectorAll('.cat-tab').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    window.scrollTo({top:0,behavior:'smooth'});
}
</script>
</body>
</html>


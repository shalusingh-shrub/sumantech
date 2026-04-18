<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Profile') - Suman Tech</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background:#f0f2f5; font-family:'Segoe UI',sans-serif; }
        .top-navbar { background:#fff; border-bottom:1px solid #e0e0e0; padding:12px 20px; position:sticky; top:0; z-index:100; display:flex; align-items:center; justify-content:space-between; }
        .top-navbar .brand { font-weight:700; color:#1a2a6c; font-size:18px; }
        .top-navbar .user-info { display:flex; align-items:center; gap:10px; }
        .top-navbar .user-info img { width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid #1a2a6c; }
        .profile-sidebar { background:#fff; border-radius:12px; padding:24px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.06); }
        .profile-sidebar .avatar { width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #1a2a6c; margin-bottom:12px; }
        .profile-sidebar h5 { font-weight:700; color:#1a2a6c; margin-bottom:4px; }
        .profile-sidebar .role-badge { background:#1a2a6c; color:#fff; padding:3px 12px; border-radius:20px; font-size:12px; }
        .profile-tabs { background:#fff; border-radius:12px; padding:6px; box-shadow:0 2px 10px rgba(0,0,0,0.06); display:flex; gap:4px; flex-wrap:wrap; margin-bottom:20px; }
        .profile-tabs a { padding:8px 16px; border-radius:8px; text-decoration:none; color:#555; font-size:14px; font-weight:500; transition:all 0.2s; }
        .profile-tabs a:hover { background:#f0f4ff; color:#1a2a6c; }
        .profile-tabs a.active { background:#1a2a6c; color:#fff; }
        .profile-tabs a i { margin-right:6px; }
        .content-card { background:#fff; border-radius:12px; padding:28px; box-shadow:0 2px 10px rgba(0,0,0,0.06); }
        .section-title { font-weight:700; color:#1a2a6c; font-size:16px; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #f0f0f0; }
        .info-row { display:flex; gap:10px; align-items:center; padding:8px 0; border-bottom:1px solid #f5f5f5; }
        .info-row i { width:20px; color:#1a2a6c; }
        .verified-badge { background:#28a745; color:#fff; padding:2px 10px; border-radius:20px; font-size:11px; }
        @media(max-width:768px) { .profile-tabs a span { display:none; } .profile-tabs a i { margin:0; } }
    </style>
    @stack('styles')
</head>
<body>
{{-- Top Navbar --}}
<div class="top-navbar">
    <div class="brand"><i class="fas fa-chalkboard-teacher me-2"></i>Suman Tech</div>
    <div class="user-info">
        @php
    $authUser = auth()->user()->load('profile');
    $avatarUrl = $authUser->avatar_url;
@endphp
@if($avatarUrl && !str_contains($avatarUrl, 'ui-avatars'))
<img src="{{ $avatarUrl }}" alt="{{ auth()->user()->name }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid #1a2a6c;">
@else
<div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#1a2a6c,#2a4a9c);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;">
  {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
</div>
@endif
        <div>
            <div style="font-weight:600;font-size:14px;color:#1a2a6c;">{{ auth()->user()->name }}</div>
            <div style="font-size:11px;color:#888;">{{ ucfirst(auth()->user()->user_type ?? 'User') }}</div>
        </div>
        <div class="dropdown">
            <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                @if(auth()->user()->can_access_admin || auth()->user()->hasRole(['super_admin','admin','editor']))
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Admin Panel</a></li>
                <li><hr class="dropdown-divider"></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-3"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible mb-3"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-md-3">
            <div class="profile-sidebar">
                @if(auth()->user()->profile && auth()->user()->profile->avatar)
<img src="{{ asset('storage/'.auth()->user()->profile->avatar) }}" alt="Avatar" class="avatar">
@else
<div class="avatar d-flex align-items-center justify-content-center fw-bold fs-4"
     style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;">
  {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
</div>
@endif
                <h5>{{ auth()->user()->name }}</h5>
                <p class="text-muted mb-2" style="font-size:13px;">{{ auth()->user()->email }}</p>
                <span class="role-badge">{{ ucfirst(auth()->user()->user_type ?? 'user') }}</span>
                @if(auth()->user()->profile && auth()->user()->profile->district)
                <p class="mt-2 mb-0" style="font-size:13px;color:#666;"><i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ auth()->user()->profile->district }}</p>
                @endif
                @if(auth()->user()->profile && auth()->user()->profile->designation)
                <p class="mb-0 mt-1" style="font-size:12px;color:#888;">{{ auth()->user()->profile->designation }}</p>
                @endif
                @if(auth()->user()->profile && auth()->user()->profile->department)
                <p class="mb-0" style="font-size:12px;color:#888;">{{ auth()->user()->profile->department }}</p>
                @endif
                @if(auth()->user()->profile && auth()->user()->profile->highest_education)
                <p class="mb-0" style="font-size:12px;color:#888;">{{ auth()->user()->profile->highest_education }}</p>
                @endif
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-md-9">
            {{-- Tabs --}}
            <div class="profile-tabs">
                <a href="{{ route('portal.overview') }}" class="{{ request()->routeIs('portal.overview') ? 'active' : '' }}">
                    <i class="fas fa-home"></i><span> Overview</span>
                </a>
                <a href="{{ route('portal.personal') }}" class="{{ request()->routeIs('portal.personal') ? 'active' : '' }}">
                    <i class="fas fa-user"></i><span> Personal</span>
                </a>
                <a href="{{ route('portal.education') }}" class="{{ request()->routeIs('portal.education') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i><span> Education & Social</span>
                </a>
                <a href="{{ route('portal.achievements') }}" class="{{ request()->routeIs('portal.achievements') ? 'active' : '' }}">
                    <i class="fas fa-trophy"></i><span> Achievements</span>
                </a>
                <a href="{{ route('portal.security') }}" class="{{ request()->routeIs('portal.security') ? 'active' : '' }}">
                    <i class="fas fa-lock"></i><span> Security</span>
                </a>
                <a href="{{ route('portal.activity') }}" class="{{ request()->routeIs('portal.activity') ? 'active' : '' }}">
                    <i class="fas fa-history"></i><span> Activity</span>
                </a>
            </div>

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>



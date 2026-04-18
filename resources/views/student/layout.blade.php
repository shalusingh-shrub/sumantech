<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Student Portal') — Suman Tech</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root { --navy: #0f2044; --gold: #F0A500; }
    body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
    .sidebar { width: 240px; min-height: 100vh; background: var(--navy); position: fixed; top: 0; left: 0; z-index: 100; }
    .sidebar .brand { padding: 20px 16px; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .sidebar .brand h5 { color: var(--gold); font-weight: 800; margin: 0; }
    .sidebar .brand small { color: rgba(255,255,255,0.6); font-size: 11px; }
    .sidebar .nav-link { color: rgba(255,255,255,0.75); padding: 10px 16px; font-size: 14px; display: flex; align-items: center; gap: 10px; border-left: 3px solid transparent; transition: all 0.2s; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left-color: var(--gold); }
    .sidebar .nav-link i { width: 18px; text-align: center; }
    .main-content { margin-left: 240px; }
    .top-bar { background: #fff; padding: 12px 24px; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center; }
    .top-bar .student-name { font-weight: 700; color: var(--navy); }
    .content-area { padding: 24px; }
    .stat-card { border-radius: 12px; padding: 20px; color: #fff; border: none; }
    .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
  </style>
  @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
  <div class="brand">
    <h5><i class="fas fa-graduation-cap me-2"></i>Suman Tech</h5>
    <small>Student Portal</small>
  </div>
  <nav class="mt-2">
    <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
      <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('student.profile') }}" class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
      <i class="fas fa-user"></i> My Profile
    </a>
    <a href="{{ route('student.courses') }}" class="nav-link {{ request()->routeIs('student.courses') ? 'active' : '' }}">
      <i class="fas fa-book"></i> My Courses
    </a>
    <a href="{{ route('student.invoices') }}" class="nav-link {{ request()->routeIs('student.invoices') ? 'active' : '' }}">
      <i class="fas fa-file-invoice-dollar"></i> My Invoices
    </a>
    <div style="border-top:1px solid rgba(255,255,255,0.1);margin-top:auto;position:absolute;bottom:0;width:100%;">
      <a href="{{ route('home') }}" class="nav-link">
        <i class="fas fa-globe"></i> Visit Website
      </a>
      <form method="POST" action="{{ route('student.logout') }}">
        @csrf
        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start" style="color:rgba(255,100,100,0.9);">
          <i class="fas fa-sign-out-alt"></i> Logout
        </button>
      </form>
    </div>
  </nav>
</div>

{{-- Main Content --}}
<div class="main-content">
  <div class="top-bar">
    <span class="student-name"><i class="fas fa-user-circle me-2" style="color:var(--gold);"></i>{{ session('student_name') }}</span>
    <a href="{{ route('student.invoices') }}" class="btn btn-sm btn-warning fw-bold">
      <i class="fas fa-file-invoice me-1"></i> My Invoices
    </a>
    <a href="{{ route('student.result') }}" class="btn btn-sm btn-success fw-bold">
      <i class="fas fa-star me-1"></i> My Result
    </a>
  </div>

  <div class="content-area">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @yield('content')
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>




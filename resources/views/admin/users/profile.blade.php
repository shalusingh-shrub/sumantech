<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Suman Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --navy:#1a2a5e; --brown:#7B3F00; }
        body { background: #f0f2f5; font-family: 'Roboto', sans-serif; }
        .sidebar { background: linear-gradient(180deg, var(--navy) 0%, var(--brown) 100%); min-height: 100vh; width: 250px; position: fixed; left: 0; top: 0; z-index: 100; padding-top: 20px; }
        .sidebar .brand { padding: 15px 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: center; }
        .sidebar .brand img { width: 50px; height: 50px; border-radius: 50%; border: 2px solid white; }
        .sidebar .brand h5 { color: white; margin: 10px 0 0; font-size: 14px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8) !important; padding: 12px 20px; display: flex; align-items: center; gap: 10px; transition: all 0.3s; font-size: 14px; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white !important; background: rgba(255,255,255,0.1); border-left-color: white; }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .sidebar .nav-heading { color: rgba(255,255,255,0.5); font-size: 11px; text-transform: uppercase; padding: 15px 20px 5px; letter-spacing: 1px; }
        .main-content { margin-left: 250px; }
        .topbar { background: white; padding: 15px 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .content-area { padding: 25px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 3px 15px rgba(0,0,0,0.08); }
        .profile-banner { height: 120px; background: linear-gradient(135deg, var(--navy), var(--brown)); border-radius: 12px 12px 0 0; }
        .profile-avatar { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, var(--navy), var(--brown)); display: flex; align-items: center; justify-content: center; color: white; font-size: 36px; font-weight: 700; border: 4px solid white; margin-top: -45px; margin-left: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.15); }
        .form-control, .form-select { border: 2px solid #e9ecef; border-radius: 8px; padding: 10px 15px; font-size: 14px; }
        .form-control:focus { border-color: var(--brown); box-shadow: 0 0 0 0.2rem rgba(123,63,0,0.15); }
        .form-label { font-weight: 600; font-size: 13px; color: #555; }
        .section-title { font-size: 14px; font-weight: 700; color: var(--navy); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #f0f2f5; }
        .role-badge { padding: 6px 18px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .role-admin { background: #fef3cd; color: #856404; }
        .role-editor { background: #d1ecf1; color: #0c5460; }
        .role-viewer { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="brand">
        <img src="https://www.teachersofbihar.org/public/web/images/logo-1.png" alt="Logo"
             onerror="this.src='https://ui-avatars.com/api/?name=TOB&background=ffffff&color=1a2a5e&size=50'">
        <h5>Suman Tech</h5>
    </div>
    <div class="nav-heading">Main Menu</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="{{ route('team.index') }}" class="nav-link" target="_blank"><i class="fas fa-globe"></i> View Website</a>
    <div class="nav-heading">Team Management</div>
    <a href="{{ route('admin.teams.index') }}" class="nav-link"><i class="fas fa-users"></i> All Teams</a>
    <a href="{{ route('admin.teams.create') }}" class="nav-link"><i class="fas fa-user-plus"></i> Add Member</a>
    @if(Auth::user()->role === 'admin')
    <div class="nav-heading">Admin</div>
    <a href="{{ route('admin.users.index') }}" class="nav-link"><i class="fas fa-user-shield"></i> User Management</a>
    @endif
    <div class="nav-heading">Account</div>
    <a href="{{ route('admin.profile') }}" class="nav-link active"><i class="fas fa-user-circle"></i> My Profile</a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-link border-0 w-100 text-start" style="background:none;cursor:pointer;"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</div>

<div class="main-content">
    <div class="topbar">
        <h4 style="margin:0;font-size:18px;"><i class="fas fa-user-circle me-2" style="color:var(--brown);"></i>My Profile</h4>
    </div>
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="profile-banner"></div>
                    <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div class="p-4 pt-2">
                        <h4 style="font-weight:700;color:#1a1a2e;margin-bottom:4px;">{{ $user->name }}</h4>
                        <p style="color:#888;font-size:14px;margin-bottom:15px;">{{ $user->email }}</p>
                        <span class="role-badge role-{{ $user->role }}">
                            @if($user->role === 'admin') <i class="fas fa-crown me-1"></i>
                            @elseif($user->role === 'editor') <i class="fas fa-edit me-1"></i>
                            @else <i class="fas fa-eye me-1"></i> @endif
                            {{ ucfirst($user->role) }}
                        </span>
                        <div class="mt-4" style="font-size:13px;color:#666;">
                            <div class="mb-2"><i class="fas fa-phone me-2" style="color:var(--brown);"></i>{{ $user->phone ?? 'Not set' }}</div>
                            <div class="mb-2"><i class="fas fa-calendar me-2" style="color:var(--brown);"></i>Member since {{ $user->created_at->format('M Y') }}</div>
                            <div><i class="fas fa-circle me-2" style="color:{{ $user->is_active ? '#28a745' : '#dc3545' }};font-size:10px;"></i>{{ $user->is_active ? 'Active Account' : 'Inactive' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="section-title">Update Profile</div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                            </div>
                        @endif
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <small class="text-muted">(contact admin to change)</small></label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+91 XXXXXXXXXX">
                                </div>
                            </div>
                            <div class="section-title mt-3">Change Password</div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">New Password <small class="text-muted">(leave blank to keep)</small></label>
                                    <input type="password" name="password" class="form-control" minlength="6">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn" style="background:linear-gradient(135deg,var(--navy),var(--brown));color:white;padding:10px 30px;font-weight:600;border-radius:8px;">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



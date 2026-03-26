<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teams - Teachers of Bihar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; font-family: 'Roboto', sans-serif; }
        .sidebar { background: linear-gradient(180deg, #1a2a5e 0%, #7B3F00 100%); min-height: 100vh; width: 250px; position: fixed; left: 0; top: 0; z-index: 100; padding-top: 20px; }
        .sidebar .brand { padding: 15px 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: center; }
        .sidebar .brand img { width: 50px; height: 50px; border-radius: 50%; border: 2px solid white; }
        .sidebar .brand h5 { color: white; margin: 10px 0 0; font-size: 14px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8) !important; padding: 12px 20px; display: flex; align-items: center; gap: 10px; transition: all 0.3s; font-size: 14px; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white !important; background: rgba(255,255,255,0.1); border-left-color: white; }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .sidebar .nav-heading { color: rgba(255,255,255,0.5); font-size: 11px; text-transform: uppercase; padding: 15px 20px 5px; letter-spacing: 1px; }
        .main-content { margin-left: 250px; }
        .topbar { background: white; padding: 15px 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .content-area { padding: 25px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 3px 15px rgba(0,0,0,0.08); }
        .table th { background: #f8f9fa; font-weight: 600; font-size: 13px; color: #555; border: none; }
        .table td { font-size: 13px; vertical-align: middle; }
        .member-img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid #dee2e6; }
        .member-initials { width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg,#1a2a5e,#7B3F00); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="brand">
        <img src="https://www.teachersofbihar.org/public/web/images/logo-1.png" alt="Logo" onerror="this.onerror=null;this.style.opacity='0.3'">
        <h5>Teachers of Bihar</h5>
    </div>
    <div class="nav-heading">Main Menu</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="{{ route('team.index') }}" class="nav-link" target="_blank"><i class="fas fa-globe"></i> View Website</a>
    <div class="nav-heading">Team Management</div>
    <a href="{{ route('admin.teams.index') }}" class="nav-link active"><i class="fas fa-users"></i> All Teams</a>
    <a href="{{ route('admin.teams.create') }}" class="nav-link"><i class="fas fa-user-plus"></i> Add Member</a>
    <div class="nav-heading">Account</div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-link border-0 w-100 text-start" style="background:none;cursor:pointer;"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</div>

<div class="main-content">
    <div class="topbar">
        <h4 style="margin:0;font-size:18px;"><i class="fas fa-users me-2" style="color:#7B3F00;"></i>Manage Team Members</h4>
        <a href="{{ route('admin.teams.create') }}" class="btn btn-sm" style="background:#7B3F00;color:white;">
            <i class="fas fa-plus me-1"></i> Add New Member
        </a>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Role</th>
                                <th>District</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teams as $team)
                            <tr>
                                <td class="ps-4">{{ $team->id }}</td>
                                <td>
                                    @if($team->image && file_exists(public_path('uploads/user/'.$team->image)))
                                        <img src="{{ asset('uploads/user/'.$team->image) }}" class="member-img" alt="{{ $team->name }}">
                                    @else
                                        <div class="member-initials">{{ strtoupper(substr($team->name, 0, 1)) }}</div>
                                    @endif
                                </td>
                                <td><strong>{{ $team->name }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $team->category }}</span></td>
                                <td>{{ $team->role ?? '-' }}</td>
                                <td>{{ $team->district ?? '-' }}</td>
                                <td>
                                    @if($team->is_featured)
                                        <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> Yes</span>
                                    @else
                                        <span class="text-muted">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($team->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    No team members found.
                                    <a href="{{ route('admin.teams.create') }}">Add one now</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">{{ $teams->links() }}</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

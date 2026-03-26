<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team Member - Teachers of Bihar</title>
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
        .topbar { background: white; padding: 15px 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .content-area { padding: 25px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 3px 15px rgba(0,0,0,0.08); }
        .form-control, .form-select { border: 2px solid #e9ecef; border-radius: 8px; padding: 10px 15px; transition: all 0.3s; font-size: 14px; }
        .form-control:focus, .form-select:focus { border-color: #7B3F00; box-shadow: 0 0 0 0.2rem rgba(123,63,0,0.15); }
        .form-label { font-weight: 600; font-size: 13px; color: #555; }
        .section-title { font-size: 14px; font-weight: 700; color: #1a2a5e; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #f0f2f5; }
        .btn-save { background: linear-gradient(135deg, #1a2a5e, #7B3F00); border: none; color: white; padding: 12px 30px; border-radius: 8px; font-weight: 600; }
        .btn-save:hover { opacity: 0.9; color: white; }
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
    <a href="{{ route('admin.teams.index') }}" class="nav-link"><i class="fas fa-users"></i> All Teams</a>
    <a href="{{ route('admin.teams.create') }}" class="nav-link active"><i class="fas fa-user-plus"></i> Add Member</a>
    <div class="nav-heading">Account</div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf @method("PUT")
        <button type="submit" class="nav-link border-0 w-100 text-start" style="background:none;cursor:pointer;"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</div>

<div class="main-content">
    <div class="topbar">
        <h4 style="margin:0;font-size:18px;"><i class="fas fa-user-plus me-2" style="color:#7B3F00;"></i>Edit Team Member: {{ $team->name }}</h4>
    </div>

    <div class="content-area">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method("PUT")
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="section-title">Basic Information</div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $team->name) }}" placeholder="e.g. Shiv Kumar Sinha" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role</label>
                                    <input type="text" name="role" class="form-control" value="{{ old('role', $team->role) }}" placeholder="e.g. Teacher, IT Expert">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category *</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contribution in ToB</label>
                                    <input type="text" name="contribution" class="form-control" value="{{ old('contribution', $team->contribution) }}" placeholder="e.g. Technical Support">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="designation" class="form-control" value="{{ old('designation', $team->designation) }}" placeholder="e.g. Middle School Teacher, Nalanda">
                                </div>
                            </div>

                            <div class="section-title mt-3">School/Location Details</div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">School Name</label>
                                    <input type="text" name="school" class="form-control" value="{{ old('school', $team->school) }}" placeholder="e.g. MS Rajgir">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Block</label>
                                    <input type="text" name="block" class="form-control" value="{{ old('block', $team->block) }}" placeholder="e.g. Rajgir">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">District</label>
                                    <input type="text" name="district" class="form-control" value="{{ old('district', $team->district) }}" placeholder="e.g. Nalanda">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description / Bio</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Brief description about the member...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="section-title">Photo</div>
                            <div class="mb-3">
                                <label class="form-label">Upload Photo</label>
                                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted">JPG, PNG, GIF - Max 2MB</small>
                            </div>
                            <div id="imagePreview" style="display:none;text-align:center;margin-top:10px;">
                                <img id="preview" src="#" alt="Preview" style="max-width:100%;max-height:200px;border-radius:8px;border:2px solid #dee2e6;">
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="section-title">Settings</div>
                            <div class="mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="is_featured" class="form-check-input" id="featured" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured"><i class="fas fa-star text-warning me-1"></i>Featured Member</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="status" class="form-check-input" id="status" {{ old('status', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status"><i class="fas fa-eye text-success me-1"></i>Active / Visible</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-2"></i>Save Team Member
                        </button>
                        <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>

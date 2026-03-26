{{-- File: resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Teachers of Bihar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); min-height: 100vh; display: flex; align-items: center; padding: 20px 0; }
        .register-card { border: none; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 520px; width: 100%; }
        .register-header { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); border-radius: 12px 12px 0 0; padding: 25px; text-align: center; color: #fff; }
        .btn-register { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); color: #fff; border: none; padding: 12px; font-size: 16px; border-radius: 8px; }
        .btn-register:hover { opacity: 0.9; color: #fff; }
        .type-card { border: 2px solid #e0e0e0; border-radius: 10px; padding: 15px; cursor: pointer; transition: all 0.2s; text-align: center; }
        .type-card:hover { border-color: #1a2a6c; background: #f0f4ff; }
        .type-card.active { border-color: #1a2a6c; background: #e8eeff; }
        .type-card i { font-size: 28px; color: #1a2a6c; margin-bottom: 6px; }
        .type-card p { margin: 0; font-weight: 600; font-size: 14px; color: #1a2a6c; }
        #student-fields, #teacher-fields { display: none; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="register-card card">
        <div class="register-header">
            <i class="fas fa-chalkboard-teacher fa-3x mb-2"></i>
            <h4 class="mb-1">Teachers of Bihar</h4>
            <p class="mb-0 opacity-75">The Change Makers</p>
        </div>
        <div class="card-body p-4">
            <h5 class="text-center mb-4" style="color:#1a2a6c;">Create Your Account</h5>

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Account Type --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Account Type <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="type-card {{ old('user_type') === 'teacher' ? 'active' : '' }}" onclick="selectType('teacher')">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>Teacher</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="type-card {{ old('user_type') === 'student' ? 'active' : '' }}" onclick="selectType('student')">
                                <i class="fas fa-user-graduate"></i>
                                <p>Student</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user_type" id="user_type" value="{{ old('user_type', '') }}" required>
                    @error('user_type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- Name & Email --}}
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Apna pura naam likhein" required>
                        </div>
                        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="Email address" required>
                        </div>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="Mobile number" required>
                        </div>
                        @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- District & School --}}
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">District</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" name="district" class="form-control"
                                value="{{ old('district') }}" placeholder="Apna district likhein">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">School Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                            <input type="text" name="school" class="form-control"
                                value="{{ old('school') }}" placeholder="School ka naam">
                        </div>
                    </div>
                    {{-- Student Class --}}
                    <div class="col-12" id="student-fields">
                        <label class="form-label fw-semibold">Class</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <select name="class" class="form-select">
                                <option value="">Select Class</option>
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('class') == $i ? 'selected' : '' }}>Class {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Min 8 characters" required>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Password dobara likhein" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-register w-100">
                    <i class="fas fa-user-plus me-2"></i> Register
                </button>

                <p class="text-center mt-3 mb-0" style="font-size:14px;">
                    Already registered? <a href="{{ route('login') }}" style="color:#1a2a6c;font-weight:600;">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</div>
<script>
function selectType(type) {
    document.getElementById('user_type').value = type;
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.getElementById('student-fields').style.display = type === 'student' ? 'block' : 'none';
}
// Restore on page load
var t = document.getElementById('user_type').value;
if (t) {
    document.querySelectorAll('.type-card').forEach(function(c) {
        if (c.querySelector('p').innerText.toLowerCase() === t) c.classList.add('active');
    });
    if (t === 'student') document.getElementById('student-fields').style.display = 'block';
}
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login — Suman Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0B1F3A, #1557B0); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #fff; border-radius: 20px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo i { font-size: 3rem; color: #F0A500; }
        .logo h4 { color: #0B1F3A; font-weight: 800; margin-top: 10px; }
        .logo p { color: #666; font-size: .9rem; }
        .form-control { border-radius: 10px; padding: 12px 15px; border: 2px solid #e0e0e0; }
        .form-control:focus { border-color: #1557B0; box-shadow: none; }
        .btn-login { background: linear-gradient(135deg, #0B1F3A, #1557B0); color: #fff; border: none; border-radius: 10px; padding: 13px; font-weight: 700; width: 100%; font-size: 1rem; }
        .input-group-text { background: #f8f9fa; border: 2px solid #e0e0e0; border-right: none; border-radius: 10px 0 0 10px; }
        .input-group .form-control { border-left: none; border-radius: 0 10px 10px 0; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-graduation-cap"></i>
            <h4>Suman Tech</h4>
            <p>Student Portal — Login</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
            @endforeach
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('student.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Registration ID / Mobile / Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="login" class="form-control" placeholder="ST-XXXXXXXXXX ya Mobile" value="{{ old('login') }}" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/') }}" style="color: #666; font-size: .85rem;">
                <i class="fas fa-arrow-left me-1"></i>Back to Website
            </a>
        </div>
    </div>
</body>
</html>
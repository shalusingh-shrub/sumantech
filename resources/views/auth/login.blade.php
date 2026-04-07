{{-- File: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Suman Tech</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 420px; width: 100%; }
        .login-header { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); border-radius: 12px 12px 0 0; padding: 30px; text-align: center; color: #fff; }
        .btn-login { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); color: #fff; border: none; padding: 12px; font-size: 16px; }
        .btn-login:hover { opacity: 0.9; color: #fff; }
        .captcha-box { display: flex; align-items: center; gap: 10px; }
        .captcha-img-wrap { border: 1px solid #ccc; border-radius: 6px; overflow: hidden; cursor: pointer; }
        .btn-refresh-captcha { background: #1a2a6c; color: #fff; border: none; border-radius: 6px; padding: 8px 12px; cursor: pointer; font-size: 14px; flex-shrink: 0; }
        .btn-refresh-captcha:hover { opacity: 0.85; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="login-card card">
        <div class="login-header">
            <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
            <h4 class="mb-1">Suman Tech</h4>
            <p class="mb-0 opacity-75">The Learning Platform</p>
        </div>
        <div class="card-body p-4">
            <h5 class="text-center mb-4" style="color:#1a2a6c;">Sign In to Your Account</h5>

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label for="remember" class="form-check-label">Remember me</label>
                    </div>
                </div>

                {{-- CAPTCHA - Server side se generate hoga --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Enter CAPTCHA</label>
                    <div class="captcha-box mb-2">
                        <div class="captcha-img-wrap">
                            <img src="{{ route('captcha.image') }}" id="captchaImg" alt="CAPTCHA" style="height:45px;display:block;">
                        </div>
                        <button type="button" class="btn-refresh-captcha" onclick="refreshCaptcha()" title="Refresh CAPTCHA">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <input type="text" name="captcha" id="captchaInput"
                        class="form-control @error('captcha') is-invalid @enderror"
                        placeholder="Type CAPTCHA here"
                        required autocomplete="off" maxlength="6"
                        value="{{ old('captcha') }}">
                    @error('captcha')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Capital/small letter dono chalega</small>
                </div>

                <button type="submit" class="btn btn-login w-100 rounded-pill">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>

            <p class="text-center mt-3 mb-0" style="font-size:14px;">
    
</p>
            <hr>
            <div class="text-center">
                <a href="{{ route('home') }}" style="color:#1a2a6c;font-size:13px;"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
            </div>
            <hr>
            <div class="text-center">
                <p style="font-size:13px;color:#666;margin-bottom:8px;">Don't have an account?</p>
                <a href="{{ route('register') }}" class="btn btn-outline-primary w-100" style="border-radius:25px;font-weight:600;">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function refreshCaptcha() {
    var img = document.getElementById('captchaImg');
    img.src = "{{ route('captcha.image') }}?v=" + Math.random();
    document.getElementById('captchaInput').value = '';
    document.getElementById('captchaInput').focus();
}
</script>
</body>
</html>



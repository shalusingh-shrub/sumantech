{{-- File: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Teachers of Bihar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 420px; width: 100%; }
        .login-header { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); border-radius: 12px 12px 0 0; padding: 30px; text-align: center; color: #fff; }
        .btn-login { background: linear-gradient(135deg, #1a2a6c, #6b3a1f); color: #fff; border: none; padding: 12px; font-size: 16px; }
        .btn-login:hover { opacity: 0.9; color: #fff; }
        .captcha-box { display: flex; align-items: center; gap: 10px; }
        .captcha-img-wrap { background: #f0f4ff; border: 1px solid #ccc; border-radius: 6px; padding: 6px 12px; font-size: 22px; font-weight: bold; letter-spacing: 6px; color: #1a2a6c; font-family: 'Courier New', monospace; min-width: 130px; text-align: center; user-select: none; position: relative; overflow: hidden; }
        .captcha-img-wrap::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(45deg, transparent, transparent 4px, rgba(100,100,200,0.08) 4px, rgba(100,100,200,0.08) 8px); }
        .captcha-noise { position: absolute; inset: 0; }
        .btn-refresh-captcha { background: #1a2a6c; color: #fff; border: none; border-radius: 6px; padding: 6px 10px; cursor: pointer; font-size: 14px; }
        .btn-refresh-captcha:hover { opacity: 0.85; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="login-card card">
        <div class="login-header">
            <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
            <h4 class="mb-1">Teachers of Bihar</h4>
            <p class="mb-0 opacity-75">The Change Makers</p>
        </div>
        <div class="card-body p-4">
            <h5 class="text-center mb-4" style="color:#1a2a6c;">Sign In to Your Account</h5>

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach
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
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color:#1a2a6c;">Forgot password?</a>
                    @endif
                </div>
                <!-- CAPTCHA -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Enter CAPTCHA</label>
                    <div class="captcha-box mb-2">
                        <div class="captcha-img-wrap" id="captchaDisplay">
                            <canvas id="captchaCanvas" width="140" height="40"></canvas>
                        </div>
                        <button type="button" class="btn-refresh-captcha" onclick="generateCaptcha()" title="Refresh CAPTCHA">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <input type="text" name="captcha_input" id="captchaInput" class="form-control" placeholder="Type CAPTCHA here" required autocomplete="off" maxlength="6">
                    <input type="hidden" name="captcha_code" id="captchaCode">
                </div>
                <button type="submit" class="btn btn-login w-100 rounded-pill">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>
            <hr>
            <div class="text-center">
                <a href="{{ route('home') }}" style="color:#1a2a6c;font-size:13px;"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let captchaText = '';

    function generateCaptcha() {
        const canvas = document.getElementById('captchaCanvas');
        const ctx = canvas.getContext('2d');
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        captchaText = '';
        for (let i = 0; i < 5; i++) {
            captchaText += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        // Draw background
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const grad = ctx.createLinearGradient(0, 0, canvas.width, 0);
        grad.addColorStop(0, '#e8eeff');
        grad.addColorStop(1, '#fce4ec');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Draw noise lines
        for (let i = 0; i < 5; i++) {
            ctx.strokeStyle = `rgba(${Math.random()*150},${Math.random()*150},${Math.random()*200},0.4)`;
            ctx.beginPath();
            ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
            ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
            ctx.stroke();
        }

        // Draw dots
        for (let i = 0; i < 30; i++) {
            ctx.fillStyle = `rgba(${Math.random()*100},${Math.random()*100},${Math.random()*200},0.3)`;
            ctx.beginPath();
            ctx.arc(Math.random() * canvas.width, Math.random() * canvas.height, 1.5, 0, Math.PI * 2);
            ctx.fill();
        }

        // Draw text
        const colors = ['#1a2a6c', '#b31217', '#006400', '#7b1fa2'];
        ctx.font = 'bold 22px Courier New';
        for (let i = 0; i < captchaText.length; i++) {
            ctx.save();
            ctx.fillStyle = colors[Math.floor(Math.random() * colors.length)];
            ctx.translate(18 + i * 23, 28);
            ctx.rotate((Math.random() - 0.5) * 0.5);
            ctx.fillText(captchaText[i], 0, 0);
            ctx.restore();
        }

        document.getElementById('captchaCode').value = captchaText;
        document.getElementById('captchaInput').value = '';
    }

    // Validate captcha before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const input = document.getElementById('captchaInput').value.trim();
        if (input !== captchaText) {
            e.preventDefault();
            alert('CAPTCHA galat hai! Please dobara try karein.');
            generateCaptcha();
        }
    });

    // Init on load
    generateCaptcha();
</script>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Suman Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a2a5e 0%, #7B3F00 100%); min-height: 100vh; display: flex; align-items: center; font-family: 'Roboto', sans-serif; }
        .register-box { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 450px; width: 100%; margin: auto; }
        .reg-header { background: linear-gradient(135deg, #7B3F00, #1a2a5e); padding: 30px; text-align: center; color: white; }
        .reg-header h3 { margin: 0; font-size: 22px; font-weight: 700; }
        .reg-body { padding: 30px; }
        .form-control { border: 2px solid #e9ecef; border-radius: 8px; padding: 10px 15px; }
        .form-control:focus { border-color: #7B3F00; box-shadow: 0 0 0 0.2rem rgba(123,63,0,0.15); }
        .btn-register { background: linear-gradient(135deg, #7B3F00, #1a2a5e); border: none; color: white; padding: 12px; border-radius: 8px; font-weight: 600; width: 100%; transition: all 0.3s; }
        .btn-register:hover { opacity: 0.9; color: white; }
        .form-label { font-weight: 600; color: #444; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <div class="reg-header">
                <h3><i class="fas fa-user-plus me-2"></i>Create Account</h3>
                <p style="margin:5px 0 0;opacity:0.85;font-size:13px;">Suman Tech - Register</p>
            </div>
            <div class="reg-body">
                @if($errors->any())
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-1"></i> Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope me-1"></i> Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-1"></i> Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-1"></i> Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                    </div>
                    <button type="submit" class="btn btn-register"><i class="fas fa-user-plus me-2"></i>Create Account</button>
                </form>
                <hr>
                <div class="text-center">
                    <small>Already have account? <a href="{{ route('login') }}" style="color:#7B3F00;">Login here</a></small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






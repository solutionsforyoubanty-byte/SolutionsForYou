<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fd7151, #fdce59);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            animation: patternMove 30s linear infinite;
        }

        .login-card {
            width: 420px;
            backdrop-filter: blur(20px);
            background: rgba(255,255,255,0.15);
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
            border-radius: 25px;
            padding: 40px;
            color: #fff;
            position: relative;
            z-index: 2;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, rgba(255,255,255,0.3), transparent, rgba(255,255,255,0.3));
            border-radius: 25px;
            z-index: -1;
        }

        .login-card h3 {
            font-weight: 700;
        }

        .input-group-text {
            background: transparent;
            border-right: 0;
            color: #fff;
        }

        .form-control {
            background: rgba(255,255,255,0.2);
            border-left: 0;
            border-color: rgba(255,255,255,0.4);
            color: #fff;
        }

        .form-control::placeholder {
            color: #eee;
        }

        .btn-login {
            background: #fff;
            color: #333;
            font-weight: 600;
            border-radius: 10px;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: #fff;
        }

        .btn-login:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @keyframes patternMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(20px) translateY(20px); }
        }

        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-floating input {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 0 0;
            transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
        }
    </style>
</head>

<body>

<!-- ========== Toast Notification ========== -->
<div class="toast-container">

    @if(session('toast_error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-x-circle-fill me-2"></i> {{ session('toast_error') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('toast_success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('toast_success') }}
                </div>
            </div>
        </div>
    @endif

</div>

<!-- ========== Login Card ========== -->
<div class="login-card">
    <div class="login-header">
        <div class="login-logo">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h3 class="mb-1">SolutionsForYou</h3>
        <p class="mb-0 opacity-75">Admin Panel Access</p>
    </div>

    <form action="{{ route('admin.login') }}" method="POST" id="loginForm">
        @csrf

        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="email" placeholder="admin@example.com" required>
            <label for="email"><i class="bi bi-envelope-fill me-2"></i>Email Address</label>
        </div>

        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            <label for="password"><i class="bi bi-lock-fill me-2"></i>Password</label>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label small" for="remember">
                    Remember me
                </label>
            </div>
            <a href="#" class="small text-white-50">Forgot Password?</a>
        </div>

        <button type="submit" class="btn btn-login w-100 py-3 fw-bold">
            <i class="bi bi-box-arrow-in-right me-2"></i> 
            <span class="login-text">Sign In</span>
            <span class="loading-text d-none">
                <span class="spinner-border spinner-border-sm me-2"></span>
                Signing in...
            </span>
        </button>

        <div class="text-center mt-3">
            <small class="text-white-50">
                <i class="bi bi-shield-check me-1"></i>
                Secure Admin Access
            </small>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Auto-hide toast after 3 seconds
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    toastElList.map(function (toastEl) {
        let toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    });

    // Login form enhancement
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const loginText = submitBtn.querySelector('.login-text');
        const loadingText = submitBtn.querySelector('.loading-text');
        
        // Show loading state
        loginText.classList.add('d-none');
        loadingText.classList.remove('d-none');
        submitBtn.disabled = true;
        
        // Re-enable after 5 seconds (in case of slow response)
        setTimeout(() => {
            loginText.classList.remove('d-none');
            loadingText.classList.add('d-none');
            submitBtn.disabled = false;
        }, 5000);
    });

    // Floating label effect
    document.querySelectorAll('.form-floating input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
</script>

</body>
</html>

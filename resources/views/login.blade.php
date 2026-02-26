<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - eSakip</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0e5b8e 0%, #1a8392 100%);
            padding: 20px;
        }
        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }
        .login-card {
            width: 100%;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-header {
            background: #0e5b8e;
            border-radius: 15px 15px 0 0;
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .login-body {
            padding: 40px 30px;
        }
        .form-control:focus {
            border-color: #1a8392;
            box-shadow: 0 0 0 0.2rem rgba(26, 131, 146, 0.25);
        }
        .btn-login {
            background-color: #0e5b8e;
            border: none;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #1a8392;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 480px) {
            .login-header {
                padding: 20px 15px;
            }
            .login-header img {
                height: 50px !important;
            }
            .login-header h4 {
                font-size: 1.25rem;
            }
            .login-header p {
                font-size: 0.8rem;
            }
            .login-body {
                padding: 25px 20px;
            }
            .login-card {
                border-radius: 12px;
            }
        }
        
        @media (min-width: 768px) {
            .btn-login {
                width: auto;
                min-width: 200px;
            }
        }
    </style>
</head>
<body>

    <div class="login-page">
        <div class="login-container">
            <div class="login-card card">
                <div class="login-header">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" height="60" class="mb-3">
                    <h4 class="mb-1">eSakip</h4>
                    <p class="mb-0 small">Sistem Akuntabilitas Kinerja<br>Kabupaten Gunungkidul</p>
                </div>
                <div class="login-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-login text-white">
                                <i class="fas fa-sign-in-alt me-2"></i> Masuk
                            </button>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <a href="/" class="text-decoration-none">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

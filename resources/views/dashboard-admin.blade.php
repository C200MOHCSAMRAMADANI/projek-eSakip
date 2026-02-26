<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - eSakip</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

    <nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top rounded-bottom-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" height="45" class="me-2">
                
                <div class="d-flex flex-column brand-text">
                    <span class="fw-bold fs-4 brand-title">eSakip</span>
                    <span class="fw-normal brand-subtitle">kabupaten Gunungkidul</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ session('nama_lengkap') ?? 'Admin' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="main-content" style="padding-top: 120px;">
        <div class="container">
            <div class="page-header-bar mb-4 shadow-sm">
                <i class="fas fa-tachometer-alt fa-lg me-2"></i> 
                <span class="text-uppercase">Dashboard Admin</span>
            </div>

            <!-- Info User -->
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                Selamat datang, <strong>{{ session('nama_lengkap') ?? 'Admin' }}</strong>!
                Anda login sebagai <span class="badge bg-primary">{{ ucfirst(session('level') ?? 'admin') }}</span>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Total OPD</h5>
                            <h2 class="fw-bold text-primary">25</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Dokumen Upload</h5>
                            <h2 class="fw-bold text-success">150</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Capaian Kinerja</h5>
                            <h2 class="fw-bold text-warning">85%</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-eye fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Total Views</h5>
                            <h2 class="fw-bold text-info">1.2K</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Actions -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Pengaturan Sistem</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-database me-2"></i> Kelola Data OPD
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-upload me-2"></i> Kelola Dokumen
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-chart-bar me-2"></i> Kelola Data Pengukuran
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-users-cog me-2"></i> Kelola User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Laporan</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-pdf me-2"></i> Laporan Evaluasi
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-excel me-2"></i> Laporan Pengukuran
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-contract me-2"></i> Laporan Pelaporan
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-trophy me-2"></i> Laporan Prestasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p class="mb-0 fw-bold">Dikembangkan Oleh Diskominfo Kabupaten Gunungkidul.</p>
            <hr class="my-2">
            <div class="mb-3">
                <a href="https://x.com/kominfogk" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="https://www.facebook.com/share/17fyN7eJd4/" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/kominfogunungkidul?igsh=dTd6aGZ2NTRzbzM2" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://youtube.com/@kominfogunungkidul?si=R5Js1T-NZIYFALIz" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.onscroll = function() {
            var navbar = document.getElementById("mainNavbar");
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                navbar.classList.add("navbar-scrolled");
            } else {
                navbar.classList.remove("navbar-scrolled");
            }
        };
    </script>
</body>
</html>

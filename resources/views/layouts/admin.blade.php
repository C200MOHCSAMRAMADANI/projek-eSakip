<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - eSAKIP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        /* Sidebar CSS (Sama seperti sebelumnya) */
        .sidebar {
            min-height: 100vh;
            background-color: var(--primary-blue);
            color: #fff;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .sidebar-header {
            background-color: #0b4973;
            color: var(--login-white);
            text-align: center;
            padding: 20px 15px;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--primary-yellow);
        }
        .sidebar a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--primary-yellow);
            border-left: 4px solid var(--primary-yellow);
        }
        
        /* Tambahan CSS untuk Submenu agar lebih menjorok ke dalam */
        .sidebar .submenu a {
            padding: 10px 20px 10px 45px; /* Padding kiri lebih besar */
            font-size: 0.9rem;
            background-color: rgba(0, 0, 0, 0.15); /* Warna sedikit lebih gelap */
        }
        .sidebar .dropdown-toggle::after {
            display: none; /* Menyembunyikan panah bawaan bootstrap */
        }

        .content-wrapper { padding: 30px; width: 100%; }
        .admin-header-title {
            background-color: var(--login-white);
            padding: 15px 20px;
            border-radius: 8px;
            border-left: 6px solid var(--sakip-teal);
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column" style="width: 260px;">
            <div class="sidebar-header">
                <i class="fas fa-shield-alt me-2" style="color: var(--primary-yellow);"></i> eSAKIP ADMIN
            </div>
            
            <div class="p-3 mb-2" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle fa-2x me-3 text-light opacity-75"></i>
                    <div>
                        <small class="d-block" style="color: var(--primary-yellow); font-size: 0.75rem;">Selamat datang,</small>
                        <strong class="text-white">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</strong>
                    </div>
                </div>
            </div>

            <a href="/dashboard-admin" class="{{ Request::is('dashboard-admin') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>

            <a href="#masterSubmenu" data-bs-toggle="collapse" class="dropdown-toggle d-flex justify-content-between align-items-center {{ Request::is('admin/pengguna*') ? 'active' : '' }}">
                <span><i class="fas fa-database me-2"></i> Master</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <div class="collapse submenu {{ Request::is('admin/pengguna*') ? 'show' : '' }}" id="masterSubmenu">
                <a href="/admin/pengguna" class="{{ Request::is('admin/pengguna') ? 'text-warning' : '' }}">
                    <i class="fas fa-users me-2"></i> Pengguna
                </a>    
            </div>
            <a href="#dokumenSubmenu" data-bs-toggle="collapse" class="dropdown-toggle d-flex justify-content-between align-items-center {{ Request::is('admin/dokumen*') ? 'active' : '' }}">
                <span><i class="fas fa-file-alt me-2"></i> Dokumen Sakip</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <div class="collapse submenu {{ Request::is('admin/dokumen*') ? 'show' : '' }}" id="dokumenSubmenu">
                <a href="/admin/dokumen/perencanaan" class="{{ Request::is('admin/dokumen/perencanaan') ? 'text-warning' : '' }}">
                    <i class="fas fa-edit me-2"></i> Perencanaan
                </a>
            </div>

            <a href="#mediaSubmenu" data-bs-toggle="collapse" 
            class="dropdown-toggle d-flex justify-content-between align-items-center {{ Request::is('admin/media*') ? 'active' : '' }}">
                <span><i class="fas fa-photo-video me-2"></i> Media</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <div class="collapse submenu {{ Request::is('admin/media*') ? 'show' : '' }}" id="mediaSubmenu">
                <a href="/admin/media/album" class="{{ Request::is('admin/media/album') ? 'text-warning' : '' }}">
                    <i class="fas fa-folder me-2 small"></i> Album
                </a>
                <a href="/admin/media/galeri-foto" class="{{ Request::is('admin/media/galeri-foto') ? 'text-warning' : '' }}">
                    <i class="fas fa-image me-2 small"></i> Galeri Foto
                </a>
            </div>
            <a href="/" onclick="window.location.href='/'; return false;"><i class="fas fa-external-link-alt me-2"></i> Lihat Website Depan</a>
            
            <a href="/logout" class="mt-auto" style="background-color: #ff3b30; color: white; border-left: none;">
                <i class="fas fa-sign-out-alt me-2"></i> Keluar
            </a>
        </div>

        

        <div class="content-wrapper flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - eSAKIP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
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
        
        .sidebar .submenu a {
            padding: 10px 20px 10px 45px;
            font-size: 0.9rem;
            background-color: rgba(0, 0, 0, 0.15);
        }
        .sidebar .dropdown-toggle::after {
            display: none;
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

        /* Info Box Style - Sama dengan Admin */
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: .25rem;
            background: #fff;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
            border-bottom: 3px solid transparent;
        }
        .info-box-icon {
            border-radius: .25rem;
            align-items: center;
            display: flex;
            font-size: 1.875rem;
            justify-content: center;
            text-align: center;
            width: 70px;
            color: #fff;
        }
        .info-box-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.2;
            padding: 0 10px;
        }
        .info-box-text {
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #6c757d;
        }
        .info-box-number {
            display: block;
            font-weight: 700;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column" style="width: 260px;">
            <div class="sidebar-header">
                <i class="fw-bold fs-4 brand-title" style="color: var(--primary-yellow);"></i> eSAKIP CLIENT
            </div>
            
            <div class="p-3 mb-2" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle fa-2x me-3 text-light opacity-75"></i>
                    <div>
                        <small class="d-block" style="color: var(--primary-yellow); font-size: 0.75rem;">Selamat datang,</small>
                        <strong class="text-white">{{ Auth::user()->nama_lengkap ?? 'Client' }}</strong>
                    </div>
                </div>
            </div>

            <a href="/dashboard-client" class="{{ Request::is('dashboard-client') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>

            <a href="#dokumenSubmenu" data-bs-toggle="collapse" class="dropdown-toggle d-flex justify-content-between align-items-center {{ Request::is('client/dokumen*') ? 'active' : '' }}">
                <span><i class="fas fa-file-alt me-2"></i> Dokumen Sakip</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <div class="collapse submenu {{ Request::is('client/dokumen*') ? 'show' : '' }}" id="dokumenSubmenu">
                <a href="/client/dokumen/perencanaan" class="{{ Request::is('client/dokumen/perencanaan') ? 'text-warning' : '' }}">
                    <i class="fas fa-edit me-2"></i> Perencanaan
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

            <div class="admin-header-title">
                <h4 class="m-0 text-uppercase fw-bold" style="font-size: 1.1rem; color: #333;">
                    <i class="fas fa-home me-2 text-primary"></i> Dashboard Client
                </h4>
            </div>

            <!-- Statistik Cards - Sama Style dengan Admin -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #007bff;">
                        <span class="info-box-icon bg-primary"><i class="fas fa-file-upload"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">File ({{ date('Y') }})</span>
                            <span class="info-box-number">{{ $fileTahunIni ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #28a745;">
                        <span class="info-box-icon bg-success"><i class="fas fa-archive"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">File (Tahun Lalu)</span>
                            <span class="info-box-number">{{ $fileTahunLalu ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #ffc107;">
                        <span class="info-box-icon bg-warning text-white"><i class="fas fa-university"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Dokumen</span>
                            <span class="info-box-number">{{ $totalFileOPD ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #dc3545;">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Menunggu Verif</span>
                            <span class="info-box-number">{{ $dokumenMenunggu ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


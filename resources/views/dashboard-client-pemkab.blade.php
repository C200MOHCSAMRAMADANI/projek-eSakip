<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PEMKAB - eSAKIP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background-color: #f5f6fa;
        }
        
        .main-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #0b4973;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            background-color: #093d63;
            color: #fff;
            text-align: center;
            padding: 20px 15px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border-bottom: 2px solid #ffc107;
        }
        
        .sidebar-menu {
            flex: 1;
            padding: 10px 0;
            overflow-y: auto;
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
            color: #ffc107;
            border-left: 4px solid #ffc107;
        }
        
        .sidebar .submenu a {
            padding: 10px 20px 10px 45px;
            font-size: 0.9rem;
            background-color: rgba(0, 0, 0, 0.15);
        }
        
        .sidebar .dropdown-toggle::after {
            display: none;
        }
        
        .sidebar-user {
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-logout {
            background-color: #ff3b30;
            color: white;
            border-left: none;
            text-align: center;
        }
        
        .sidebar-logout:hover {
            background-color: #e32f27;
            color: white;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
            background-color: #f5f6fa;
            min-height: 100vh;
        }
        
        .admin-header-title {
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            border-left: 6px solid #17a2b8;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        /* Info Box Styles */
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="main-container">
        <!-- Sidebar (Kiri) -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-landmark me-2"></i> eSAKIP PEMKAB
            </div>
            
            <div class="sidebar-user mb-2">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle fa-2x me-3 text-light opacity-75"></i>
                    <div>
                        <small class="d-block" style="color: #ffc107; font-size: 0.75rem;">Selamat datang,</small>
                        <strong class="text-white">{{ Auth::user()->nama_lengkap ?? 'PEMKAB' }}</strong>
                    </div>
                </div>
            </div>

            <div class="sidebar-menu">
                <a href="/dashboard-client-pemkab" class="{{ Request::is('dashboard-client-pemkab') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>

                <a href="#dokumenSubmenu" data-bs-toggle="collapse" class="dropdown-toggle d-flex justify-content-between align-items-center {{ Request::is('client/dokumen*') ? 'active' : '' }}">
                    <span><i class="fas fa-file-alt me-2"></i> Dokumen Sakip</span>
                    <i class="fas fa-caret-down"></i>
                </a>
                <div class="collapse submenu {{ Request::is('client/dokumen*') ? 'show' : '' }}" id="dokumenSubmenu">
                    <a href="/client/dokumen/perencanaan-pemkab" class="{{ Request::is('client/dokumen/perencanaan-pemkab') ? 'text-warning' : '' }}">
                        <i class="fas fa-edit me-2"></i> Perencanaan
                    </a>
                </div>

                <a href="/" onclick="window.location.href='/'; return false;">
                    <i class="fas fa-external-link-alt me-2"></i> Lihat Website Depan
                </a>
            </div>

            <a href="/logout" class="sidebar-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Keluar
            </a>
        </div>

        <!-- Main Content (Kanan) -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="admin-header-title">
                <h4 class="m-0 text-uppercase fw-bold" style="font-size: 1.1rem; color: #333;">
                    <i class="fas fa-home me-2 text-primary"></i> Dashboard PEMKAB
                </h4>
            </div>

            <!-- Statistik Cards - Untuk PEMKAB -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #007bff;">
                        <span class="info-box-icon bg-primary"><i class="fas fa-file-upload"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">File Tahun Ini</span>
                            <span class="info-box-number">{{ $fileTahunIni ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #28a745;">
                        <span class="info-box-icon bg-success"><i class="fas fa-archive"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total File</span>
                            <span class="info-box-number">{{ $totalFile ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #17a2b8;">
                        <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">OPD Aktif</span>
                            <span class="info-box-number">{{ $totalOPD ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #ffc107;">
                        <span class="info-box-icon bg-warning text-white"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">OPD Sudah Upload</span>
                            <span class="info-box-number">{{ $opdSudahUpload ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #dc3545;">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">OPD Belum Upload</span>
                            <span class="info-box-number">{{ $opdBelumUpload ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #20c997;">
                        <span class="info-box-icon" style="background-color: #20c997;"><i class="fas fa-check-double"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Terverifikasi</span>
                            <span class="info-box-number">{{ $dokumenTerverifikasi ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box" style="border-bottom-color: #6c757d;">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-clock"></i></span>
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


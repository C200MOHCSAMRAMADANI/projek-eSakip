<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perencanaan PEMKAB - eSAKIP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f5f6fa; }
        .main-container { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; min-height: 100vh; background-color: #0b4973; color: #fff; display: flex; flex-direction: column; position: fixed; left: 0; top: 0; z-index: 1000; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
        .sidebar-header { background-color: #093d63; color: #fff; text-align: center; padding: 20px 15px; font-weight: 700; font-size: 1.1rem; border-bottom: 2px solid #ffc107; }
        .sidebar-menu { flex: 1; padding: 10px 0; overflow-y: auto; }
        .sidebar a { color: rgba(255,255,255,0.85); text-decoration: none; padding: 15px 20px; display: block; border-left: 4px solid transparent; transition: all 0.3s ease; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.1); color: #ffc107; border-left: 4px solid #ffc107; }
        .sidebar .submenu a { padding: 10px 20px 10px 45px; font-size: 0.9rem; background-color: rgba(0,0,0,0.15); }
        .sidebar .dropdown-toggle::after { display: none; }
        .sidebar-user { padding: 15px; border-top: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logout { background-color: #ff3b30; color: white; border-left: none; text-align: center; }
        .sidebar-logout:hover { background-color: #e32f27; color: white; }
        .main-content { flex: 1; margin-left: 260px; padding: 30px; background-color: #f5f6fa; min-height: 100vh; }
        .admin-header-title { background-color: #fff; padding: 15px 20px; border-radius: 8px; border-left: 6px solid #17a2b8; box-shadow: 0 2px 6px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; }
        .table-custom th { background-color: #0b4973; color: white; text-align: center; vertical-align: middle; }
        .table-custom td { vertical-align: middle; text-align: center; }
        .table-custom tbody tr:hover { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <div class="main-container">
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

        <div class="main-content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="admin-header-title">
                <h4 class="m-0 text-uppercase fw-bold" style="font-size: 1.1rem; color: #333;">
                    <i class="fas fa-folder-open me-2 text-primary"></i> Dokumen Perencanaan PEMKAB
                </h4>
                <div>
                    <a href="/dashboard-client-pemkab" class="btn btn-secondary btn-sm">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="/client/dokumen/upload-pemkab" class="btn btn-primary btn-sm">
                        <i class="fas fa-upload"></i> Upload
                    </a>
                </div>
            </div>

            <!-- 8 Dokumen PEMKAB -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-custom mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul Dokumen</th>
                                    <th width="10%">Tahun</th>
                                    <th width="12%">Status</th>
                                    <th width="12%">Download</th>
                                    <th width="15%">Verifikasi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $no = 1; @endphp
                                
                                @foreach($dokumenPEMKAB as $doc)
                                @php
                                $isUploaded = isset($doc['data']) && $doc['data'] !== null;
                                $dok = $isUploaded ? $doc['data'] : null;
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-start">{{ $doc['judul'] }}</td>
                                    <td>{{ $isUploaded ? $dok->tahun : '-' }}</td>
                                    <td>
                                        @if($isUploaded)
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Sudah Upload</span>
                                        @else
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> Belum Upload</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isUploaded)
                                        <a href="{{ asset('uploads/' . $dok->nama_file) }}" class="btn btn-sm btn-success" title="Download" download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @else
                                        <button class="btn btn-sm btn-secondary" title="Belum Upload" disabled>
                                            <i class="fas fa-download"></i>
                                        </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isUploaded)
                                            @if($dok->verifikasi == 1)
                                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                                            @else
                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu</span>
                                            @endif
                                        @else
                                        <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


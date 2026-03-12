<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Dokumen PEMKAB - eSAKIP</title>
    
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
        .upload-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; }
        .form-label { font-weight: 600; color: #333; }
        .upload-area { border: 2px dashed #dee2e6; border-radius: 10px; padding: 40px; text-align: center; background: #fafafa; transition: all 0.3s ease; cursor: pointer; }
        .upload-area:hover { border-color: #0b4973; background: #f0f7ff; }
        .upload-area.dragover { border-color: #0b4973; background: #e8f4fc; }
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
                    <i class="fas fa-upload me-2 text-primary"></i> Upload Dokumen PEMKAB
                </h4>
                <a href="/client/dokumen/perencanaan-pemkab" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="upload-card">
                <form action="{{ route('client.upload.pemkab.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="jenis_dokumen" class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select class="form-select" id="jenis_dokumen" name="jenis_dokumen" required>
                            <option value="">Pilih Jenis Dokumen</option>
                            <option value="RPJPD">RPJPD (Rencana Pembangunan Jangka Panjang Daerah)</option>
                            <option value="RPJMD">RPJMD (Rencana Pembangunan Jangka Menengah Daerah)</option>
                            <option value="RKPD">RKPD (Rencana Kerja Pemerintah Daerah)</option>
                            <option value="SK IKU">SK IKU (SK Indikator Kinerja Utama)</option>
                            <option value="LKJIP">LKJIP (Laporan Kinerja Instansi Pemerintah)</option>
                            <option value="Perjanjian Kinerja">Perjanjian Kinerja</option>
                            <option value="Laporan Hasil Evaluasi">Laporan Hasil Evaluasi</option>
                            <option value="Cascading Kinerja">Cascading Kinerja</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="judul" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh: RPJPD Tahun 2025-2045" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select" id="tahun" name="tahun" required>
                            <option value="">Pilih Tahun</option>
                            @for($i = date('Y') + 1; $i >= 2018; $i--)
                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">File Dokumen <span class="text-danger">*</span></label>
                        <div class="upload-area" id="uploadArea">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3 d-block"></i>
                            <p class="mb-1 fw-bold">Klik untuk memilih file atau drag & drop</p>
                            <small class="text-muted">Format: PDF, DOC, DOCX, XLS, XLSX (Max 10MB)</small>
                            <input type="file" class="form-control d-none" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Dokumen yang diupload akan menunggu verifikasi dari administrator sebelum ditampilkan.
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="/client/dokumen/perencanaan-pemkab" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i> Upload Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('file');
        if(uploadArea && fileInput) {
            uploadArea.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', (e) => {
                if(e.target.files.length > 0) {
                    const file = e.target.files[0];
                    uploadArea.innerHTML = '<i class="fas fa-file-check fa-3x text-success mb-3 d-block"></i><p class="mb-0 text-success fw-bold">' + file.name + '</p>';
                }
            });
        }
    </script>
</body>
</html>


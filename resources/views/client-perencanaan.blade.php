 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perencanaan - Client eSAKIP</title>
    
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
        .upload-area { border: 2px dashed #dee2e6; border-radius: 10px; padding: 40px; text-align: center; background: #fafafa; transition: all 0.3s ease; cursor: pointer; }
        .upload-area:hover { border-color: #0b4973; background: #f0f7ff; }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-building me-2"></i> eSAKIP OPD
            </div>
            <div class="sidebar-user mb-2">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle fa-2x me-3 text-light opacity-75"></i>
                    <div>
                        <small class="d-block" style="color: #ffc107; font-size: 0.75rem;">Selamat datang,</small>
                        <strong class="text-white">{{ Auth::user()->nama_lengkap ?? 'OPD' }}</strong>
                        <small class="d-block text-light opacity-75">{{ $nama_satker ?? '' }}</small>
                    </div>
                </div>
            </div>

            <div class="sidebar-menu">
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
                    <i class="fas fa-folder-open me-2 text-primary"></i> Dokumen Perencanaan - {{ $nama_satker ?? 'OPD' }}
                </h4>
                <div>
                    <a href="/dashboard-client" class="btn btn-secondary btn-sm">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpload">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </div>

            <!-- Documents Table -->
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
                                
                                @foreach($dokumenList as $index => $judul)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="text-start">{{ $judul }}</td>
                                    <td>-</td>
                                    <td>
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> Belum Upload</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary" title="Belum Upload" disabled>
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">-</span>
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

    <!-- Modal Upload -->
    <div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #0b4973 0%, #17a2b8 100%); color: white; padding: 20px 25px;">
                    <h5 class="modal-title fw-bold" id="modalUploadLabel">
                        <i class="fas fa-file-upload me-2"></i> Upload Dokumen Perencanaan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('client.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="padding: 25px;">
                        <div class="mb-4">
                            <label for="judul" class="form-label fw-bold" style="color: #333; font-size: 0.95rem;">
                                <i class="fas fa-tag me-1 text-primary"></i> Judul Dokumen <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" id="judul" name="judul" required style="border-radius: 8px; border: 2px solid #dee2e6;">
                                <option value="">Pilih Judul Dokumen</option>
                                @foreach($dokumenList as $doc)
                                <option value="{{ $doc }}">{{ $doc }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="tahun" class="form-label fw-bold" style="color: #333; font-size: 0.95rem;">
                                <i class="fas fa-calendar me-1 text-primary"></i> Tahun <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" id="tahun" name="tahun" required style="border-radius: 8px; border: 2px solid #dee2e6;">
                                <option value="">Pilih Tahun</option>
                                @for($i = date('Y') + 1; $i >= 2018; $i--)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #333; font-size: 0.95rem;">
                                <i class="fas fa-file-alt me-1 text-primary"></i> File Dokumen <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" id="uploadArea" style="border-radius: 12px; padding: 40px 20px;">
                                <i class="fas fa-cloud-upload-alt fa-4x text-muted mb-3 d-block"></i>
                                <p class="mb-2 fw-bold" style="color: #666;">Klik untuk memilih file atau drag & drop</p>
                                <small class="text-muted d-block mb-2">Format: PDF, DOC, DOCX, XLS, XLSX (Max 10MB)</small>
                                <input type="file" class="form-control d-none" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                            </div>
                        </div>
                        
                        <div class="alert alert-info d-flex align-items-center mb-0" style="border-radius: 8px; background: #e8f4fc; border: none;">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            <span style="color: #333;">Dokumen yang diupload akan menunggu verifikasi dari administrator sebelum ditampilkan.</span>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 15px 25px; background: #f8f9fa;">
                        <button type="button" class="btn btn-secondary btn-lg px-4" data-bs-dismiss="modal" style="border-radius: 8px;">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg px-4" style="border-radius: 8px; background: linear-gradient(135deg, #0b4973 0%, #17a2b8 100%); border: none;">
                            <i class="fas fa-upload me-1"></i> Upload Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Upload area click handler
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
            
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                if(e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    const file = e.dataTransfer.files[0];
                    uploadArea.innerHTML = '<i class="fas fa-file-check fa-3x text-success mb-3 d-block"></i><p class="mb-0 text-success fw-bold">' + file.name + '</p>';
                }
            });
        }
    </script>
</body>
</html>


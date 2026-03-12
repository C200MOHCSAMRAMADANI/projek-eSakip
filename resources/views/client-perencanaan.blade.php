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

        /* Table Styles - Sama dengan Admin */
        .table-custom th { 
            background-color: #0b4973; 
            color: white; 
            text-align: center;
            vertical-align: middle;
        }
        .table-custom td { 
            vertical-align: middle; 
            text-align: center;
        }
        
        /* Upload Area */
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            background: #fafafa;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            border-color: var(--primary-blue);
            background: #f0f7ff;
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
            
            <!-- Alerts -->
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

            <!-- Header -->
            <div class="admin-header-title d-flex justify-content-between align-items-center">
                <h4 class="m-0 text-uppercase fw-bold" style="font-size: 1.1rem; color: #333;">
                    <i class="fas fa-folder-open me-2 text-primary"></i> Dokumen Perencanaan
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
                                    <th width="12%">Status</th>
                                    <th width="12%">Verifikasi</th>
                                    <th width="15%">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumen_perencanaan as $index => $dok)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-start">
                                        <i class="fas fa-file-pdf me-2 text-danger"></i>
                                        <strong>{{ $dok->judul }}</strong>
                                        @if($dok->nama_file)
                                        <br><small class="text-muted">{{ $dok->nama_file }}</small>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-primary">{{ $dok->tahun }}</span>
                                    </td>
                                    
                                    <td>{{ $dok->created_at ? \Carbon\Carbon::parse($dok->created_at)->format('d-m-Y') : '-' }}</td>
                                    
                                    <td>
                                        @if($dok->status == 1)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($dok->verifikasi == 1)
                                            <span class="badge bg-info text-dark">
                                                <i class="fas fa-check-circle"></i> Terverifikasi
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock"></i> Menunggu
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($dok->nama_file)
                                        <a href="{{ asset('uploads/' . $dok->nama_file) }}" class="btn btn-sm btn-outline-success" target="_blank" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @endif
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteDokumen({{ $dok->id_file_sakip }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-minus fa-4x mb-3 opacity-25 d-block"></i>
                                        <p class="mb-0">Belum ada dokumen.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Upload -->
    <div class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--primary-blue); color: white;">
                    <h5 class="modal-title" id="modalUploadLabel">
                        <i class="fas fa-upload me-2"></i> Upload Dokumen Perencanaan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('client.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh: Rencana Strategis 2024-2028" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tahun" class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                            <select class="form-select" id="tahun" name="tahun" required>
                                <option value="">Pilih Tahun</option>
                                @for($i = date('Y') + 1; $i >= 2018; $i--)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">File Dokumen <span class="text-danger">*</span></label>
                            <div class="upload-area" id="uploadArea">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3 d-block"></i>
                                <p class="mb-1">Klik untuk memilih file atau drag & drop</p>
                                <small class="text-muted">Format: PDF, DOC, DOCX, XLS, XLSX (Max 10MB)</small>
                                <input type="file" class="form-control d-none" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Dokumen yang diupload akan menunggu verifikasi dari administrator sebelum ditampilkan di website.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i> Upload
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
                    uploadArea.innerHTML = `<i class="fas fa-file fa-2x text-success mb-2 d-block"></i>
                        <p class="mb-0 text-success fw-bold">${file.name}</p>
                        <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>`;
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
                    uploadArea.innerHTML = `<i class="fas fa-file fa-2x text-success mb-2 d-block"></i>
                        <p class="mb-0 text-success fw-bold">${file.name}</p>
                        <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>`;
                }
            });
        }
        
        // Delete document function
        function deleteDokumen(id) {
            if(confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                fetch('{{ route("client.delete") }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Dokumen berhasil dihapus');
                        location.reload();
                    } else {
                        alert('Gagal menghapus dokumen: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan: ' + error);
                });
            }
        }
    </script>
</body>
</html>


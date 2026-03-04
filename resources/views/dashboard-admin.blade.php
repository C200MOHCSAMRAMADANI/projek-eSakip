@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    
    <div class="admin-header-title mb-4">
        <h3 class="fw-bold mb-0 me-3" style="color: var(--primary-blue);">Dashboard SAKIP</h3>
        <span class="text-muted border-start ps-3">Ringkasan Kinerja & Dokumen SAKIP</span>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: var(--primary-blue); border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="card-text mb-1 opacity-75">File Tahun Ini</p>
                        <h2 class="display-5 fw-bold mb-0">{{ $fileTahunIni ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-file-upload fa-3x opacity-50"></i>
                </div>
                <a href="#" class="card-footer bg-dark bg-opacity-10 border-0 text-center text-white text-decoration-none py-2" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <small>Lihat Detail <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </a>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: var(--sakip-teal); border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="card-text mb-1 opacity-75">File Tahun Sebelumnya</p>
                        <h2 class="display-5 fw-bold mb-0">{{ $fileTahunLalu ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-history fa-3x opacity-50"></i>
                </div>
                <a href="#" class="card-footer bg-dark bg-opacity-10 border-0 text-center text-white text-decoration-none py-2" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <small>Lihat Riwayat <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </a>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card h-100" style="background-color: var(--primary-yellow); color: #333; border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="card-text mb-1 fw-bold opacity-75">Total OPD Aktif</p>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalOPD ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-building fa-3x opacity-50"></i>
                </div>
                <a href="#" class="card-footer bg-dark bg-opacity-10 border-0 text-center text-dark text-decoration-none py-2" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <small class="fw-bold">Kelola OPD <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </a>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white h-100" style="background-color: #ff3b30; border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="card-text mb-1 opacity-75">OPD Belum Upload</p>
                        <h2 class="display-5 fw-bold mb-0">{{ $opdBelumUpload ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                </div>
                <a href="#" class="card-footer bg-dark bg-opacity-10 border-0 text-center text-white text-decoration-none py-2" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <small>Lihat Data <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- FILE: resources/views/pages/pengukuran.blade.php -->
<div class="container mt-5 mb-5">
    <!-- HEADER HALAMAN -->
    <!-- Menggunakan class .page-header-bar dari style.css (Border Left Teal) -->
    <div class="page-header-bar">
        <i class="fas fa-chart-line me-2"></i> Pengukuran Kinerja
    </div>

     <!-- Filter Tahun (Dipindah ke sini agar jelas) -->
    <div class="d-flex flex-wrap align-items-center gap-3 mb-4 bg-light p-3 rounded border">
    
    <div class="d-flex align-items-center gap-2">
        <label class="fw-bold text-nowrap" style="color: var(--primary-blue);">Filter Tahun:</label>
        <select id="filter-tahun-pengukuran" class="form-select border-0 bg-white shadow-sm fw-bold" style="width: auto; min-width: 110px; color: var(--primary-blue);">
            <option value="all">Semua Tahun</option>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>

    <div class="d-none d-md-block border-start mx-2" style="height: 25px; border-color: #ccc;"></div>

    <div class="d-flex align-items-center gap-2">
        <label class="fw-bold text-nowrap" style="color: var(--primary-blue);">Triwulan:</label>
        <select id="filter-triwulan-pengukuran" class="form-select border-0 bg-white shadow-sm fw-bold" style="width: auto; min-width: 150px; color: var(--primary-blue);">
            <option value="all">Semua Triwulan</option>
            @foreach($triwulan as $tw)
                <option value="{{ $tw }}">{{ $tw }}</option>
            @endforeach
        </select>
    </div>

</div>
            

    <!-- BAGIAN 1: IKU KABUPATEN -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4" style="color: var(--primary-blue);">
                Pengukuran Kinerja IKU Kabupaten
            </h5>
            <div class="row">
                <div class="col-lg-7">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="50">NO</th>
                                    <th>INDIKATOR KINERJA UTAMA</th>
                                    <th>TARGET</th>
                                    <th>REALISASI</th>
                                    <th>CAPAIAN</th>
                                </tr>
                            </thead>
                            <tbody id="iku-kabupaten-body">
                                <!-- Data dimuat via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body d-flex align-items-center justify-content-center position-relative">
                            <canvas id="ikuChart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 2: IKU PERANGKAT DAERAH -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4" style="color: var(--primary-blue);">
                Pengukuran Kinerja IKU Perangkat Daerah
            </h5>
            

            <!-- Fitur: Show Entries & Search -->
            <div class="row mb-3">
                <div class="col-md-6 d-flex align-items-center gap-2 mb-2 mb-md-0">
                    <span>Show</span>
                    <select id="show-entries-iku-pd" class="form-select form-select-sm" style="width: 80px;">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2">
                    <span>Search:</span>
                    <input type="text" id="search-iku-pd" class="form-control form-control-sm" style="width: 200px;" placeholder="Cari Perangkat Daerah...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="50">NO</th>
                            <th>PERANGKAT DAERAH</th>
                            <th width="180">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="table-iku-pd-body">
                        @foreach($pd_list as $index => $pd)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $pd }}</td>
                            <td class="text-center">
                                <!-- Tombol Biru Tua -->
                                <button class="btn btn-sm text-white rounded-pill px-3 btn-lihat-data" style="background-color: var(--primary-blue);" onclick="viewPengukuranDetail('{{ $pd }}')">
                                    <i class="fas fa-eye me-1"></i> Lihat Data
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Info -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span id="pagination-info-iku-pd" class="small text-muted"></span>
                <nav>
                    <ul class="pagination pagination-sm mb-0" id="pagination-iku-pd"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- BAGIAN 3: KEUANGAN -->
     
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4" style="color: var(--primary-blue);">
        Pengukuran Kinerja Keuangan Perangkat Daerah
            </h5>
        <div class="card-body p-4">
            <!-- Fitur: Show Entries & Search (Keuangan) -->
            <div class="row mb-3">
                <div class="col-md-6 d-flex align-items-center gap-2 mb-2 mb-md-0">
                    <span>Show</span>
                    <select id="show-entries-keuangan" class="form-select form-select-sm" style="width: 80px;">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2">
                    <span>Search:</span>
                    <input type="text" id="search-keuangan" class="form-control form-control-sm" style="width: 200px;" placeholder="Cari Perangkat Daerah...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th width="50" rowspan="2">NO</th>
                            <th rowspan="2">PERANGKAT DAERAH</th>
                            <th colspan="2">CAPAIAN (%)</th>
                        </tr>
                        <tr>
                            <th>KEUANGAN</th>
                            <th>FISIK</th>
                        </tr>
                    </thead>
                    <tbody id="table-keuangan-body">
                        @foreach($pd_list as $index => $pd)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $pd }}</td>
                            <td class="text-center fw-bold text-success">{{ rand(85, 99) }}.{{ rand(1,9) }}%</td>
                            <td class="text-center fw-bold" style="color: var(--primary-blue);">{{ rand(85, 99) }}.{{ rand(1,9) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Info (Keuangan) -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span id="pagination-info-keuangan" class="small text-muted"></span>
                <nav>
                    <ul class="pagination pagination-sm mb-0" id="pagination-keuangan"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pengukuran -->
    <div class="modal fade" id="pengukuranDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="pengukuranDetailTitle">Detail Pengukuran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="50">NO</th>
                                    <th>SASARAN</th>
                                    <th>INDIKATOR</th>
                                    <th width="100">TARGET</th>
                                    <th width="100">REALISASI</th>
                                    <th width="120">PRESENTASE</th>
                                </tr>
                            </thead>
                            <tbody id="pengukuran-detail-body">
                                <!-- Data dimuat via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
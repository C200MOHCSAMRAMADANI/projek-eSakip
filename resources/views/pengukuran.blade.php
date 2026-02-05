<!-- FILE: resources/views/pages/pengukuran.blade.php -->
<div class="container mt-5 mb-5">
    <!-- HEADER HALAMAN -->
    <!-- Menggunakan class .page-header-bar dari style.css (Border Left Teal) -->
    <div class="page-header-bar">
        <i class="fas fa-chart-line me-2"></i> Pengukuran Kinerja
    </div>

    <!-- BAGIAN 1: IKU KABUPATEN -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-4" style="color: var(--primary-blue);">
                Pengukuran Kinerja IKU Kabupaten
            </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="50">NO</th>
                            <th>PERANGKAT DAERAH</th>
                            <th>TARGET</th>
                            <th>REALISASI</th>
                            <th>CAPAIAN (%)</th>
                            <th width="250">GRAFIK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dummy Data -->
                        <tr>
                            <td class="text-center">1</td>
                            <td>Pemerintah Kabupaten</td>
                            <td class="text-center">100</td>
                            <td class="text-center">96.5</td>
                            <td class="text-center fw-bold">96.5%</td>
                            <td class="px-3">
                                <!-- Progress Bar Sederhana (Background Biru Tua) -->
                                <div class="progress" style="height: 20px; background-color: #e9ecef;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: 96.5%; background-color: var(--primary-blue);" 
                                         aria-valuenow="96.5" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                    <select class="form-select form-select-sm" style="width: 80px;">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2">
                    <span>Search:</span>
                    <input type="text" class="form-control form-control-sm" style="width: 200px;" placeholder="Cari Perangkat Daerah...">
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
                    <tbody>
                        @php
                            $list_pd = ['Sekretariat Daerah', 'Inspektorat Daerah', 'Dinas Pendidikan', 'Dinas Kesehatan', 'Bappeda'];
                        @endphp
                        @foreach($list_pd as $index => $pd)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $pd }}</td>
                            <td class="text-center">
                                <!-- Tombol Biru Tua -->
                                <button class="btn btn-sm text-white rounded-pill px-3" style="background-color: var(--primary-blue);">
                                    <i class="fas fa-eye me-1"></i> Lihat Data 2026
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- BAGIAN 3: KEUANGAN -->
    
    <!-- Filter Khusus (Tengah) -->
    <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-2 bg-white p-2 rounded shadow-sm">
            <label class="fw-bold ps-2" style="color: var(--primary-blue);">Filter Tahun:</label>
            <select class="form-select border-0 bg-light fw-bold" style="width: 100px; color: var(--primary-blue);">
                <option selected>2026</option>
                <option>2025</option>
            </select>
        </div>
        <div class="d-flex align-items-center gap-2 bg-white p-2 rounded shadow-sm">
            <label class="fw-bold ps-2" style="color: var(--primary-blue);">Triwulan:</label>
            <select class="form-select border-0 bg-light fw-bold" style="width: 150px; color: var(--primary-blue);">
                <option selected>Triwulan 1</option>
                <option>Triwulan 2</option>
                <option>Triwulan 3</option>
                <option>Triwulan 4</option>
            </select>
        </div>
    </div>

    <!-- Header Bar Khusus Keuangan -->
    <div class="page-header-bar bg-white border-0 shadow-sm mb-0" style="border-left: 6px solid var(--primary-yellow);">
        <i class="fas fa-money-bill-wave me-2 text-success"></i> Pengukuran Kinerja Keuangan Perangkat Daerah Tahun 2026
    </div>

    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-4">
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
                    <tbody>
                        @foreach($list_pd as $index => $pd)
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
        </div>
    </div>
</div>
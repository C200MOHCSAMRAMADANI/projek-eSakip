<div class="container mt-4 mb-5">
    
    <!-- 1. Header Judul Utama -->
    <div class="page-header-bar mb-4 shadow-sm">
        <i class="fas fa-sliders-h fa-lg"></i> 
        <span id="main-page-title" class="ms-2 text-uppercase">Perencanaan Kinerja - RENSTRA</span>
    </div>

    <!-- Filter Tahun (Centered) -->
    <div class="d-flex justify-content-center mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-center bg-white p-2 rounded shadow-sm border">
            <label class="me-2 fw-bold text-secondary">Filter Tahun :</label>
            <select id="filter-tahun" class="form-select form-select-sm w-auto border-secondary fw-bold text-center" style="min-width: 100px;">
                @for ($i = 2026; $i >= 2018; $i--)
                    <option value="{{ $i }}" {{ $i == 2026 ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Tabel 1: Dokumen Kabupaten (Dipindah ke atas, Full Width) -->
    <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold m-0 text-secondary"><i class="fas fa-file-alt me-2"></i> DOKUMEN SAKIP KABUPATEN TAHUN <span id="label-tahun-dokumen">2026</span></h6>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead class="table-light">
                    <tr><th width="5%" class="text-center">NO</th><th>JENIS DOKUMEN</th></tr>
                </thead>
                <tbody id="dokumen-table-body">
                    <!-- Data akan dimuat via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <!-- 2. Sidebar (Kiri) -->
        <div class="col-md-3 mb-4">
            <div class="list-group sidebar-custom shadow-sm">
                <a href="javascript:void(0)" class="list-group-item list-group-item-action active" onclick="updateContent(this, 'Rencana Strategis', 'RENSTRA')">
                    Rencana Strategis <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'Rencana Kerja', 'RENJA')">
                    Rencana Kerja <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'Rencana Aksi', 'REN-AKSI')">
                    Rencana Aksi <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'SK IKU', 'SK-IKU')">
                    SK-IKU <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'IK Program', 'IK-PROGRAM')">
                    IK Program <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'Perjanjian Kinerja', 'PK')">
                    Perjanjian Kinerja <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'Cascading Kegiatan', 'CASCADING')">
                    Cascading Kegiatan <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'Kerangka Acuan Kerja', 'KAK')">
                    Kerangka Acuan Kerja <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="updateContent(this, 'Pohon Kinerja', 'POHON')">
                    Pohon Kinerja <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
            </div>
        </div>

        <!-- 3. Konten Utama (Kanan) -->
        <div class="col-md-9">
            
            <!-- Tabel 2: Dokumen Perangkat Daerah -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold m-0 text-secondary"><i class="fas fa-folder-open me-2"></i> DOKUMEN SAKIP PERANGKAT DAERAH</h6>
                </div>
                <div class="card-body">
                    <!-- Controls -->
                    <div class="row mb-3 g-2">
                        <div class="col-md-6 d-flex align-items-center">
                            <small class="me-2">Show</small>
                            <select id="show-entries-pd" class="form-select form-select-sm w-auto"><option value="10">10</option><option value="25">25</option><option value="50">50</option></select>
                            <small class="ms-2">entries</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <label class="w-100 w-md-auto"><small class="d-md-inline d-block text-start mb-1 mb-md-0">Search:</small> <input id="search-pd" type="search" class="form-control form-control-sm d-inline-block w-auto w-100-mobile" placeholder="Cari Perangkat Daerah..."></label>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th width="5%">NO</th>
                                    <th class="text-start">NAMA PERANGKAT DAERAH</th>
                                    <th width="30%" id="dynamic-col-header" class="bg-warning-subtle">RENSTRA</th>
                                </tr>
                            </thead>
                            <tbody id="pd-table-body">
                                @if(isset($pd_list))
                                    @foreach($pd_list as $index => $pd)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $pd }}</td>
                                        <td class="text-center"><span class="badge bg-secondary">Belum Upload</span></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="3" class="text-center">Data Perangkat Daerah tidak ditemukan.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small id="pagination-info-pd" class="text-muted"></small>
                        <nav><ul id="pagination-pd" class="pagination pagination-sm mb-0"></ul></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview PDF -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfPreviewTitle">Pratinjau Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 pdf-modal-body">
                    <iframe id="pdfViewerFrame" src="" width="100%" height="100%" style="border:none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="btnDownloadPdf" class="btn btn-success" target="_blank" download><i class="fas fa-download me-1"></i> Unduh Dokumen</a>
                </div>
            </div>
        </div>
    </div>
</div>
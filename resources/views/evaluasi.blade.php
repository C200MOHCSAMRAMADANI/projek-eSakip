<div class="container mt-4 mb-5">
    <!-- Header Halaman -->
    <div class="page-header-bar mb-4 shadow-sm">
        <i class="fas fa-clipboard-check fa-lg"></i> 
        <span class="ms-2 text-uppercase">Evaluasi Kinerja</span>
    </div>

    <!-- Filter Tahun (Ditambahkan agar sesuai dengan fitur database) -->
    <div class="d-flex justify-content-center mb-4">
        <div class="d-flex align-items-center bg-white p-2 rounded shadow-sm border">
            <label class="me-2 fw-bold text-secondary">Filter Tahun :</label>
            <select id="filter-tahun-evaluasi" class="form-select form-select-sm w-auto border-secondary fw-bold text-center" style="min-width: 100px;">
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold m-0 text-secondary"><i class="fas fa-file-contract me-2"></i> HASIL EVALUASI SAKIP</h6>
        </div>
        <div class="card-body">
            <!-- Controls -->
            <div class="row mb-3 g-2">
                <div class="col-md-6 d-flex align-items-center">
                    <small class="me-2">Show</small>
                    <select id="show-entries-evaluasi" class="form-select form-select-sm w-auto"><option value="10">10</option><option value="25">25</option><option value="50">50</option></select>
                    <small class="ms-2">entries</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <label class="w-100 w-md-auto"><small class="d-md-inline d-block text-start mb-1 mb-md-0">Search:</small> <input id="search-evaluasi" type="search" class="form-control form-control-sm d-inline-block w-auto w-100-mobile" placeholder="Cari data..."></label>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">NO</th>
                            <th width="10%">TAHUN</th>
                            <th class="text-start">NAMA PERANGKAT D AERAH</th>
                            <th>JUDUL / FILE</th>
                            <th width="10%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="evaluasi-table-body">
                        <!-- Data akan dimuat otomatis dari database via JavaScript -->
                        <tr><td colspan="7" class="text-center py-4">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small id="pagination-info-evaluasi" class="text-muted"></small>
                <nav><ul id="pagination-evaluasi" class="pagination pagination-sm mb-0"></ul></nav>
            </div>
        </div>
    </div>

    <!-- Modal Preview PDF -->
    <!-- Modal ini wajib ada di setiap halaman yang menggunakan fitur viewPdf karena konten halaman dimuat secara dinamis (SPA) -->
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
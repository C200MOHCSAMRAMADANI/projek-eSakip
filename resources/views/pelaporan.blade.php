<div class="container mt-4 mb-5">
    
    <!-- 1. Header Judul Utama -->
    <!-- Menggunakan style .page-header-bar yang konsisten -->
    <div class="page-header-bar mb-4 shadow-sm">
        <i class="fas fa-file-contract fa-lg me-2"></i> 
        <span class="text-uppercase">Pelaporan Kinerja</span>
    </div>

    <!-- 2. Filter Tahun (Centered) -->
    <div class="d-flex justify-content-center mb-4">
        <div class="d-flex align-items-center bg-white p-2 rounded shadow-sm border">
            <label class="me-2 fw-bold text-secondary">Filter Tahun :</label>
            <select id="filter-tahun-pelaporan" class="form-select form-select-sm w-auto border-secondary fw-bold text-center" style="min-width: 100px;">
                <option selected>2026</option>
                <option>2025</option>
                <option>2024</option>
            </select>
        </div>
    </div>

    <!-- 3. Tabel Besar (Full Width) -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-4">
            
            <!-- Toolbar: Show Entries & Search -->
            <div class="row mb-3 g-2">
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start">
                    <small class="me-2">Show</small>
                    <select id="show-entries-pelaporan" class="form-select form-select-sm w-auto">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <small class="ms-2">entries</small>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end">
                    <label>
                        <small>Search:</small> 
                        <input id="search-pelaporan" type="search" class="form-control form-control-sm d-inline-block w-auto" placeholder="Cari Perangkat Daerah...">
                    </label>
                </div>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">NO</th>
                            <th class="text-start">PERANGKAT DAERAH</th>
                            <th width="15%">LKJP</th>
                        </tr>
                    </thead>
                    <tbody id="pelaporan-table-body">
                        @foreach($pd_list ?? [] as $index => $pd)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $pd }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info text-white rounded-pill px-3" onclick="viewPdf('{{ $pd }}', '{{ asset('files/DUMMY.pdf') }}')">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <small id="pagination-info-pelaporan" class="text-muted"></small>
                <nav>
                    <ul id="pagination-pelaporan" class="pagination pagination-sm mb-0"></ul>
                </nav>
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
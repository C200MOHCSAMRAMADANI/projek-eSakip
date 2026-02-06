<div class="container mt-4 mb-5">
    <!-- Header Halaman -->
    <div class="page-header-bar mb-4 shadow-sm">
        <i class="fas fa-clipboard-check fa-lg"></i> 
        <span class="ms-2 text-uppercase">Evaluasi Kinerja</span>
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
                    <select class="form-select form-select-sm w-auto"><option>10</option><option>25</option></select>
                    <small class="ms-2">entries</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <label class="w-100 w-md-auto"><small class="d-md-inline d-block text-start mb-1 mb-md-0">Search:</small> <input type="search" class="form-control form-control-sm d-inline-block w-auto w-100-mobile"></label>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">NO</th>
                            <th class="text-start">NAMA PERANGKAT DAERAH</th>
                            <th width="30%" class="bg-warning-subtle">LH TINDAK LANJUT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($pd_list) && count($pd_list) > 0)
                            @foreach($pd_list as $index => $pd)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $pd }}</td>
                                <td class="text-center">
                                    <!-- Tombol Lihat (Menggantikan Unduh & Salin Link) -->
                                    <button class="btn btn-sm btn-info text-white rounded-pill px-3" onclick="viewPdf('LHE {{ $pd }}', 'files/sample.pdf')">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td colspan="3" class="text-center">Data tidak tersedia.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Showing 1 to {{ isset($pd_list) ? count($pd_list) : 0 }} of {{ isset($pd_list) ? count($pd_list) : 0 }} entries</small>
                <nav><ul class="pagination pagination-sm mb-0"><li class="page-item disabled"><a class="page-link" href="#">Previous</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">Next</a></li></ul></nav>
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
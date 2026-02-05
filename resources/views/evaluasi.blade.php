<div class="container mt-4 mb-5">
    
    <!-- 1. Header Judul Utama -->
    <div class="page-header-bar mb-4 shadow-sm">
        <i class="fas fa-clipboard-check fa-lg me-2"></i> 
        <span class="text-uppercase">Evaluasi Kinerja</span>
    </div>

    <!-- 2. Filter Tahun (Centered) -->
    <div class="d-flex justify-content-center mb-4">
        <div class="d-flex align-items-center bg-white p-2 rounded shadow-sm border">
            <label class="me-2 fw-bold text-secondary">Filter Tahun :</label>
            <select class="form-select form-select-sm w-auto border-secondary fw-bold text-center" style="min-width: 100px;">
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
                    <select class="form-select form-select-sm w-auto">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <small class="ms-2">entries</small>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end">
                    <label>
                        <small>Search:</small> 
                        <input type="search" class="form-control form-control-sm d-inline-block w-auto" placeholder="Cari Perangkat Daerah...">
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
                            <th width="20%">LH TINDAK LANJUT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pd_list ?? [] as $index => $pd)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $pd }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger rounded-pill px-3">
                                    <i class="fas fa-file-pdf me-1"></i> Unduh
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <small class="text-muted">Showing 1 to {{ count($pd_list) }} of {{ count($pd_list) }} entries</small>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>
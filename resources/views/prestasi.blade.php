<div class="container mt-4 mb-5">
    
    <!-- 1. Header Judul Utama -->
    <div class="page-header-bar mb-4 shadow-sm">
        <i class="fas fa-trophy fa-lg me-2"></i> 
        <span class="text-uppercase">Prestasi Kinerja</span>
    </div>

    <div class="row">
        <!-- 2. Sidebar (Kiri) -->
        <div class="col-md-3 mb-4">
            <div class="list-group sidebar-custom shadow-sm">
                <a href="#" class="list-group-item list-group-item-action active">
                    Tingkat Nasional <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    Tingkat Provinsi <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    Tingkat Kabupaten <i class="fas fa-chevron-right float-end mt-1 small"></i>
                </a>
            </div>
        </div>

        <!-- 3. Konten Utama (Kanan) -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold m-0 text-secondary">
                        <i class="fas fa-medal me-2"></i> DAFTAR PRESTASI & PENGHARGAAN
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="5%">NO</th>
                                    <th class="text-start">PERANGKAT DAERAH</th>
                                    <th class="text-start">PRESTASI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prestasi_list ?? [] as $index => $p)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $p['pd'] }}</td>
                                    <td>{{ $p['ket'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4 mb-5">
    
    <!-- Header -->
    <div class="page-header-bar mb-4 shadow-sm">
        <i class="fas fa-images fa-lg me-2"></i> 
        <span class="text-uppercase">Galeri Infografis</span>
    </div>

    <!-- Grid Gallery -->
    <div class="row g-4">
        @foreach($items ?? [] as $item)
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-card">
                <!-- Placeholder Gambar -->
                <div class="bg-light d-flex align-items-center justify-content-center position-relative" style="height: 200px; background-color: #e9ecef;">
                    <i class="fas fa-chart-pie fa-4x text-secondary opacity-25"></i>
                    <span class="position-absolute top-0 end-0 m-2 badge bg-primary rounded-pill shadow-sm">Baru</span>
                </div>
                
                <div class="card-body">
                    <h6 class="card-title fw-bold text-dark mb-2">{{ $item['title'] }}</h6>
                    <p class="card-text small text-muted">{{ $item['desc'] }}</p>
                </div>
                
                <div class="card-footer bg-white border-0 pt-0 pb-3">
                    <div class="d-grid">
                        <button class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="fas fa-search-plus me-1"></i> Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

<style>
    .hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
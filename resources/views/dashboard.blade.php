<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 hero-text-wrapper">
                <h3 class="fw-bold mb-3">Transformasi Digital dan Pelayanan Publik Kabupaten Gunungkidul</h3>
                <p>Platform terpadu yang menyinergikan tata kelola pemerintahan cerdas, ekonomi, lingkungan, dan kehidupan sosial. Dirancang untuk meningkatkan kualitas hidup masyarakat Gunungkidul melalui optimalisasi teknologi dan potensi daerah.</p>
            </div>
            <div class="col-md-6 text-end">
                <img src="{{ asset('assets/gunungkidul.png') }}" alt="Gunungkidul" class="hero-img-custom">
            </div>
        </div>
    </div>
</div>

<div class="container dashboard-cards-overlap">
    <div class="row g-4 justify-content-center">
        
        <div class="col-md-3">
            <div class="card-menu">
                <div>
                    <i class="fas fa-university fa-3x mb-3 text-secondary"></i>
                    <p class="small text-muted">Dokumen perencanaan yang meliputi RPJMD, Renstra, dll.</p>
                </div>
                {{-- Catatan: Sesuaikan onclick ini dengan Route Laravel jika sudah tidak menggunakan SPA JS --}}
                <button class="btn-grey-custom" onclick="loadPage('perencanaan')">PERENCANAAN</button>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-menu">
                <div>
                    <i class="fas fa-file-signature fa-3x mb-3 text-primary"></i>
                    <p class="small text-muted">Dokumen yang memastikan kemajuan pencapaian target.</p>
                </div>
                <button class="btn-grey-custom" onclick="loadPage('pengukuran')">PENGUKURAN</button>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-menu">
                <div>
                    <i class="fas fa-file-alt fa-3x mb-3 text-warning"></i>
                    <p class="small text-muted">Laporan pencapaian kinerja Pemerintah Daerah.</p>
                </div>
                <button class="btn-grey-custom" onclick="loadPage('pelaporan')">PELAPORAN</button>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-menu">
                <div>
                    <i class="fas fa-clipboard-check fa-3x mb-3 text-info"></i>
                    <p class="small text-muted">Laporan hasil evaluasi kinerja.</p>
                </div>
                <button class="btn-grey-custom" onclick="loadPage('evaluasi')">EVALUASI</button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-3">
             <div class="card-menu">
                <div>
                    <i class="fas fa-trophy text-warning mb-3 fa-3x"></i>
                    <p class="small text-muted">Berbagai penghargaan dan capaian kinerja membanggakan yang telah diraih.</p>
                </div>
                <button class="btn-grey-custom" onclick="loadPage('prestasi')">PRESTASI</button>
             </div>
        </div>
    </div>
    
</div> 

<div class="priority-section">
    <div class="container text-center">
        
        <h4 class="fw-bold mb-3">PRIORITAS PEMBANGUNAN</h4>
        <hr class="priority-divider">
        <p class="mb-5">Berikut ini merupakan prioritas pembangunan berdasarkan RB tematik agar kinerja Pemerintah lebih berdampak langsung kepada masyarakat.</p>
        
        <div class="row justify-content-center g-4">
            <div class="col-6 col-md-3">
                <div class="p-3 border-0 rounded-4 bg-white shadow-sm h-100">
                    <i class="fas fa-users fa-3x mb-3 text-dark"></i>
                    <h6 class="fw-bold m-0 text-uppercase text-dark">KEMISKINAN</h6>
                </div>
            </div>
            <div class="col-6 col-md-3">
                 <div class="p-3 border-0 rounded-4 bg-white shadow-sm h-100">
                    <i class="fas fa-chart-pie fa-3x mb-3 text-warning"></i>
                    <h6 class="fw-bold m-0 text-uppercase text-dark">INVESTASI</h6>
                </div>
            </div>
            <div class="col-6 col-md-3">
                 <div class="p-3 border-0 rounded-4 bg-white shadow-sm h-100">
                    <i class="fas fa-mobile-alt fa-3x mb-3 text-primary"></i>
                    <h6 class="fw-bold m-0 text-uppercase text-dark">DIGITALISASI</h6>
                </div>
            </div>
            <div class="col-6 col-md-3">
                 <div class="p-3 border-0 rounded-4 bg-white shadow-sm h-100">
                    <i class="fas fa-chart-line fa-3x mb-3 text-success"></i>
                    <h6 class="fw-bold m-0 text-uppercase text-dark">PDN</h6>
                </div>
            </div>
        </div>
    </div>
</div>
/* public/js/app-spa.js */

// Template HTML untuk setiap halaman
const pages = {
    dashboard: `
        <div class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 hero-text-wrapper">
                        <h3 class="fw-bold mb-3">Transformasi Digital dan Pelayanan Publik Kabupaten Gunungkidul</h3>
                        <p>Platform terpadu yang menyinergikan tata kelola pemerintahan cerdas, ekonomi, lingkungan, dan kehidupan sosial. Dirancang untuk meningkatkan kualitas hidup masyarakat Gunungkidul melalui optimalisasi teknologi dan potensi daerah.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <img src="/assets/gunungkidul.png" alt="Gunungkidul" class="hero-img-custom">
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
    `,
    perencanaan: `
        <div class="container mt-5 mb-5">
            <div class="page-header-bar">
                <i class="fas fa-sliders-h"></i> Perencanaan Kinerja - RENSTRA
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group sidebar-list">
                        <a href="#" class="list-group-item list-group-item-action active">Rencana Strategis <i class="fas fa-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action">Rencana Kerja <i class="fas fa-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action">Rencana Aksi <i class="fas fa-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action">Perjanjian Kinerja <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="page-header-bar py-2 bg-light border-0">
                        <i class="fas fa-sliders-h"></i> Dokumen Sakip Kabupaten Tahun 2026
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="table-light fw-bold">
                            <tr><th width="50">NO</th><th>JENIS DOKUMEN</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td class="d-flex justify-content-between">Dokumen Renstra Bappeda <i class="fas fa-download"></i></td></tr>
                            <tr><td>2</td><td class="d-flex justify-content-between">Dokumen Renstra Dinas Kesehatan <i class="fas fa-download"></i></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,
    pengukuran: `
        <div class="container mt-5">
            <div class="page-header-bar">
                <i class="fas fa-sliders-h"></i> Pengukuran Kinerja
            </div>
            <div class="card p-4 border-0 shadow-sm">
                <h5 class="mb-3">Pengukuran Kinerja IKU Perangkat Daerah</h5>
                <table class="table table-bordered table-striped">
                    <thead><tr><th>NO</th><th>PERANGKAT DAERAH</th><th class="text-center">AKSI</th></tr></thead>
                    <tbody>
                        <tr><td>1</td><td>Sekretariat Daerah</td><td class="text-center"><button class="btn btn-primary btn-sm">Lihat Data 2026</button></td></tr>
                        <tr><td>2</td><td>Dinas Kominfo</td><td class="text-center"><button class="btn btn-primary btn-sm">Lihat Data 2026</button></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    `,
    pelaporan: `
        <div class="container mt-5">
            <div class="page-header-bar">
                <i class="fas fa-sliders-h"></i> Pelaporan Kinerja
            </div>
             <table class="table table-bordered table-striped bg-white">
                <thead><tr><th>NO</th><th>PERANGKAT DAERAH</th><th>LKJP</th></tr></thead>
                <tbody>
                    <tr><td>1</td><td>Sekretariat Daerah</td><td></td></tr>
                    <tr><td>2</td><td>Dinas Pendidikan</td><td></td></tr>
                </tbody>
            </table>
        </div>
    `,
    evaluasi: `
        <div class="container mt-5">
            <div class="page-header-bar">
                <i class="fas fa-sliders-h"></i> Evaluasi Kinerja Tahun 2026
            </div>
            <table class="table table-bordered bg-white">
                <thead><tr><th>NO</th><th>PERANGKAT DAERAH</th><th>LH TINDAK LANJUT</th></tr></thead>
                <tbody>
                    <tr><td>1</td><td>Inspektorat Daerah</td><td></td></tr>
                </tbody>
            </table>
        </div>
    `,
    prestasi: `
        <div class="container mt-5 mb-5">
            <div class="page-header-bar">
                <i class="fas fa-sliders-h"></i> Prestasi Kinerja
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group sidebar-list">
                        <a href="#" class="list-group-item list-group-item-action active">Tingkat Nasional <i class="fas fa-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action">Tingkat Provinsi <i class="fas fa-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action">Tingkat Kabupaten <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="page-header-bar py-2 bg-light border-0">
                        <i class="fas fa-sliders-h"></i> Daftar Prestasi & Penghargaan
                    </div>
                    <table class="table table-bordered table-striped bg-white">
                        <thead class="table-light fw-bold">
                            <tr><th width="50">NO</th><th>PERANGKAT DAERAH</th><th>PRESTASI</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Bappeda</td><td>Juara 1 SAKIP Award</td></tr>
                            <tr><td>2</td><td>Dinas Kominfo</td><td>Terbaik Implementasi SPBE</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `,
    infografis: `
        <div class="container mt-5">
            <div class="page-header-bar"><i class="fas fa-sliders-h"></i> Gallery : Test</div>
            <div class="alert alert-danger text-center text-white alert-custom-red">Maaf, Tidak Ada Foto Pada Album Ini !</div>
        </div>
    `,
    kontak: `
        <div class="container mt-5">
            <div class="page-header-bar"><i class="fas fa-sliders-h"></i> Kontak</div>
            <div class="bg-white p-5 rounded shadow-sm">
                <h5>LAYANAN INFORMASI, KONSULTASI DAN PENGADUAN</h5>
                <hr>
                <p class="fw-bold mt-4">BAGIAN ORGANISASI SEKRETARIAT DAERAH</p>
                <p><i class="fab fa-whatsapp text-success fa-lg me-2"></i> WhatsApp : +62 878 3936 5687</p>
                <p><i class="fas fa-envelope text-danger fa-lg me-2"></i> Email : subkrokskinerja@gmail.com</p>
            </div>
        </div>
    `
};

function loadPage(pageName) {
    const contentDiv = document.getElementById('main-content');
    contentDiv.innerHTML = '<div class="text-center mt-5"><div class="spinner-border text-primary" role="status"></div></div>';
    
    // Simulasi delay agar terasa seperti loading
    setTimeout(() => {
        if (pages[pageName]) {
            contentDiv.innerHTML = pages[pageName];
        } else {
            contentDiv.innerHTML = '<h2 class="text-center mt-5">404 Halaman Tidak Ditemukan</h2>';
        }
    }, 200);
}

// Load Dashboard saat pertama kali dibuka
document.addEventListener("DOMContentLoaded", function() {
    loadPage('dashboard');
});
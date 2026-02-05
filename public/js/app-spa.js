/* public/js/app-spa.js */

// Template HTML untuk setiap halaman
const pages = {
    // Hapus konten dashboard dan perencanaan yang sudah dipindah ke Blade
    // agar sistem memaksa load dari server.
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
                <p><i class="fas fa-map-marker-alt text-primary fa-lg me-2"></i> Alamat : <a href="https://maps.app.goo.gl/dLxyUWFGbjjeYXTF6" target="_blank" class="text-decoration-none text-primary">Jl. Brigjen Katamso No. 1, Wonosari, Gunungkidul</a></p>
                <p><i class="fab fa-whatsapp text-success fa-lg me-2"></i> WhatsApp : <a href="https://wa.me/6287839365687?text=Halo%2C%20saya%20ingin%20konsultasi%20terkait%20SAKIP" target="_blank" class="text-decoration-none text-primary">+62 878 3936 5687</a></p>
                <p><i class="fas fa-envelope text-danger fa-lg me-2"></i> Email : <a href="mailto:subkrokskinerja@gmail.com" class="text-decoration-none text-primary">subkrokskinerja@gmail.com</a></p>
            </div>
        </div>
    `
};

// Fungsi global untuk interaksi Sidebar (dipindahkan dari Blade)
window.updateContent = function(element, title, colHeader) {
    // 1. Hapus class active dari semua item sidebar
    document.querySelectorAll('.sidebar-custom .list-group-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // 2. Tambahkan class active ke elemen yang diklik
    element.classList.add('active');
    
    // 3. Update Judul Header Utama
    const mainTitle = document.getElementById('main-page-title');
    if(mainTitle) mainTitle.innerText = 'Perencanaan Kinerja - ' + title.toUpperCase();
    
    // 4. Update Header Kolom Tabel
    const colHeaderEl = document.getElementById('dynamic-col-header');
    if(colHeaderEl) colHeaderEl.innerText = colHeader;
}

// Fungsi inisialisasi khusus halaman Perencanaan
window.initPerencanaan = function() {
    const filter = document.getElementById('filter-tahun');
    const tbody = document.getElementById('dokumen-table-body');

    if (filter && tbody) {
        // Event Listener saat tahun berubah
        filter.addEventListener('change', function() {
            fetchDokumen(this.value);
        });

        // Load data awal (sesuai nilai default select, misal 2026)
        fetchDokumen(filter.value);
    }
}

// Fungsi Fetch Data API
window.fetchDokumen = function(tahun) {
    const tbody = document.getElementById('dokumen-table-body');
    tbody.innerHTML = '<tr><td colspan="2" class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...</td></tr>';

    fetch(`/api/dokumen-sakip?tahun=${tahun}`)
        .then(res => res.json())
        .then(response => {
            let rows = '';
            if(response.data && response.data.length > 0) {
                response.data.forEach(item => {
                    rows += `<tr><td class="text-center">${item.no}</td><td class="d-flex justify-content-between align-items-center"><span>${item.nama}</span><button class="btn btn-sm btn-download-custom rounded-pill px-3"><i class="fas fa-file-pdf me-1"></i> Unduh</button></td></tr>`;
                });
            } else {
                rows = '<tr><td colspan="2" class="text-center py-3">Tidak ada dokumen untuk tahun ini.</td></tr>';
            }
            tbody.innerHTML = rows;
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="2" class="text-center text-danger py-3">Gagal memuat data.</td></tr>';
        });
}

function loadPage(pageName) {
    const contentDiv = document.getElementById('main-content');
    contentDiv.innerHTML = '<div class="text-center mt-5"><div class="spinner-border text-primary" role="status"></div></div>';
    
    // Coba ambil konten dari server (Blade View)
    // Pastikan Route '/page/{page}' sudah dibuat di routes/web.php
    fetch(`/page/${pageName}`)
        .then(response => {
            if (!response.ok) throw new Error('Page not found on server');
            return response.text();
        })
        .then(html => {
            contentDiv.innerHTML = html;
            // Jalankan script inisialisasi jika halaman adalah perencanaan
            if (pageName === 'perencanaan') {
                initPerencanaan();
            }
        })
        .catch(error => {
            console.log("Fallback to static content:", error);
            // Fallback ke konten statis JS jika server gagal/404
            if (pages[pageName]) {
                contentDiv.innerHTML = pages[pageName];
            } else {
                contentDiv.innerHTML = '<h2 class="text-center mt-5">404 Halaman Tidak Ditemukan</h2>';
            }
        });
}

// Load Dashboard saat pertama kali dibuka
document.addEventListener("DOMContentLoaded", function() {
    loadPage('dashboard');
});
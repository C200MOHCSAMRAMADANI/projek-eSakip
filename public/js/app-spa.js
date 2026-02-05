/* public/js/app-spa.js */

// Template HTML untuk setiap halaman
const pages = {
    // Hapus konten dashboard dan perencanaan yang sudah dipindah ke Blade
    // agar sistem memaksa load dari server.
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

    fetch(`api/dokumen-sakip?tahun=${tahun}`)
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
    // 1. Cek Hash URL
    // Jika hash di URL berbeda dengan page yang diminta, update hashnya.
    // Ini akan memicu event 'hashchange' (di bawah) yang kemudian akan memanggil loadPage lagi.
    if (window.location.hash.substring(1) !== pageName) {
        window.location.hash = pageName;
        return; // Berhenti di sini, biarkan event listener hashchange yang memuat konten
    }

    const contentDiv = document.getElementById('main-content');
    contentDiv.innerHTML = '<div class="text-center mt-5"><div class="spinner-border text-primary" role="status"></div></div>';
    
    // Coba ambil konten dari server (Blade View)
    // Pastikan Route '/page/{page}' sudah dibuat di routes/web.php
    fetch(`page/${pageName}`)
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

// 2. Event Listener untuk Navigasi (Back/Forward Browser & Perubahan Hash)
window.addEventListener('hashchange', function() {
    const page = window.location.hash.substring(1);
    // Jika hash kosong, load dashboard, jika tidak load page sesuai hash
    loadPage(page || 'dashboard');
});

// 3. Load Halaman saat pertama kali dibuka (Reload)
document.addEventListener("DOMContentLoaded", function() {
    // FIX: Otomatis ubah link navbar yang pakai onclick="loadPage(...)" menjadi href="#..."
    // Ini mencegah konflik tombol kembali ke dashboard karena href="#"
    document.querySelectorAll('a[onclick*="loadPage"]').forEach(anchor => {
        const match = anchor.getAttribute('onclick').match(/loadPage\(['"]([^'"]+)['"]\)/);
        if (match && match[1]) {
            anchor.setAttribute('href', '#' + match[1]);
            anchor.removeAttribute('onclick');
        }
    });

    // Cek apakah ada hash di URL (misal #perencanaan)
    const page = window.location.hash.substring(1);
    // Jika ada hash load page tersebut, jika tidak load dashboard
    loadPage(page || 'dashboard');
});
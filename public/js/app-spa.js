/* public/js/app-spa.js */

// Variabel global untuk instance Chart.js
window.ikuChartInstance = null;
window.currentPdEvaluasi = 'all'; // State untuk menyimpan PD yang dipilih di halaman Evaluasi
window.currentPdPelaporan = 'all'; // State untuk menyimpan PD yang dipilih di halaman Pelaporan
window.currentPerencanaanTitle = 'Rencana Strategis'; // Default Title Perencanaan
window.currentUser = null; // State untuk menyimpan data user yang login

// Template HTML untuk setiap halaman
const pages = {
    // Hapus konten dashboard dan perencanaan yang sudah dipindah ke Blade
    // agar sistem memaksa load dari server.
};

// Fungsi untuk memeriksa status autentikasi
window.checkAuthStatus = function() {
    fetch('/api/auth-status')
        .then(res => res.json())
        .then(response => {
            if (response.authenticated) {
                window.currentUser = response.user;
                window.updateNavbarForAuthenticated(response.user);
            } else {
                window.currentUser = null;
                window.updateNavbarForGuest();
            }
        })
        .catch(err => {
            console.error('Error checking auth status:', err);
            window.updateNavbarForGuest();
        });
}

// Fungsi untuk update navbar jika user sudah login
window.updateNavbarForAuthenticated = function(user) {
    const navbarNav = document.querySelector('.navbar-nav');
    if (!navbarNav) return;

    // Cek apakah navbar sudah diupdate (untuk menghindari duplikasi)
    const existingUserMenu = navbarNav.querySelector('.user-menu');
    if (existingUserMenu) return;

    // Hapus tombol login jika ada
    const loginLink = navbarNav.querySelector('a[href="/login"]');
    if (loginLink) {
        const parentLi = loginLink.closest('li');
        if (parentLi) parentLi.remove();
    }

    // Buat dropdown menu untuk user
    const userMenuHtml = `
        <li class="nav-item dropdown user-menu">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-1"></i> ${user.nama_lengkap || user.username}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><span class="dropdown-item-text text-muted small">${user.level.charAt(0).toUpperCase() + user.level.slice(1)}</span></li>
                <li><hr class="dropdown-divider"></li>
                ${(user.level === 'admin' || user.level === 'moderator') ? '<li><a class="dropdown-item" href="/dashboard-admin"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</a></li><li><hr class="dropdown-divider"></li>' : ''}
                <li><a class="dropdown-item text-danger" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </li>
    `;

    navbarNav.insertAdjacentHTML('beforeend', userMenuHtml);
}

// Fungsi untuk update navbar jika user belum login
window.updateNavbarForGuest = function() {
    const navbarNav = document.querySelector('.navbar-nav');
    if (!navbarNav) return;

    // Cek apakah sudah ada tombol login
    const existingLoginLink = navbarNav.querySelector('a[href="/login"]');
    if (existingLoginLink) return;

    // Hapus user menu jika ada
    const existingUserMenu = navbarNav.querySelector('.user-menu');
    if (existingUserMenu) {
        existingUserMenu.remove();
    }

    // Tambahkan tombol login
    const loginHtml = `
        <li class="nav-item">
            <a class="nav-link" href="/login">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
        </li>
    `;

    navbarNav.insertAdjacentHTML('beforeend', loginHtml);
}

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
    const pageHash = window.location.hash.substring(1);

    if (pageHash === 'evaluasi') {
        if(mainTitle) mainTitle.innerText = 'Evaluasi Kinerja - ' + title.toUpperCase();
        window.currentPdEvaluasi = title;
        const year = document.getElementById('filter-tahun-evaluasi')?.value || 'all';
        fetchEvaluasiData(title, year);
    } else if (pageHash === 'pelaporan') {
        if(mainTitle) mainTitle.innerText = 'Pelaporan Kinerja - ' + title.toUpperCase();
        window.currentPdPelaporan = title;
        const year = document.getElementById('filter-tahun-pelaporan')?.value || 'all';
        fetchPelaporanData(title, year);
    } else {
        // Default (Perencanaan)
        if(mainTitle) mainTitle.innerText = 'Perencanaan Kinerja - ' + title.toUpperCase();
        
        // Simpan judul saat ini agar filter tahun tahu apa yang harus diambil
        window.currentPerencanaanTitle = title;
        const year = document.getElementById('filter-tahun')?.value || '2026';
        fetchDokumen(year, title);
    }
    
    // 4. Update Header Kolom Tabel
    const colHeaderEl = document.getElementById('dynamic-col-header');
    if(colHeaderEl) colHeaderEl.innerText = colHeader;
}

// Helper function Global untuk inisialisasi tabel dengan pagination & search
window.setupTablePagination = function(tableBodyId, searchInputId, lengthMenuId, paginationContainerId, paginationInfoId) {
    const searchInput = document.getElementById(searchInputId);
    const tableBody = document.getElementById(tableBodyId);
    const lengthMenu = document.getElementById(lengthMenuId);
    const paginationContainer = document.getElementById(paginationContainerId);
    const paginationInfo = document.getElementById(paginationInfoId);

    if (!tableBody) return;

    let currentPage = 1;
    let rowsPerPage = 10; // Default

    function renderTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const rows = Array.from(tableBody.getElementsByTagName('tr'));
        
        // 1. Filter Baris (Search)
        const visibleRows = rows.filter(row => {
            // Abaikan baris loading/kosong saat filter
            if (row.cells.length < 2) return true; 
            
            const rowText = row.innerText.toLowerCase();
            const matches = rowText.includes(searchTerm);
            if (!matches) row.style.display = 'none';
            return matches;
        });

        // 2. Hitung Pagination
        if (lengthMenu) rowsPerPage = parseInt(lengthMenu.value);
        const totalRows = visibleRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        if (currentPage > totalPages) currentPage = totalPages || 1;
        if (currentPage < 1) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // 3. Tampilkan Baris Sesuai Halaman
        visibleRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // 4. Update Teks Info
        if (paginationInfo) {
            const showStart = totalRows > 0 ? start + 1 : 0;
            const showEnd = end > totalRows ? totalRows : end;
            paginationInfo.innerText = `Showing ${showStart} to ${showEnd} of ${totalRows} entries`;
        }

        // 5. Render Tombol Pagination
        if (paginationContainer) {
            let html = '';
            html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a></li>`;
            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
            html += `<li class="page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`;
            paginationContainer.innerHTML = html;
        }
    }

    if (searchInput) searchInput.addEventListener('keyup', () => { currentPage = 1; renderTable(); });
    if (lengthMenu) lengthMenu.addEventListener('change', () => { currentPage = 1; renderTable(); });
    
    if (paginationContainer) {
        paginationContainer.addEventListener('click', (e) => {
            e.preventDefault();
            const link = e.target.closest('.page-link');
            if (link && !link.parentElement.classList.contains('disabled')) {
                currentPage = parseInt(link.getAttribute('data-page'));
                renderTable();
            }
        });
    }

    renderTable();
}

// Fungsi inisialisasi khusus halaman Perencanaan
window.initPerencanaan = function() {
    const filter = document.getElementById('filter-tahun');
    const tbody = document.getElementById('dokumen-table-body');

    if (filter && tbody) {
        // Event Listener saat tahun berubah
        filter.addEventListener('change', function() {
            // Gunakan judul yang sedang aktif (disimpan di global variable)
            const currentTitle = window.currentPerencanaanTitle || 'Rencana Strategis';
            fetchDokumen(this.value, currentTitle);
        });

        // Load data awal (sesuai nilai default select, misal 2026)
        fetchDokumen(filter.value, window.currentPerencanaanTitle);
    }

    // Aktifkan Pagination & Search Realtime untuk Tabel Perangkat Daerah
    window.setupTablePagination('pd-table-body', 'search-pd', 'show-entries-pd', 'pagination-pd', 'pagination-info-pd');
}

// Fungsi inisialisasi khusus halaman Pengukuran
window.initPengukuran = function() {
    const filter = document.getElementById('filter-tahun-pengukuran');
    const filterTw = document.getElementById('filter-triwulan-pengukuran');
    const btnReset = document.getElementById('btn-reset-filter');

    function updatePengukuran() {
        const year = filter ? filter.value : 'all';
        const tw = filterTw ? filterTw.value : 'all';
        
        if (filter) {
            const displayYear = year === 'all' ? 'Semua Tahun' : `Tahun ${year}`;
            document.querySelectorAll('.btn-lihat-data').forEach(btn => {
                btn.innerHTML = `<i class="fas fa-eye me-1"></i> Lihat Data ${displayYear}`;
            });

            // Update Judul Bagian Keuangan agar sesuai tahun yang dipilih
            const keuanganTitle = document.getElementById('keuangan-title');
            if (keuanganTitle) {
                keuanganTitle.innerText = `Pengukuran Kinerja Keuangan Perangkat Daerah ${displayYear}`;
            }
        }
        
        fetchPengukuranData(year, tw);
    }

    if (filter) filter.addEventListener('change', updatePengukuran);
    if (filterTw) filterTw.addEventListener('change', updatePengukuran);

    // Event Listener untuk Tombol Reset
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            if (filter) {
                // Reset ke tahun saat ini
                const currentYear = new Date().getFullYear().toString();
                // Cek apakah opsi tahun saat ini tersedia di dropdown
                let hasCurrentYear = Array.from(filter.options).some(opt => opt.value === currentYear);
                
                // Jika ada pilih tahun saat ini, jika tidak pilih opsi pertama (terbaru)
                filter.value = hasCurrentYear ? currentYear : filter.options[0].value;
            }
            if (filterTw) {
                filterTw.value = 'all'; // Reset triwulan ke 'Semua'
            }
            updatePengukuran(); // Muat ulang data
        });
    }
    
    // Trigger saat load agar data awal muncul
    if (filter) {
        // Trigger saat load agar teks tombol sesuai default filter
        updatePengukuran();
    }

    // Terapkan ke Tabel IKU PD
    window.setupTablePagination('table-iku-pd-body', 'search-iku-pd', 'show-entries-iku-pd', 'pagination-iku-pd', 'pagination-info-iku-pd');

    // Terapkan ke Tabel Keuangan
    window.setupTablePagination('table-keuangan-body', 'search-keuangan', 'show-entries-keuangan', 'pagination-keuangan', 'pagination-info-keuangan');
}

// Fungsi inisialisasi khusus halaman Evaluasi
window.initEvaluasi = function() {
    const filter = document.getElementById('filter-tahun-evaluasi');
    
    if (filter) {
        filter.addEventListener('change', function() {
            fetchEvaluasiData(window.currentPdEvaluasi, this.value);
        });

        // Load data awal
        window.currentPdEvaluasi = 'all'; // Reset pilihan PD
        fetchEvaluasiData('all', filter.value);

        // Aktifkan fitur Search & Pagination untuk tabel Evaluasi
        window.setupTablePagination('evaluasi-table-body', 'search-evaluasi', 'show-entries-evaluasi', 'pagination-evaluasi', 'pagination-info-evaluasi');
    }
}

// Fungsi inisialisasi khusus halaman Pelaporan
window.initPelaporan = function() {
    const filter = document.getElementById('filter-tahun-pelaporan');
    
    if (filter) {
        filter.addEventListener('change', function() {
            // Nonaktifkan fetch API agar tidak menimpa tabel Blade
            // fetchPelaporanData(window.currentPdPelaporan, this.value);
        });

        // Load data awal
        window.currentPdPelaporan = 'all'; // Reset pilihan PD
        // fetchPelaporanData('all', filter.value); // Nonaktifkan fetch awal
    }

    // Aktifkan fitur Search & Pagination untuk tabel Pelaporan (Pindahkan ke luar if agar pasti dieksekusi)
    window.setupTablePagination('pelaporan-table-body', 'search-pelaporan', 'show-entries-pelaporan', 'pagination-pelaporan', 'pagination-info-pelaporan');
}

// Fungsi inisialisasi khusus halaman Prestasi
window.initPrestasi = function() {
    const filter = document.getElementById('filter-tahun-prestasi');
    
    if (filter) {
        filter.addEventListener('change', function() {
            // Logika jika ingin memfilter data prestasi berdasarkan tahun via API di masa depan
            // Saat ini hanya menampilkan list PD dari tabel user
        });
    }

    // Aktifkan fitur Search & Pagination untuk tabel Prestasi
    window.setupTablePagination('prestasi-table-body', 'search-prestasi', 'show-entries-prestasi', 'pagination-prestasi', 'pagination-info-prestasi');
}

// Fungsi Fetch Data Api
window.fetchDokumen = function(tahun, judul = 'Rencana Strategis') {
    const tbodyKab = document.getElementById('dokumen-table-body');
    const tbodyOpd = document.getElementById('pd-table-body');

    if(tbodyKab) tbodyKab.innerHTML = '<tr><td colspan="2" class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...</td></tr>';
    if(tbodyOpd) tbodyOpd.innerHTML = '<tr><td colspan="3" class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...</td></tr>';

    // Update Label Tahun di Header Tabel secara dinamis
    const labelTahun = document.getElementById('label-tahun-dokumen');
    if (labelTahun) {
        labelTahun.innerText = tahun;
    }

    fetch(`api/dokumen-sakip?tahun=${tahun}&judul=${encodeURIComponent(judul)}`)
        .then(res => res.json())
        .then(response => {
            // 1. Render Tabel Kabupaten
            let rowsKab = '';
            if(response.kabupaten && response.kabupaten.length > 0) {
                response.kabupaten.forEach(item => {
                    // UPDATE: Menggunakan tombol Lihat dengan Modal Preview (sama seperti Evaluasi/Pelaporan)
                    rowsKab += `<tr><td class="text-center">${item.no}</td><td class="d-flex justify-content-between align-items-center"><span>${item.nama}</span><button class="btn btn-sm btn-info text-white rounded-pill px-3" onclick="viewPdf('${item.nama}', '${item.download}', ${item.hits}, '${item.table}', '${item.id}', '${item.pk}')"><i class="fas fa-eye me-1"></i> Lihat</button></td></tr>`;
                });
            } else {
                rowsKab = '<tr><td colspan="2" class="text-center py-3">Tidak ada dokumen untuk tahun ini.</td></tr>';
            }
            if(tbodyKab) tbodyKab.innerHTML = rowsKab;

            // 2. Render Tabel OPD
            let rowsOpd = '';
            if(response.data && response.data.length > 0) {
                response.data.forEach((item, index) => {
                    let actionBtn = '';
                    if (item.path && item.path !== '') {
                        actionBtn = `<button class="btn btn-sm btn-info text-white rounded-pill px-3" onclick="viewPdf('${item.nama_satker} - ${judul}', '${item.path}', ${item.hits}, 'file_sakip', '${item.id_file}', 'id_file_sakip')"><i class="fas fa-eye me-1"></i> Lihat</button>`;
                    } else {
                        actionBtn = `<span class="badge bg-secondary text-white rounded-pill px-3">Belum Tersedia</span>`;
                    }

                    rowsOpd += `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.nama_satker}</td>
                        <td class="text-center">${actionBtn}</td>
                    </tr>`;
                });
            } else {
                rowsOpd = '<tr><td colspan="3" class="text-center py-3">Tidak ada data perangkat daerah.</td></tr>';
            }
            if(tbodyOpd) tbodyOpd.innerHTML = rowsOpd;

            // Trigger update pagination/search untuk tabel OPD
            const searchInput = document.getElementById('search-pd');
            if (searchInput) {
                searchInput.dispatchEvent(new Event('keyup')); 
            }
        })
        .catch(err => {
            console.error(err);
            if(tbodyKab) tbodyKab.innerHTML = '<tr><td colspan="2" class="text-center text-danger py-3">Gagal memuat data.</td></tr>';
            if(tbodyOpd) tbodyOpd.innerHTML = '<tr><td colspan="3" class="text-center text-danger py-3">Gagal memuat data.</td></tr>';
        });
}

// Fungsi Fetch Data Evaluasi
window.fetchEvaluasiData = function(pdName, tahun) {
    const tbody = document.getElementById('evaluasi-table-body');
    if (!tbody) return;
 
    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div> Loading...</td></tr>';

    const url = `api/evaluasi-data?pd_name=${encodeURIComponent(pdName)}&tahun=${tahun}`;

    fetch(url)
        .then(res => res.json())
        .then(response => {
            let rows = '';
            if (response.data && response.data.length > 0) {
                response.data.forEach((item, index) => {
                    // Mapping data dari tabel file_evaluasi
                    // UPDATE: Menggunakan file dummy statis (DUMMY.pdf) di folder public/files/
                    // Pastikan file DUMMY.pdf sudah ada di folder public/files/
                    const fileUrl = `files/DUMMY.pdf`;
                    rows += `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${item.tahun || '-'}</td>
                        <td>${item.nama_satker || '-'}</td>
                        <td>
                            <div class="fw-bold">${item.judul || '-'}</div>
                            <small class="text-muted">${item.lhe_nama_file || ''}</small>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info text-white rounded-pill px-3" onclick="viewPdf('${item.judul}', '${fileUrl}', ${item.hits || 0}, 'file_evaluasi', '${item.id_file_evaluasi}', 'id_file_evaluasi')"><i class="fas fa-eye me-1"></i> Lihat</button>
                        </td>
                    </tr>`;
                });
            } else {
                rows = '<tr><td colspan="5" class="text-center py-4">Data evaluasi tidak ditemukan.</td></tr>';
            }
            tbody.innerHTML = rows;

            // Trigger update pagination/search setelah data dimuat
            const searchInput = document.getElementById('search-evaluasi');
            if (searchInput) {
                searchInput.dispatchEvent(new Event('keyup')); // Memaksa render ulang tabel
            }
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data evaluasi.</td></tr>';
        });
}

// Fungsi Fetch Data Pelaporan
window.fetchPelaporanData = function(pdName, tahun) {
    const tbody = document.getElementById('pelaporan-table-body');
    if (!tbody) return;
 
    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div> Loading...</td></tr>';

    const url = `api/pelaporan-data?pd_name=${encodeURIComponent(pdName)}&tahun=${tahun}`;

    fetch(url)
        .then(res => res.json())
        .then(response => {
            let rows = '';
            if (response.data && response.data.length > 0) {
                // ... (kode di atasnya)
                response.data.forEach((item, index) => {
                    // Menggunakan file dummy statis (DUMMY.pdf) agar bisa dilihat/diunduh
                    const fileUrl = `files/DUMMY.pdf`; 
                    rows += `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${item.tahun || '-'}</td>
                        <td>${item.nama_satker || '-'}</td>
                        <td>
                            <div class="fw-bold">${item.judul || '-'}</div>
                            <small class="text-muted">${item.nama_file || ''}</small>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info text-white rounded-pill px-3" 
                                    onclick="viewPdf('${item.judul}', '${fileUrl}', ${item.hits || 0}, 'file_sakip', '${item.id_file_sakip || 0}', 'id_file_sakip')">
                                <i class="fas fa-eye me-1"></i> Lihat
                            </button>
                        </td>
                    </tr>`;
                });
                // ... (kode di bawahnya)
            } else {
                rows = '<tr><td colspan="5" class="text-center py-4">Data pelaporan tidak ditemukan.</td></tr>';
            }
            tbody.innerHTML = rows;

            // Trigger update pagination/search setelah data dimuat
            const searchInput = document.getElementById('search-pelaporan');
            if (searchInput) {
                searchInput.dispatchEvent(new Event('keyup')); 
            }
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data pelaporan.</td></tr>';
        });
}

// Fungsi untuk menampilkan Modal Preview PDF
// Fungsi untuk menampilkan Modal Preview PDF
window.viewPdf = function(title, url, hits = 0, table = null, id = null, pk = 'id') {
    const modalEl = document.getElementById('pdfPreviewModal');
    if (modalEl) {
        // Update Judul
        const modalTitle = document.getElementById('pdfPreviewTitle');
        if (modalTitle) modalTitle.innerText = 'Pratinjau - ' + title;

        // Tampilkan Hits Badge
        let hitsBadge = document.getElementById('pdf-hits-badge');
        if (!hitsBadge) {
            hitsBadge = document.createElement('span');
            hitsBadge.id = 'pdf-hits-badge';
            hitsBadge.className = 'badge bg-warning text-dark ms-3';
            hitsBadge.style.fontSize = '0.8rem';
            modalTitle.parentNode.appendChild(hitsBadge);
        }
        
        // Pastikan angka awal aman dari undefined
        let currentHits = parseInt(hits) || 0;
        hitsBadge.innerHTML = `<i class="fas fa-eye me-1"></i> ${currentHits}`;

        // Update Iframe
        const iframe = document.getElementById('pdfViewerFrame');
        if (iframe) iframe.src = url;

        // Update Tombol Download
       // Update Tombol Download
        const btnDownload = document.getElementById('btnDownloadPdf');
        if (btnDownload) {
            btnDownload.href = url;
            
            // --- LOGIKA HITS UNDUH (BARU) ---
            // Hanya dieksekusi ketika tombol "Unduh Dokumen" di-klik
            btnDownload.onclick = function() {
                if (table && id && id !== 'null' && id !== '0' && id !== '') {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    fetch('/api/increment-hits-unduh', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ table: table, id: id, pk: pk })
                    }).catch(err => console.error("Gagal update hits unduh:", err));
                }
            };
            // ---------------------------------
        }

        // --- LOGIKA HITS TERPADU (YANG LAMA TETAP ADA) ---
        // Dieksekusi otomatis saat Modal Preview terbuka (untuk hitungan "Lihat")
        if (table && id && id !== 'null' && id !== '0' && id !== '') {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            fetch('/api/increment-hits', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ table: table, id: id, pk: pk })
            })
            .then(response => {
                if (response.ok) {
                    // Update angka badge di modal secara instan (ditambah 1)
                    hitsBadge.innerHTML = `<i class="fas fa-eye me-1"></i> ${currentHits + 1}`;
                }
            }).catch(err => console.error("Gagal update hits:", err));
        } 

        // Tampilkan Modal
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// Fungsi untuk menampilkan Modal Detail Pengukuran
window.viewPengukuranDetail = function(pdName, idFilePengukuran = null) {
    const modalEl = document.getElementById('pengukuranDetailModal');
    if (modalEl) {
        // Ambil tahun dari filter dropdown (jika ada), default 2026
        const filterTahun = document.getElementById('filter-tahun-pengukuran');
        const tahun = filterTahun ? filterTahun.value : '2026';
        const displayTahun = tahun === 'all' ? 'Semua Tahun' : tahun;

        // Update Judul Modal
        const modalTitle = document.getElementById('pengukuranDetailTitle');
        if (modalTitle) modalTitle.innerText = `Detail Pengukuran ${displayTahun} - ${pdName}`;

        // --- TAMBAHAN LOGIKA HITS UNTUK PENGUKURAN ---
        if (idFilePengukuran && idFilePengukuran !== 'null' && idFilePengukuran !== '0' && idFilePengukuran !== '') {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch('/api/increment-hits', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ 
                    table: 'file_pengukuran', 
                    id: idFilePengukuran, 
                    pk: 'id_file_pengukuran' 
                })
            }).catch(err => console.error("Gagal update hits pengukuran:", err));
        }
        // ----------------------------------------------

        // Generate Dummy Data untuk Tabel
        const tbody = document.getElementById('pengukuran-detail-body');
        if (tbody) {
            // Tampilkan Loading
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div> Loading...</td></tr>';

            // Fetch Data dari API
            fetch(`api/pengukuran-detail?pd_name=${encodeURIComponent(pdName)}&tahun=${tahun}`)
                .then(res => res.json())
                .then(response => {
                    let rows = '';
                    if (response.data && response.data.length > 0) {
                        response.data.forEach((item, index) => {
                            rows += `<tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${item.sasaran || '-'}</td>
                                <td>${item.nama_indikator || '-'}</td>
                                <td class="text-center">${item.target || '-'}</td>
                                <td class="text-center">${item.realisasi || '-'}</td>
                                <td class="text-center fw-bold text-success">${item.presentase || '-'}</td>
                            </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="6" class="text-center py-4">Data tidak ditemukan.</td></tr>';
                    }
                    tbody.innerHTML = rows;
                })
                .catch(err => {
                    console.error(err);
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger py-4">Gagal memuat data.</td></tr>';
                });
        }

        // Tampilkan Modal
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// Fungsi Fetch Data Pengukuran (IKU Kab, IKU PD, Keuangan)
window.fetchPengukuranData = function(tahun, triwulan = 'all') {
    const tbodyIku = document.getElementById('iku-kabupaten-body');
    const tbodyPd = document.getElementById('table-iku-pd-body');
    const tbodyKeuangan = document.getElementById('table-keuangan-body');
    const chartCanvas = document.getElementById('ikuChart');
    
    if (tbodyIku) tbodyIku.innerHTML = '<tr><td colspan="5" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div> Loading...</td></tr>';
    if (tbodyPd) tbodyPd.innerHTML = '<tr><td colspan="3" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div> Loading...</td></tr>';
    if (tbodyKeuangan) tbodyKeuangan.innerHTML = '<tr><td colspan="4" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div> Loading...</td></tr>';


    // Tampilkan animasi loading pada container grafik
    if (chartCanvas) {
        // Hapus chart lama agar canvas bersih saat loading
        if (window.ikuChartInstance) {
            window.ikuChartInstance.destroy();
            window.ikuChartInstance = null;
        }

        const chartContainer = chartCanvas.parentElement;
        // Tambahkan overlay loading
        if (!chartContainer.querySelector('.chart-loading-overlay')) {
            const loader = document.createElement('div');
            loader.className = 'chart-loading-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75';
            loader.innerHTML = '<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div>';
            chartContainer.appendChild(loader);
        }
    }

    fetch(`api/pengukuran-data?tahun=${tahun}&triwulan=${triwulan}`)
        .then(res => res.json())
        .then(response => {
            // Hapus overlay loading setelah data diterima
            if (chartCanvas) {
                const chartContainer = chartCanvas.parentElement;
                const loader = chartContainer.querySelector('.chart-loading-overlay');
                if (loader) loader.remove();
            }

            // 1. Render IKU Kabupaten & Chart
            let rows = '';
            const labels = [];
            const dataValues = [];

            if (response.iku_kab && response.iku_kab.length > 0) {
                response.iku_kab.forEach((item, index) => {
                    rows += `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.nama_indikator || '-'}</td>
                        <td class="text-center">${item.target || '-'}</td>
                        <td class="text-center">${item.realisasi || '-'}</td>
                        <td class="text-center fw-bold">${item.capaian || 0}%</td>
                    </tr>`;

                    // Data untuk Grafik
                    let label = item.nama_indikator || `Indikator ${index + 1}`;
                    if (label.length > 30) label = label.substring(0, 30) + '...';
                    labels.push(label);
                    dataValues.push(parseFloat(item.capaian) || 0);
                });

                // Render Grafik
                renderIkuChart(labels, dataValues);
            } else {
                rows = '<tr><td colspan="5" class="text-center py-4">Data tidak ditemukan untuk tahun ini.</td></tr>';
                if (window.ikuChartInstance) {
                    window.ikuChartInstance.destroy();
                    window.ikuChartInstance = null;
                }
            }
            if (tbodyIku) tbodyIku.innerHTML = rows;

            // 2. Render IKU Perangkat Daerah (List OPD)
            let rowsPd = '';
            if (response.pd_list && response.pd_list.length > 0) {
                response.pd_list.forEach((item, index) => {
                    rowsPd += `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.nama_satker}</td>
                        <td class="text-center">
                            <button class="btn btn-sm text-white rounded-pill px-3 btn-lihat-data" style="background-color: var(--primary-blue);" onclick="viewPengukuranDetail('${item.nama_satker}', '${item.id_file_pengukuran || 0}')">
                                <i class="fas fa-eye me-1"></i> Lihat Data
                            </button>
                        </td>
                    </tr>`;
                });
            } else {
                rowsPd = '<tr><td colspan="3" class="text-center py-4">Data Perangkat Daerah tidak ditemukan.</td></tr>';
            }
            if (tbodyPd) tbodyPd.innerHTML = rowsPd;

            // 3. Render Keuangan (Dummy / Api)
            let rowsKeuangan = '';
            const dataKeuangan = (response.keuangan && response.keuangan.length > 0) ? response.keuangan : [];
            
            if (dataKeuangan.length > 0) {
                dataKeuangan.forEach((item, index) => {
                    rowsKeuangan += `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.nama_satker}</td>
                        <td class="text-center fw-bold ${parseFloat(item.persen_keuangan) >= 90 ? 'text-success' : 'text-warning'}">
                            ${item.persen_keuangan}%
                        </td>
                        <td class="text-center fw-bold ${parseFloat(item.persen_fisik) >= 90 ? 'text-success' : 'text-primary'}">
                            ${item.persen_fisik}%
                        </td>
                    </tr>`;
                });
            } else {
                rowsKeuangan = '<tr><td colspan="4" class="text-center py-4 text-muted">Data Keuangan belum tersedia.</td></tr>';
            }
            if (tbodyKeuangan) tbodyKeuangan.innerHTML = rowsKeuangan;

            // Trigger update pagination
            if(document.getElementById('search-iku-pd')) document.getElementById('search-iku-pd').dispatchEvent(new Event('keyup'));
            if(document.getElementById('search-keuangan')) document.getElementById('search-keuangan').dispatchEvent(new Event('keyup'));
        })
        .catch(err => {
            console.error(err);
            if (tbodyIku) tbodyIku.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data.</td></tr>';
            // Hapus overlay loading jika error
            if (chartCanvas) {
                const chartContainer = chartCanvas.parentElement;
                const loader = chartContainer.querySelector('.chart-loading-overlay');
                if (loader) loader.remove();
            }
        });
}

// Fungsi Render Chart menggunakan Chart.js
window.renderIkuChart = function(labels, data) {
    const ctx = document.getElementById('ikuChart');
    if (!ctx) return;

    // Cek apakah library Chart.js sudah ada, jika belum load dinamis
    if (typeof Chart === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        document.head.appendChild(script);
        script.onload = () => window.renderIkuChart(labels, data);
        return;
    }

    // Hapus chart lama jika ada
    if (window.ikuChartInstance) {
        window.ikuChartInstance.destroy();
    }

    // Buat Chart Baru
    window.ikuChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Capaian (%)',
                data: data,
                backgroundColor: 'rgba(14, 91, 142, 0.8)',
                borderColor: 'rgba(14, 91, 142, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y', // Horizontal Bar
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.x + '%';
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' }
                },
                y: {
                    grid: { display: false }
                }
            }
        }
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
    // FIX: Tambahkan timestamp agar tidak dicache browser dan perubahan Blade langsung terlihat
    fetch(`page/${pageName}?t=${new Date().getTime()}`)
        .then(response => {
            if (!response.ok) throw new Error('Page not found on server');
            return response.text();
        })
        .then(html => {
            contentDiv.innerHTML = html;
            // Jalankan script inisialisasi jika halaman adalah perencanaan
            if (pageName === 'perencanaan') {
                initPerencanaan();
            } else if (pageName === 'pengukuran') {
                initPengukuran();
            } else if (pageName === 'evaluasi') {
                initEvaluasi();
            } else if (pageName === 'pelaporan') {
                initPelaporan();
            } else if (pageName === 'prestasi') {
                initPrestasi();
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

    // Periksa status autentikasi saat halaman dimuat
    window.checkAuthStatus();
});

// Fungsi ini dijalankan ketika tombol/link preview PDF diklik
function tambahHits(namaTabel, idData, primaryKey) {
    fetch('/api/increment-hits', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            table: namaTabel,
            id: idData,
            pk: primaryKey // Opsional, karena di backend sudah ada $pkMapping
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            console.log('Hits berhasil ditambahkan ke tabel: ' + data.debug.table);
        } else {
            console.error('Gagal menambah hits');
        }
    })
    .catch(error => console.error('Error memanggil API hits:', error));
}

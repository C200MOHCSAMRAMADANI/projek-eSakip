<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eSakip</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

    <nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top rounded-bottom-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#" onclick="loadPage('dashboard')">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" height="45" class="me-2">
                
                <div class="d-flex flex-column brand-text">
                    <span class="fw-bold fs-4 brand-title">eSakip</span>
                    <span class="fw-normal brand-subtitle">kabupaten Gunungkidul</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('dashboard')">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Sakip</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="loadPage('perencanaan')">Perencanaan</a></li>
                            <li><a class="dropdown-item" href="#" onclick="loadPage('pengukuran')">Pengukuran</a></li>
                            <li><a class="dropdown-item" href="#" onclick="loadPage('pelaporan')">Pelaporan</a></li>
                            <li><a class="dropdown-item" href="#" onclick="loadPage('evaluasi')">Evaluasi</a></li>
                            <li><a class="dropdown-item" href="#" onclick="loadPage('prestasi')">Prestasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('infografis')">Info Grafis</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="loadPage('kontak')">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="main-content"></div>

    <footer>
        <div class="container text-center">
            <p class="mb-0 fw-bold">Dikembangkan Oleh Diskominfo Kabupaten Gunungkidul.</p>
            <hr class="my-2">
            <div class="mb-3">
                <a href="https://x.com/kominfogk" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="https://www.facebook.com/share/17fyN7eJd4/" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/kominfogunungkidul?igsh=dTd6aGZ2NTRzbzM2" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://youtube.com/@kominfogunungkidul?si=R5Js1T-NZIYFALIz" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app-spa.js') }}"></script>

    <script>
        // Deteksi Scroll
        window.onscroll = function() {
            var navbar = document.getElementById("mainNavbar");
            
            // Jika scroll lebih dari 50 pixel ke bawah
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                // Tambahkan kelas 'navbar-scrolled' (Background Putih, Teks Biru)
                navbar.classList.add("navbar-scrolled");
            } else {
                // Jika kembali ke atas, hapus kelasnya (Background Biru, Teks Putih)
                navbar.classList.remove("navbar-scrolled");
            }
        };
    </script>

</body>
</html>
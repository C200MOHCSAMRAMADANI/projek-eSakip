<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getPage($page)
    {
        $data = [];

        // LOGIKA MVC: Siapkan data di Controller, bukan di View
        switch ($page) {
            case 'pelaporan':
            case 'evaluasi':
            case 'pengukuran': // Asumsi pengukuran juga pakai list yang sama
                $data['pd_list'] = [
                    'Sekretariat Daerah', 
                    'Inspektorat Daerah', 
                    'Dinas Pendidikan', 
                    'Dinas Kesehatan', 
                    'Bappeda',
                    'Dinas Komunikasi dan Informatika'
                ];
                break;

            case 'infografis':
                $data['items'] = [
                    ['title' => 'Capaian Kinerja 2025', 'desc' => 'Ringkasan capaian indikator kinerja utama tahun 2025.'],
                    ['title' => 'Alur Perencanaan', 'desc' => 'Diagram alur proses perencanaan pembangunan daerah.'],
                    ['title' => 'Pohon Kinerja', 'desc' => 'Visualisasi cascading kinerja dari level daerah hingga individu.'],
                    ['title' => 'Anggaran Berbasis Kinerja', 'desc' => 'Proporsi anggaran yang mendukung pencapaian kinerja utama.'],
                    ['title' => 'Evaluasi SAKIP', 'desc' => 'Hasil evaluasi implementasi SAKIP oleh Kemenpan RB.'],
                    ['title' => 'Inovasi Pelayanan', 'desc' => 'Dokumentasi inovasi pelayanan publik perangkat daerah.']
                ];
                break;
            
            case 'prestasi':
                $data['prestasi_list'] = [
                    ['pd' => 'Bappeda', 'ket' => 'Juara 1 SAKIP Award'],
                    ['pd' => 'Dinas Kominfo', 'ket' => 'Terbaik Implementasi SPBE'],
                ];
                break;
        }

        // Cek apakah view blade tersedia di folder resources/views/pages/
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}", $data);
        }
        
        // Cek juga di root resources/views/ (jika file tidak di dalam folder pages)
        if (view()->exists($page)) {
            return view($page, $data);
        }
        
        return response('Halaman tidak ditemukan', 404);
    }
}
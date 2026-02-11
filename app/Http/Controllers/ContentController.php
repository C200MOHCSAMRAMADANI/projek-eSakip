<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            case 'perencanaan': // Tambahkan perencanaan agar mendapat data pd_list
                // Daftar Perangkat Daerah (Sesuai Permintaan)
                // MENGAMBIL DARI DATABASE TABEL USER
                $data['pd_list'] = DB::table('user')->orderBy('nama_satker', 'asc')->pluck('nama_satker');

                // Ambil tahun terbaru dari database (pengukuran_iku_2023) atau tahun saat ini
                // Ini memastikan filter dinamis mengikuti data (misal 2026) atau tahun berjalan
                $maxYearDb = DB::table('pengukuran_iku_2023')->max('tahun');
                $latestYear = $maxYearDb ? max((int)$maxYearDb, (int)date('Y')) : (int)date('Y'); // Gunakan tahun terbesar

                $data['years'] = range($latestYear, 2018);
                
                // Mengambil data filter Triwulan dari tabel file_pengukuran kolom judul
                $data['triwulan'] = DB::table('file_pengukuran')
                    ->distinct()
                    ->pluck('judul'); 
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

    public function getPengukuranDetail(Request $request)
    {
        $pdName = $request->query('pd_name');
        $tahun = $request->query('tahun');
        // 1. Cari ID OPD berdasarkan Nama Satker di tabel user
        // Asumsi: Nama di tabel user (nama_satker) sesuai dengan parameter yang dikirim
        $user = DB::table('user')->where('nama_satker', $pdName)->first();

        if (!$user) {
            return response()->json(['data' => []]);
        }

        // 2. Ambil data Sasaran & Indikator
        $query = DB::table('sasaran_indikator as si')
            ->leftJoin('pengukuran_sasaran as ps', 'si.id_pengukuran_sasaran', '=', 'ps.id_pengukuran_sasaran')
            ->where('si.id_opd', $user->id_opd);

        if ($tahun && $tahun !== 'all') {
            $query->where('si.tahun', $tahun);
        }

        $data = $query
            ->select(
                'ps.sasaran',
                'si.nama_indikator',
                'si.target',
                'si.realisasi',
                'si.presentase'
            )
            ->get();

        return response()->json(['data' => $data]);
    }

    public function getIkuKabupaten(Request $request)
    {
        $tahun = $request->query('tahun');
        $triwulan = $request->query('triwulan');
        
        // Ambil data dari database pengukuran_iku_2023
        $query = DB::table('pengukuran_iku_2023');

        if ($tahun && $tahun !== 'all') {
            $query->where('tahun', $tahun);
        }

        if ($triwulan && $triwulan !== 'all') {
            $query->where('triwulan', $triwulan);
        }

        return response()->json(['data' => $query->get()]);
    }

    public function getEvaluasiData(Request $request)
    {
        $pdName = $request->query('pd_name');
        $tahun = $request->query('tahun');

        // Ambil data dari tabel file_evaluasi dan join dengan user untuk nama OPD
        $query = DB::table('file_evaluasi as fe')
            ->leftJoin('user as u', 'fe.id_opd', '=', 'u.id_opd')
            ->select(
                'fe.*',
                'u.nama_satker'
            );

        if ($pdName && $pdName !== 'all') {
            $query->where('u.nama_satker', $pdName);
        }

        if ($tahun && $tahun !== 'all') {
            $query->where('fe.tahun', $tahun);
        }

        $query->orderBy('fe.tahun', 'desc')
              ->orderBy('fe.tgl_posting', 'desc');

        return response()->json(['data' => $query->get()]);
    }
}
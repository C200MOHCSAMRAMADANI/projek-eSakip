<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpaController extends Controller
{
    public function getPage($page)
    {
        // Cek apakah view blade tersedia di folder resources/views/pages/
        if (View::exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        // Jika view tidak ditemukan, kembalikan error 404
        abort(404);
    }

    public function getDokumen(Request $request)
    {
        // Ambil parameter tahun, default ke 2026
        $tahun = $request->query('tahun', '2026');
        $judul = $request->query('judul', 'Rencana Strategis'); // Default judul
        
        // Mengambil data menggunakan fungsi private get_kabupaten_data
        $kabupatenData = $this->get_kabupaten_data($tahun);
        $opdData = $this->get_opd_data($tahun, $judul);

        return response()->json(['kabupaten' => $kabupatenData, 'data' => $opdData]);
    }

    private function get_kabupaten_data($tahun) {
        // Daftar Jenis Dokumen untuk Kabupaten (Key = Nama Tabel, Value = Judul Dokumen)
        $judul_list = [
            'dataKab_rpjpd'     => 'RPJPD',
            'dataKab_rpjmd'     => 'RPJMD',
            'dataKab_rkpd'      => 'RKPD',
            'dataKab_iku'       => 'SK Indikator Kinerja Utama',
            'dataKab_lkjip'     => 'Laporan Kinerja',
            'dataKab_pkbupati'  => 'Perjanjian Kinerja',
            'dataKab_lhe'       => 'Laporan Hasil Evaluasi',
            'dataKab_cascading' => 'Cascading'
        ];

        $results = [];
        $no = 1;
        $dummyPdf = asset('files/DUMMY.pdf'); // Fallback jika file tidak ditemukan

        foreach ($judul_list as $table => $judul) {
            $downloadUrl = $dummyPdf; // Default ke dummy

            // Cek apakah tabel ada di database untuk menghindari error SQL
            if (Schema::hasTable($table)) {
                // Ambil data berdasarkan tahun
                $item = DB::table($table)->where('tahun', $tahun)->first();
                
                // Jika data ditemukan dan kolom nama_file ada isinya
                if ($item && !empty($item->nama_file)) {
                    // Asumsi file tersimpan di storage/uploads/
                    // Sesuaikan path ini dengan lokasi penyimpanan file asli Anda
                    $downloadUrl = asset('storage/uploads/' . $item->nama_file);
                }
            }

            $results[] = [
                'no' => $no++,
                'nama' => $judul,
                'download' => $downloadUrl
            ];
        }

        return $results;
    }

    private function get_opd_data($tahun, $judul) {
        // Replikasi Logic dari CI Controller Perencanaan -> get_data()
        /*
        SELECT 
            u.nama_satker, fa.id_file_sakip, fa.nama_file,
            CASE WHEN fa.verifikasi = 1 THEN ... ELSE '' END AS path, ...
        FROM (SELECT * FROM user WHERE level = 'client' AND status = 'aktif') u
        LEFT JOIN file_sakip AS fa ON u.id_opd = fa.id_opd AND fa.judul = ? AND fa.tahun = ?
        WHERE u.id_opd <> '00_' ORDER BY u.kd_unit_kerja ASC
        */

        $data = DB::table('user as u')
            ->leftJoin('file_sakip as fa', function($join) use ($tahun, $judul) {
                $join->on('u.id_opd', '=', 'fa.id_opd')
                     ->where('fa.judul', '=', $judul)
                     ->where('fa.tahun', '=', $tahun);
            })
            ->where('u.level', 'client')
            ->where('u.status', 'aktif')
            ->where('u.id_opd', '<>', '00_')
            ->select(
                'u.nama_satker',
                'u.id_opd',
                'u.nama_lengkap',
                'fa.id_file_sakip',
                'fa.nama_file',
                'fa.verifikasi',
                'fa.tgl_verifikasi',
                'fa.tahun'
            )
            ->orderBy('u.kd_unit_kerja', 'ASC')
            ->get();

        // pengambilan data pada perencanaaannnnn
        return $data->map(function($item) {
            // Path: uploads/tahun/id_opd+nama_lengkap/nama_file
            // $path = ($item->verifikasi == 1 && $item->nama_file) 
            //     ? asset('uploads/' . $item->tahun . '/' . $item->id_opd . $item->nama_lengkap . '/' . $item->nama_file) 
            //     : asset('files/DUMMY.pdf');
             $path = asset('files/DUMMY.pdf');
            return [
                'nama_satker' => $item->nama_satker,
                'nama_file' => $item->nama_file,
                'path' => $path,
                'verifikasi' => $item->verifikasi,
                'tgl_verifikasi' => $item->tgl_verifikasi
            ];
        });
    }

    public function getPengukuran(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));
        $triwulan = $request->query('triwulan', 'all');

        // 1. API SIPANDA (Keuangan) - Dummy
        // Mengambil data OPD aktif untuk simulasi data keuangan
        $dataKeuangan = DB::table('user')
            ->select('nama_satker')
            ->where('level', 'client')
            ->where('status', 'aktif')
            ->where('id_opd', '<>', '00_')
            ->orderBy('nama_satker', 'ASC')
            ->get()
            ->map(function ($item) use ($tahun) {
                // Gunakan seed agar angka konsisten per OPD & Tahun (tidak berubah saat refresh)
                mt_srand(crc32($item->nama_satker . $tahun));
                
                // Simulasi Persentase saja (Keuangan & Fisik)
                $persenKeuangan = mt_rand(7500, 9900) / 100; // Random 75.00 - 99.00
                $persenFisik = mt_rand(8000, 10000) / 100;   // Random 80.00 - 100.00
                
                return [
                    'nama_satker' => $item->nama_satker,
                    'persen_keuangan' => number_format($persenKeuangan, 2),
                    'persen_fisik' => number_format($persenFisik, 2)
                ];
            });

        // 2. Data IKU Kabupaten (Dari Database)
        $query = DB::table('pengukuran_iku_2023');

        if ($tahun !== 'all') {
            $query->where('tahun', $tahun);
        }

        if ($triwulan !== 'all') {
            $query->where('triwulan', $triwulan);
        }

        $dataIkuKab = $query->get();

        // 3. Data Kinerja PD (List OPD)
        $dataKinerjaPd = DB::table('user')
            ->where('status', 'aktif')
            ->whereNotIn('nama_satker', [
                'PEMERINTAH KABUPATEN GUNUNGKIDUL',
                'ADMIN',
                'BAGIAN ORGANISASI SETDA GK',
                'BAGIAN ORGANISASI'
            ])
            ->orderBy('kd_unit_kerja', 'ASC')
            ->select('nama_satker', 'id_opd')
            ->get();

        return response()->json([
            'keuangan' => $dataKeuangan,
            'iku_kab' => $dataIkuKab,
            'pd_list' => $dataKinerjaPd
        ]);
    }
}
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
        
        // Mengambil data menggunakan fungsi private get_kabupaten_data
        $data = $this->get_kabupaten_data($tahun);

        return response()->json(['data' => $data]);
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
        $dummyPdf = 'files/DUMMY.pdf'; // Fallback jika file tidak ditemukan

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
}
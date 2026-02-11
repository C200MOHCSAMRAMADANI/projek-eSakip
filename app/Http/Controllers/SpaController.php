<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
        
        // Data dummy statis untuk Perencanaan (Jenis Dokumen)
        $data = [
            ['no' => 1, 'nama' => 'RPJPD', 'download' => '#'],
            ['no' => 2, 'nama' => 'RPJMD', 'download' => '#'],
            ['no' => 3, 'nama' => 'RKPD', 'download' => '#'],
            ['no' => 4, 'nama' => 'IKU BUPATI', 'download' => '#'],
            ['no' => 5, 'nama' => 'LKJIP BUPATI', 'download' => '#'],
            ['no' => 6, 'nama' => 'Perjanjian Kinerja Bupati', 'download' => '#'],
            ['no' => 7, 'nama' => 'LHE AKIP', 'download' => '#'],
            ['no' => 8, 'nama' => 'Cascading IKU', 'download' => '#'],
        ];

        return response()->json(['data' => $data]);
    }
}
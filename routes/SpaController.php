<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
        $data = [];

        if ($tahun == '2026') {
            $data = [
                ['no' => 1, 'nama' => 'Dokumen Renstra Bappeda', 'download' => '#'],
                ['no' => 2, 'nama' => 'Dokumen Renstra Dinkes', 'download' => '#'],
            ];
        } elseif ($tahun == '2025') {
            $data = [
                ['no' => 1, 'nama' => 'Laporan Kinerja 2025', 'download' => '#'],
                ['no' => 2, 'nama' => 'Evaluasi Sakip 2025', 'download' => '#'],
            ];
        }

        return response()->json(['data' => $data]);
    }
}
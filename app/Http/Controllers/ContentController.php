<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getPage($page)
    {
        // Cek apakah view blade tersedia di folder resources/views/pages/
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }
        
        // Cek juga di root resources/views/ (jika file tidak di dalam folder pages)
        if (view()->exists($page)) {
            return view($page);
        }
        
        return response('Halaman tidak ditemukan', 404);
    }
}
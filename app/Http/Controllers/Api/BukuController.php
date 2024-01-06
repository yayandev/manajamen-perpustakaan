<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();

        return response()->json($buku);
    }

    public function show($slug)
    {
        $buku = Buku::with('kategori', 'user')->where('slug', $slug)->first();
        return response()->json($buku);
    }
}

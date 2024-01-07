<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return response()->json($kategoris);
    }

    public function show($slug)
    {
        $kategori = Kategori::where('slug', $slug)->with('buku')->first();
        return response()->json($kategori);
    }
}

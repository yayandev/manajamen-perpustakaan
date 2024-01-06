<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori:id,name,slug')->orderBy('created_at', 'DESC')->paginate(4);

        return response()->json($buku);
    }

    public function show($slug)
    {
        $buku = Buku::with('kategori', 'user')->where('slug', $slug)->first();
        return response()->json($buku);
    }

    public function search(Request $request)
    {
        if (!$request->keyword) {
            return response()->json([
                'message' => 'keyword required',
                'success' => false,
                'data' => null
            ]);
        }
        $buku = Buku::where('title', 'LIKE', '%' . $request->keyword . '%')->paginate(4);

        return response()->json($buku);
    }
}

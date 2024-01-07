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
        $buku = Buku::with('kategori', 'user:id,name,profile_picture')->where('slug', $slug)->first();
        if (!$buku) {
            return response()->json([
                'message' => 'buku not found',
                'success' => false,
                'data' => null
            ], 404);
        }
        $bukuLainnya  = Buku::where('kategori_id', $buku->kategori_id)->where('id', '!=', $buku->id)->limit(4)->get();
        return response()->json([
            'data' => $buku,
            'bukuLainnya' => $bukuLainnya
        ]);
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

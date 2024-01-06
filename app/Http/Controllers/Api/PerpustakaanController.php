<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perpustakaan;
use Illuminate\Http\Request;

class PerpustakaanController extends Controller
{
    public function index()
    {
        $perpustakaan = Perpustakaan::all();

        return response()->json($perpustakaan);
    }

    public function show(Perpustakaan $perpustakaan)
    {
        return response()->json($perpustakaan);
    }
}

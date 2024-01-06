<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $perpustakaan = Perpustakaan::all();
        if ($request->has('search')) {
            $kategori = Kategori::where('name', 'LIKE', '%' . $request->search . '%')->paginate(4);
            return view('kategori.index', compact('kategori', 'perpustakaan'));
        }
        $kategori = Kategori::paginate(4);
        return view('kategori.index', compact('kategori', 'perpustakaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'min:3|required',
            'description' => 'required',
            'perpustakaan_id' => 'required'
        ]);

        $slug = Str::slug($request->name);

        // cek slug

        $cek = Kategori::where('slug', $slug)->first();

        if ($cek) {
            $slug = $slug . '-' . rand(1, 100);
        }

        $kategori = Kategori::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
            'perpustakaan_id' => $request->perpustakaan_id
        ]);

        if (!$kategori) {
            return redirect('/kategori')->with(['error' => 'Data Gagal Disimpan']);
        }

        return redirect('/kategori')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return redirect()->back()->with(['error' => 'Data Tidak Ditemukan']);
        }
        $kategori->delete();
        return redirect('/kategori')->with(['success' => 'Data Berhasil Dihapus']);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'min:3|required',
            'description' => 'required',
            'perpustakaan_id' => 'required'
        ]);

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return redirect('/kategori')->with(['error' => 'Data Tidak Ditemukan']);
        }

        $slug = "";

        if ($kategori->name !== $request->name) {
            $slug = Str::slug($request->name);
            $cek = Kategori::where('slug', $slug)->first();
            if ($cek = Kategori::where('slug', $slug)->first()) {
                $slug = $slug . '-' . rand(1, 100);
            }
        } else {
            $slug = $request->slug;
        }

        $update = $kategori->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
            'perpustakaan_id' => $request->perpustakaan_id
        ]);

        if (!$update) {
            return redirect('/kategori')->with(['error' => 'Data Gagal Diperbarui']);
        }

        return redirect('/kategori')->with(['success' => 'Data Berhasil Diperbarui']);
    }
}

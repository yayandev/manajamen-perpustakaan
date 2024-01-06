<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        if ($request->has('search')) {
            $bukus = Buku::where('title', 'LIKE', '%' . $request->search . '%')->paginate(4);

            return view('buku.index', compact('bukus', 'kategori'));
        }

        $bukus = Buku::paginate(4);
        return view('buku.index', compact('bukus', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'kategori_id' => 'required',
            'publisher' => 'required',
            'year' => 'required',
            'isbn' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:5048',
            'description' => 'required',
        ]);

        $image = $request->file('image');

        $image->storeAs('public/buku', $image->hashName());

        $slug = Str::slug($request->title);

        // cek slug

        $buku = Buku::where('slug', $slug)->first();

        if ($buku) {
            $slug = $slug . '-' . rand(1, 100);
        }

        $user_id = auth()->user()->id;

        $buku = Buku::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'isbn' => $request->isbn,
            'image' => $image->hashName(),
            'description' => $request->description,
            'slug' => $slug,
            'user_id' => $user_id,
            'kategori_id' => $request->kategori_id,
        ]);

        if (!$buku) {
            return redirect('/buku')->with(['error' => 'Data Gagal Disimpan']);
        }

        return redirect('/buku')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return redirect('/buku')->with(['error' => 'Data Tidak Ditemukan']);
        }
        $deleted = $buku->delete();

        if ($deleted) {
            Storage::delete('public/buku/' . basename($buku->image));
        }
        return redirect('/buku')->with(['success' => 'Data Berhasil Dihapus']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required',
            'isbn' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|max:5048',
            'description' => 'required',
            'kategori_id' => 'required'
        ]);

        $buku = Buku::find($id);

        if (!$buku) {
            return redirect('/buku')->with(['error' => 'Data Tidak Ditemukan']);
        }

        $slug = "";

        if ($buku->title !== $request->title) {
            $slug = Str::slug($request->title);

            // cek slug

            $cek = Buku::where('slug', $slug)->first();

            if ($cek) {
                $slug = $slug . '-' . rand(1, 100);
            }
        } else {
            $slug = $buku->slug;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/buku', $image->hashName());

            $oldImage = $buku->image;

            $updated = $buku->update([
                'title' => $request->title,
                'author' => $request->author,
                'publisher' => $request->publisher,
                'year' => $request->year,
                'isbn' => $request->isbn,
                'image' => $image->hashName(),
                'description' => $request->description,
                'slug' => $slug,
                'kategori_id' => $request->kategori_id
            ]);

            if (!$updated) {
                return redirect('/buku')->with(['error' => 'Data Gagal Diperbarui']);
            }

            Storage::delete('public/buku/' . basename($oldImage));

            return redirect('/buku')->with(['success' => 'Data Berhasil Diperbarui']);
        }

        $updated = $buku->update([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'isbn' => $request->isbn,
            'description' => $request->description,
            'slug' => $slug,
            'kategori_id' => $request->kategori_id
        ]);

        if (!$updated) {
            return redirect('/buku')->with(['error' => 'Data Gagal Diperbarui']);
        }

        return redirect('/buku')->with(['success' => 'Data Berhasil Diperbarui']);
    }
}

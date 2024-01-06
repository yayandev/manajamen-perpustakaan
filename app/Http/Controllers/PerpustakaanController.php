<?php

namespace App\Http\Controllers;

use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerpustakaanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $perpustakaan = Perpustakaan::where('name', 'LIKE', '%' . $request->search . '%')->paginate(4);
            return view('perpustakaan.index', compact('perpustakaan'));
        }
        $perpustakaan = Perpustakaan::paginate(4);
        return view('perpustakaan.index', compact('perpustakaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'alamat' => 'required',
            'bio' => 'required',
        ]);

        $logo = $request->file('logo');

        $logo->storeAs('public/perpustakaan', $logo->hashName());

        $perpustakaan = Perpustakaan::create([
            'name' => $request->name,
            'image' => $logo->hashName(),
            'alamat' => $request->alamat,
            'bio' => $request->bio,
        ]);

        if (!$perpustakaan) {
            return redirect()->back()->with('error', 'Data Gagal Disimpan');
        }
        return redirect()->route('perpustakaan')->with('success', 'Data Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $perpustakaan = Perpustakaan::find($id);
        if (!$perpustakaan) {
            return redirect()->back()->with('error', 'Data Tidak Ditemukan');
        }

        if ($perpustakaan->image !== null) {
            Storage::delete('public/perpustakaan/' . basename($perpustakaan->image));
        }

        $perpustakaan->delete();
        return redirect('/perpustakaan')->with(['success' => 'Data Berhasil Dihapus']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'logo' => 'image|mimes:png,jpg,jpeg|max:2048',
            'alamat' => 'required',
            'bio' => 'required',
        ]);

        $perpustakaan = Perpustakaan::find($id);

        if (!$perpustakaan) {
            return redirect('/perpustakaan')->with(['error' => 'Data Tidak Ditemukan']);
        }

        if ($request->hasFile('logo')) {
            if ($perpustakaan->image !== null) {
                Storage::delete('public/perpustakaan/' . basename($perpustakaan->image));
            }

            $logo = $request->file('logo');

            $logo->storeAs('public/perpustakaan', $logo->hashName());

            $perpustakaan->update([
                'name' => $request->name,
                'image' => $logo->hashName(),
                'alamat' => $request->alamat,
                'bio' => $request->bio,
            ]);

            return redirect('/perpustakaan')->with(['success' => 'Data Berhasil Disimpan']);
        }

        $perpustakaan->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'bio' => $request->bio,
        ]);

        return redirect('/perpustakaan')->with(['success' => 'Data Berhasil Disimpan']);
    }
}

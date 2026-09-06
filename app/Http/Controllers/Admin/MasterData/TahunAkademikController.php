<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $tahunList = TahunAkademik::latest()->paginate(15);

        return view('admin.master.tahun-akademik.index', compact('tahunList'));
    }

    public function create()
    {
        return view('admin.master.tahun-akademik.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:10',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
        ]);
        TahunAkademik::create($validated);

        return redirect()->route('admin.master.tahun-akademik.index')->with('success', 'Tahun akademik berhasil ditambahkan.');
    }

    public function show(TahunAkademik $tahunAkademik)
    {
        return view('admin.master.tahun-akademik.show', compact('tahunAkademik'));
    }

    public function edit(TahunAkademik $tahunAkademik)
    {
        return view('admin.master.tahun-akademik.edit', compact('tahunAkademik'));
    }

    public function update(Request $request, TahunAkademik $tahunAkademik)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:10',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
        ]);
        $tahunAkademik->update($validated);

        return redirect()->route('admin.master.tahun-akademik.index')->with('success', 'Tahun akademik berhasil diperbarui.');
    }

    public function destroy(TahunAkademik $tahunAkademik)
    {
        $tahunAkademik->delete();

        return redirect()->route('admin.master.tahun-akademik.index')->with('success', 'Tahun akademik berhasil dihapus.');
    }

    public function setAktif(TahunAkademik $tahunAkademik)
    {
        TahunAkademik::where('is_aktif', true)->update(['is_aktif' => false]);
        $tahunAkademik->update(['is_aktif' => true]);

        return redirect()->back()->with('success', "Tahun akademik {$tahunAkademik->label} dijadikan aktif.");
    }
}

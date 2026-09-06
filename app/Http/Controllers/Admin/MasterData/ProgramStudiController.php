<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $prodiList = ProgramStudi::withCount(['mahasiswa', 'dosen'])->paginate(15);

        return view('admin.master.program-studi.index', compact('prodiList'));
    }

    public function create()
    {
        return view('admin.master.program-studi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:program_studi',
            'nama' => 'required|string|max:255',
            'jenjang' => 'required|in:S1,S2,D3,D4',
            'ketua' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);
        ProgramStudi::create($validated);

        return redirect()->route('admin.master.program-studi.index')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function show(ProgramStudi $programStudi)
    {
        $programStudi->load(['mahasiswa', 'dosen']);

        return view('admin.master.program-studi.show', compact('programStudi'));
    }

    public function edit(ProgramStudi $programStudi)
    {
        return view('admin.master.program-studi.edit', compact('programStudi'));
    }

    public function update(Request $request, ProgramStudi $programStudi)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:program_studi,kode,'.$programStudi->id,
            'nama' => 'required|string|max:255',
            'jenjang' => 'required|in:S1,S2,D3,D4',
            'ketua' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);
        $programStudi->update($validated);

        return redirect()->route('admin.master.program-studi.index')->with('success', 'Program studi berhasil diperbarui.');
    }

    public function destroy(ProgramStudi $programStudi)
    {
        $programStudi->delete();

        return redirect()->route('admin.master.program-studi.index')->with('success', 'Program studi berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswaList = Mahasiswa::with(['prodi', 'user', 'skripsi'])
            ->when($request->search, fn ($q) => $q->where('nama', 'like', "%{$request->search}%")->orWhere('nim', 'like', "%{$request->search}%"))
            ->when($request->prodi_id, fn ($q) => $q->where('prodi_id', $request->prodi_id))
            ->when($request->status, fn ($q) => $q->where('status_skripsi', $request->status))
            ->paginate(20)->withQueryString();
        $prodiList = ProgramStudi::where('status', true)->get();

        return view('admin.master.mahasiswa.index', compact('mahasiswaList', 'prodiList'));
    }

    public function create()
    {
        $prodiList = ProgramStudi::where('status', true)->get();

        return view('admin.master.mahasiswa.create', compact('prodiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:30|unique:mahasiswa',
            'nama' => 'required|string|max:255',
            'prodi_id' => 'required|exists:program_studi,id',
            'angkatan' => 'nullable|string|max:10',
            'semester' => 'required|integer|min:1|max:14',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => User::ROLE_MAHASISWA,
        ]);

        Mahasiswa::create(array_merge($validated, ['user_id' => $user->id]));

        return redirect()->route('admin.master.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan. Password default: password');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load(['prodi', 'user', 'skripsi.pembimbing.dosen', 'skripsi.ujian.penguji.dosen', 'pendaftaranYudisium.periode']);

        return view('admin.master.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $prodiList = ProgramStudi::where('status', true)->get();

        return view('admin.master.mahasiswa.edit', compact('mahasiswa', 'prodiList'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:30|unique:mahasiswa,nim,'.$mahasiswa->id,
            'nama' => 'required|string|max:255',
            'prodi_id' => 'required|exists:program_studi,id',
            'angkatan' => 'nullable|string|max:10',
            'semester' => 'required|integer|min:1|max:14',
            'email' => 'required|email|unique:users,email,'.$mahasiswa->user_id,
            'no_hp' => 'nullable|string|max:20',
            'status_skripsi' => 'nullable|string',
        ]);
        $mahasiswa->update($validated);
        $mahasiswa->user->update(['name' => $request->nama, 'email' => $request->email]);

        return redirect()->route('admin.master.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('admin.master.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}

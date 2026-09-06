<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $dosenList = Dosen::with(['prodi', 'user'])
            ->when($request->search, fn ($q) => $q->where('nama', 'like', "%{$request->search}%")->orWhere('nidn', 'like', "%{$request->search}%"))
            ->when($request->prodi_id, fn ($q) => $q->where('prodi_id', $request->prodi_id))
            ->paginate(15)->withQueryString();
        $prodiList = ProgramStudi::where('status', true)->get();

        return view('admin.master.dosen.index', compact('dosenList', 'prodiList'));
    }

    public function create()
    {
        $prodiList = ProgramStudi::where('status', true)->get();

        return view('admin.master.dosen.create', compact('prodiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|max:20|unique:dosen',
            'nama' => 'required|string|max:255',
            'prodi_id' => 'nullable|exists:program_studi,id',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'in:tetap,tidak_tetap',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => User::ROLE_DOSEN,
        ]);

        $dosen = Dosen::create(array_merge($validated, ['user_id' => $user->id]));

        return redirect()->route('admin.master.dosen.index')->with('success', 'Dosen berhasil ditambahkan. Password default: password');
    }

    public function show(Dosen $dosen)
    {
        $dosen->load(['prodi', 'user', 'pembimbingan.skripsi.mahasiswa', 'pengujian.ujian.skripsi.mahasiswa']);

        return view('admin.master.dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen)
    {
        $prodiList = ProgramStudi::where('status', true)->get();

        return view('admin.master.dosen.edit', compact('dosen', 'prodiList'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|max:20|unique:dosen,nidn,'.$dosen->id,
            'nama' => 'required|string|max:255',
            'prodi_id' => 'nullable|exists:program_studi,id',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'in:tetap,tidak_tetap',
            'email' => 'required|email|unique:users,email,'.$dosen->user_id,
            'no_hp' => 'nullable|string|max:20',
            'is_aktif' => 'boolean',
        ]);
        $dosen->update($validated);
        $dosen->user->update(['name' => $request->nama, 'email' => $request->email]);

        return redirect()->route('admin.master.dosen.index')->with('success', 'Dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('admin.master.dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;
        $skripsi = $mahasiswa->skripsi;

        return view('mahasiswa.pengajuan.index', compact('mahasiswa', 'skripsi'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        if ($mahasiswa->skripsi) {
            return redirect()->back()->with('error', 'Anda sudah memiliki pengajuan skripsi.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:500',
            'latar_belakang' => 'nullable|string',
            'rumusan_masalah' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'metode' => 'nullable|string',
            'bidang_penelitian' => 'nullable|string|max:255',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
        ]);

        $deskripsi = collect([
            $validated['latar_belakang'] ? "Latar Belakang:\n{$validated['latar_belakang']}" : null,
            $validated['rumusan_masalah'] ? "Rumusan Masalah:\n{$validated['rumusan_masalah']}" : null,
            $validated['tujuan'] ? "Tujuan:\n{$validated['tujuan']}" : null,
            $validated['metode'] ? "Metode:\n{$validated['metode']}" : null,
        ])->filter()->implode("\n\n");

        $tahunAktif = TahunAkademik::where('is_aktif', true)->first();
        if (! $tahunAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun akademik aktif. Hubungi admin.');
        }

        $skripsi = Skripsi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tahun_akademik_id' => $tahunAktif->id,
            'judul' => $validated['judul'],
            'deskripsi' => $deskripsi,
            'bidang_kajian' => $validated['bidang_penelitian'] ?? null,
            'tanggal_pengajuan' => now()->toDateString(),
            'status' => 'pengajuan',
        ]);

        if ($request->hasFile('proposal_file')) {
            $path = $request->file('proposal_file')->store('proposal_mahasiswa', 'public');

            \App\Models\Dokumen::create([
                'skripsi_id' => $skripsi->id,
                'jenis' => 'proposal',
                'nama' => 'Proposal - '.$validated['judul'],
                'file_path' => $path,
                'file_size' => $request->file('proposal_file')->getSize(),
                'status' => 'uploaded',
                'uploaded_by' => $user->id,
                'uploaded_at' => now(),
            ]);
        }

        $mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_PENGAJUAN]);

        return redirect()->route('mahasiswa.pengajuan.index')->with('success', 'Pengajuan skripsi berhasil dikirim. Menunggu review pengelola.');
    }

    public function show(Skripsi $skripsi)
    {
        $skripsi->load(['mahasiswa.prodi', 'tahunAkademik', 'pembimbing.dosen', 'skPembimbing', 'ujian.penguji.dosen', 'lembarPengesahan']);

        return view('mahasiswa.pengajuan.show', compact('skripsi'));
    }

    public function update(Request $request, Skripsi $skripsi)
    {
        // Only allow update if still in pengajuan
        if ($skripsi->status !== 'pengajuan' && $skripsi->status !== 'ditolak') {
            return redirect()->back()->with('error', 'Skripsi tidak bisa diedit pada status ini.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:500',
            'deskripsi' => 'nullable|string',
            'bidang_kajian' => 'nullable|string|max:255',
        ]);

        $skripsi->update(array_merge($validated, ['status' => 'pengajuan', 'catatan_penolakan' => null]));
        $skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_PENGAJUAN]);

        return redirect()->route('mahasiswa.pengajuan.show', $skripsi)->with('success', 'Pengajuan diperbarui dan dikirim ulang.');
    }

    public function siapUjian(Request $request, Skripsi $skripsi)
    {
        $skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_SIAP_UJIAN]);

        return redirect()->back()->with('success', 'Status diperbarui: Siap Ujian. Menunggu penjadwalan dari pengelola.');
    }

    public function destroy(Skripsi $skripsi)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($skripsi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($skripsi->status !== 'pengajuan') {
            return redirect()->back()->with('error', 'Pengajuan skripsi hanya dapat dibatalkan jika masih berstatus pengajuan.');
        }

        $skripsi->delete();
        $mahasiswa->update(['status_skripsi' => 'draft']);

        return redirect()->route('mahasiswa.pengajuan.index')->with('success', 'Pengajuan skripsi berhasil dibatalkan.');
    }
}

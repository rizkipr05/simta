<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        // Get documents related to this dosen's bimbingan/penguji activities
        $skripsiIds = $dosen->pembimbingan()->pluck('skripsi_id')
            ->merge($dosen->pengujian()->with('ujian')->get()->pluck('ujian.skripsi_id'))
            ->unique()->filter();

        $dokumenList = Dokumen::whereIn('skripsi_id', $skripsiIds)
            ->with('skripsi.mahasiswa')
            ->latest()->paginate(20);

        return view('dosen.evidence.index', compact('dokumenList'));
    }

    public function download(Request $request, string $file)
    {
        $dokumen = Dokumen::where('file_path', $file)->firstOrFail();

        // Ensure dosen is related to this document
        return Storage::disk('public')->download($file, $dokumen->nama);
    }
}

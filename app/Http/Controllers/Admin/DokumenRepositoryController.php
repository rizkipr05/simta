<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class DokumenRepositoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokumen::with(['skripsi.mahasiswa', 'uploadedBy']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('skripsi.mahasiswa', function ($m) use ($search) {
                        $m->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nim', 'like', "%{$search}%");
                    });
            });
        }

        $dokumen = $query->latest()->paginate(15)->withQueryString();

        return view('admin.dokumen.index', compact('dokumen'));
    }
}

<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $notifikasiList = Notifikasi::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('mahasiswa.notifikasi.index', compact('notifikasiList'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id === auth()->id()) {
            $notifikasi->update(['is_read' => true]);
        }

        return redirect()->back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    public function markAllAsRead(Request $request)
    {
        Notifikasi::where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->route('mahasiswa.notifikasi.index')->with('success', 'Semua notifikasi telah dibaca.');
    }
}
